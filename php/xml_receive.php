<?php
//SESSION化
session_start();

//アップロード処理
$tempfile = $_FILES['file']['tmp_name'];
$filename = $_FILES['file']['name'];

if (is_uploaded_file($tempfile)) {
    if ( move_uploaded_file($tempfile , $filename )) {
	echo "OK";
    } else {
        echo "FAILED";
    }
} else {
    echo "NOENTRY";
} 

//文字列読み込み
$json = file_get_contents('c-score.json');

//BOM削除
$json = substr($json,2);

//ダブルクオーテーション変換
$json = str_replace('&quot;','"',$json);

//文字列コンバート
$json = mb_convert_encoding($json,'UTF-8','UTF-16LE');

//連想配列化
$array = json_decode($json, true);


//配列から参考・空白削除
$classes = array();
foreach($array as $arr_classes => $arr_class){
    $class_arr = array();
    $class_rank = 0;
    $class_team = "";
    foreach($arr_class as list($class_rank,$class_team)){
        if($class_rank === "参" or $class_rank === "" or $class_team === ""){
            
        }else{
            $class_rank = intval($class_rank);
            array_push($class_arr,array($class_team,$class_rank));
        }
    }
    
    var_dump($class_arr);
    print "<br><br>";
    
    array_push($classes,array($arr_classes => $class_arr));
}

//呼び出し
require_once('rank_input.php');
?>