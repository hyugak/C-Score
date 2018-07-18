<?php
//DBコネクト
require_once('db_connect.php');

echo <<<EOT
<tr>
    <td>チーム名<td>
    <td>エントリーポイント<td>
</tr>
EOT;


//DB[rank]からレコードをIDの昇順で取り出す
//{id}{team}{entry}を取り出す
$query = 'SELECT id, team, entry FROM rank ORDER BY id ASC';
$sth = $dbh->prepare($query);
$sth->execute();

while($result = $sth->fetch(PDO::FETCH_ASSOC)){
    $id = $result['id'];
    $team = $result['team'];
    $entry = $result['entry'];

//printする（htmlひな形は以下の通り）
echo <<<EOT
<tr>
    <form method="post" action="../php/ad_entry_resubmit.php">
        <td><input type="text" name="team" value="{$team}"><td>
        <td><input type="number" name="entry" value="{$entry}"><td>
        <td>
            <input type="hidden" name="id" value="{$id}">
            <input type="submit" value="変更">
        </td>
    </form>    
</tr>
EOT;
}
?>


