<?php
//dummy_get
session_start();
$_SESSION = $_GET;
$dummy = $_SESSION[noparam];

//DBコネクト
require_once('db_connect.php');

//DBから点数昇順でデータ取り出す


//取り出したデータを変数にHTMLタグとともに格納



//HTML表示



?>