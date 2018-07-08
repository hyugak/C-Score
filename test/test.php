<?php
var_dump($_FILES);

//TEMPのURL取得
$url = $_FILES['file']['tmp_name'];

var_dump($url);

//文字列読み込み
$json = file_get_contents($url);

var_dump($json);

//文字列コンバート
$json = mb_convert_encoding($json,'UTF-8','UTF-16LE');

var_dump($json);

//連想配列化
$array = json_decode($json,true);

var_dump($array);

$file = 'test.txt';
file_put_contents($file,$array);
?>