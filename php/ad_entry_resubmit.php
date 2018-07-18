<?php
//DBコネクト
require_once('db_connect.php');

//セッション化
session_start();
$_SESSION = $_POST;

//データ取り出し
$id = $_SESSION['id'];
$team = $_SESSION['team'];
$entry = $_SESSION['entry'];

echo "{$id}, {$team}, {$entry}";
//DB[rank]からIDで検索、$teamと$entryを
//DB[rank]の「team」「entry」にUPDATEで挿入
//エラー発生時は「../ad/index.php」にリダイレクト(try-catchを使う？)
$query = "UPDATE rank SET entry={$entry}, team='{$team}' WHERE id={$id}";
$sth = $dbh->prepare($query);
$sth->execute();

//セッション終了
session_destroy();
?>
