<?php


// 関数ファイルを読み込む
require_once '/var/www/html/BATON' . '/functions.php';

require_once '/var/www/html/BATON' . '/db_function.php';

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
echo '<h2>select_community_info($_SESSION["id"])テスト</h2>';
echo '<br>';
echo '<pre>';
var_dump(select_community_info('appulegugure@gmail.com'));
echo '</pre>';
echo '<he>';


echo '<hr>';
echo '<h2>select_search_community_word($input_word)テスト</h2>';
echo '<br>';
echo '<pre>';
var_dump(select_search_community_word(5));
echo '</pre>';
echo '<he>';


echo '<hr>';
echo '<h2>select_search_community($user_email)テスト</h2>';
echo '<br>';
echo '<pre>';
var_dump(select_search_community('appulegugure@gmail.com'));
echo '</pre>';
echo '<he>';


echo '<hr>';
echo '<h2>select_community_all()テスト</h2>';
echo '<br>';
echo '<pre>';
var_dump(select_community_all());
echo '</pre>';
echo '<he>';


//insert_community_user(6,'appulegugure@gmail.com');
echo '<hr>';
create_community('musukadai','appulegugure@gmail.com','1','2','3','4','5','content');
echo '<hr>';
create_order(1,2,'appulegugure@gmail.com','baton@gmail.com','safin','sea','2020/01/22,20',6,'reject','con1','con2','con3','con4','con5',1);
echo '<hr>';
?>



<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_header.html' ?>
<body>
    <h1> -- BATON -- </h1>
    <a href="my_page.php" class="btn link-btn">ユーザーインフォ</a>
</body>
</html>