<?php
//dummy_get
session_start();
$_SESSION = $_GET;
$dummy = $_SESSION['noparam'];

//DBコネクト
require_once('db_connect.php');

//DBから点数昇順でデータ取り出す
$query = "SELECT * FROM rank ORDER BY score ASC";
$row = $dbh->query($query);

//取り出したデータを変数にHTMLタグとともに格納
foreach($row as $rows){
    $score = $rows['score'];    #合計点を取り出し
    $team = $rows['team'];      #チーム名を取り出し
    
    $print_html = "<tr><td><h5>{$team}</h5></td><td><h5>{$score}pt</h5></td></tr>{$print_html}";
}


//HTML表示
print "{$print_html}";

?>