<?php
/*
 * $classes -> [:class_name =>[[$team, $rank],[$team, $rank], ... [$team, $rank]] 
 * みたいな、配列の連想配列だと嬉しい
 * 下のような感じで
 */
/*
$classes = ['MXJ' => [['OLK', 1], ['OLC',1],['KOLC', 1 ],['tohoku', 4 ],['tsukuba', 5 ],['tortise', 6 ],['ClubAjari',6],['tohoku',6],['OLC', 6]],
            'WXJ' => [['OLK',1 ], ['KOLC',2], ['OLC', 3 ],['San-Susi', 4 ],['tsukuba', 5 ],['tortise', 6 ],]];
*/

//DBコネクト
require_once('db_connect.php');

//順位ごとの点数配列を０から順番にとり、参加点と合算し、チーム名＆点数の配列を作る

# $team_scores : key=チーム名, val=点数 の連想配列.DBへはこれを基にクエリを投げる 
$team_scores = array();

# $team_scores をrankテーブルから初期化
$query = "SELECT team, entry FROM rank";
$sth = $dbh->prepare($query);
$sth->execute();
while($result = $sth->fetch(PDO::FETCH_NUM)){
    $team = $result[0];
    $entry_point = $result[1];
    $team_scores[$team] += $entry_point;
}



foreach ($classes as $class_name => $class){
    $awards = array();   # 各得点対象チームの連想配列の配列。各チームの連想配列は[:team, :rank]
    $len_awards = 0;     # $awardsの長さ。現段階での得点対象チームの数に対応。
    $pre_team_rank =0;   # 一つ前のチームの順位。同着処理に使用。
    $team_rank = 1;      # 見ているチームの順位。同着処理に使用。
    $rank_buffer = 0;    # 同着の場合、次の順位がどれだけ飛ぶかに対応。同着処理に使用。
    $pre_rank = 0;       # 前回の個人データのクラス内での順位。同着処理に使用。
    $border = 6;         # 得点対象チームの基本の数。 

    # Eクラスの得点対象チームの数
    if(strcmp($class_name,'ME')==0 || strcmp($class_name, 'WE')==0){
        $border = 12;
    }

    //もっと早くできそう()
    foreach($class as list($team, $rank)){
        $len_awards = count($awards);

        # これまでに得点対象に確定したチーム数がborderより少ない場合
        if ($len_awards < $border) {
            # ダブりがない場合
            if (!in_array($team, array_column($awards,'team'))){
                # 前回確定したチームと同着の場合
                if($rank == $pre_rank){
                   $team_rank = $pre_team_rank;
                   $rank_buffer++;
                }
                # 前回確定したチームと同着でない場合
                else{
                    $team_rank = $pre_team_rank + $rank_buffer + 1;
                    $pre_team_rank = $team_rank;
                    $rank_buffer = 0;
                }
                array_push($awards, array('team'=>$team, 'rank'=>$team_rank));
            }
        }

        # $border に同着がいた場合、表彰人数が増えるのでその処理
        else{
            # ダブりがない場合
            if (!in_array($team, array_column($awards,'team'))){
                # 同着の場合
                if($rank == $pre_rank){
                    $team_rank = $pre_team_rank;
                    array_push($awards, array('team'=>$team, 'rank'=>$team_rank));
                }
                # 同着でない場合
                else{
                    break;
                }
            }
        }
        $pre_rank = $rank; # 次のループでの同着処理に使用
    }
    # 点数加算処理
    $team_scores = add_point($dbh, $class_name, $team_scores, $awards);
}

# $awardsと[point]tableを基に、$team_scoresに点数を加算
function add_point($dbh, $class_name, $team_scores, $awards){
    $query = "SELECT point, rank FROM point WHERE class like '$class_name' ORDER BY rank";
    $sth = $dbh->prepare($query);
    $sth->execute(); 

    $result  = $sth->fetchAll();  # $result : [:point, :rank]の連想配列の配列が格納

    $i = 0;

    # $rule = [:point, :rank], ランクとポイントの対応を格納する連想配列
    foreach($result as $rule){
        while($awards[$i]['rank'] == $rule['rank']){
            $team_scores[$awards[$i]['team']] += $rule['point'];
            $i++;
        }
    }
    return $team_scores;
}
print_r($team_scores);
//配列をDB登録
$query = "UPDATE rank SET score = :score WHERE team = :team";
$sth = $dbh->prepare($query);
foreach($team_scores as $team => $score){
    $sth->bindValue(':score', $score, PDO::PARAM_INT);
    $sth->bindValue(':team', $team, PDO::PARAM_STR);
    $sth->execute();
}


// 以下はdb_output.phpでクエリ投げるときにソートすればいい？

// 配列を点数ごとに昇順化 
// ループで配列を10位までに絞る（11位以降を削除？）

?>
