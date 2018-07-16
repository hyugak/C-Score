<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>C-Score</title>
        <link href="https://github.com/necolas/normalize.css/blob/master/normalize.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
        <link href="style.css" rel="stylesheet">
    </head>
    <body onload="executeA('optionlist','php/ad_all_list.php','noparam=noparam','get');"> 
        <div style="text-align:center;font-size:2em;" class="container centered" id="display"></div>
        <table class="container centered">
            <thead>
                <tr>
                    <th>チーム名</th>
                    <th>参加点</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="optionlist">
            </tbody>
        </table>
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>
        <script src="../js/ajax.js"></script>
    </body>
</html>