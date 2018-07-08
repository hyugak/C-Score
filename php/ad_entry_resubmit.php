<?php
//DBコネクト
require_once('db_connect.php');

//セッション化
session_start();
$_SESSION = $_POST;

//データ取り出し
$id = $_SESSION['id'];
$id = $_SESSION['team'];
$id = $_SESSION['entry'];

//DB[rank]からIDで検索、$teamと$entryを
//DB[rank]の「team」「entry」にUPDATEで挿入
//エラー発生時は「../ad/index.php」にリダイレクト(try-catchを使う？)


//セッション終了
session_destroy();
?>