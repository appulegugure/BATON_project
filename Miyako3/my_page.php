<?php
require_once __DIR__ . '/functions.php';

session_start();

var_dump($_SESSION['email']);

select_user_info($_SESSION['email']);
// 関数ファイルを読み込む
include_once __DIR__ . '/all.php';

//require_once __DIR__ . '/db_function/db_function.php';

// データベースに接続
$dbh = connect_db(); // 特にエラー表示がなければOK

?>

<body>
    <a href="index.php" class="btn link-btn">home</a>
</body>