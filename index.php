<?php


// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';

require_once __DIR__ . '/db_function.php';

// データベースに接続
$dbh = connect_db(); // 特にエラー表示がなければOK

session_start();

//select_user_info()テスト
echo '<hr>';
echo '<h2>select_user_info($_SESSION["email"])テスト</h2>';
echo '<br>';
echo '<pre>';
var_dump(select_user_info($_SESSION['email']));
echo '</pre>';
echo '<he>';


echo '<hr>';
echo '<h2>select_user_info($_SESSION["email"])テスト</h2>';
echo '<br>';
echo '<pre>';
var_dump(select_community_info(1));
echo '</pre>';
echo '<he>';


?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_header.html' ?>
<body>
    <h1> -- BATON -- </h1>
    <a href="my_page.php" class="btn link-btn">ユーザーインフォ</a>
</body>
</html>