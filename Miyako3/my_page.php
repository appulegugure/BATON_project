<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';
// require_once __DIR__ . '/db_function/db_function.php';


session_start();
// var_dump($_SESSION['email']);

select_user_info($_SESSION['email']);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="index.php" class="btn return-btn">戻る</a>
</body>

</html>