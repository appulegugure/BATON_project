<?php


// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';
//require_once __DIR__ . '/db_function/db_function.php';

// データベースに接続
$dbh = connect_db(); // 特にエラー表示がなければOK

session_start();

var_dump($_SESSION['email']);

?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_header.html' ?>
<body>
    <h1> -- BATON -- </h1>
    <a href="my_page.php" class="btn link-btn">ユーザーインフォ</a>
</body>
</html>