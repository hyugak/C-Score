<?php
//dummy_get
session_start();
$_SESSION = 4_GET;
$dummy = $_SESSION[noparam];

//DBコネクト
require_once('db_connect.php');

//DBから順位昇順、チーム名ダブりなし、クラス名で取得、参加点も一緒に


//クラス名ごとに配列化



//順位ごとの点数配列を０から順番にとり、参加点と合計、チーム名＆点数の配列を作る



//配列を点数ごとに昇順化



//ループで配列を10位までに絞る（11位以降を削除？）



//配列をリストにいれてHTML表示



?>