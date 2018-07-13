<?php
var_dump($_FILES);

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
$fp = fopen('c-score.json','r');
while(!feof($fp)){
    $line = fgets($fp);
    $json = "{$json}{$line}";
}
fclose($fp);
//var_dump($json);

//文字列コンバート
$json = mb_convert_encoding($json,'UTF-8','UTF-16LE');

var_dump($json);

//文字列エスケープ処理
$json = addslashes($json);
var_dump($json);


echo "<br><br>";

//エンコード方法の調査
echo mb_detect_encoding($json);

//連想配列化
$array = json_decode($json, true);


//エラーチェック
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }




var_dump($array);
?>