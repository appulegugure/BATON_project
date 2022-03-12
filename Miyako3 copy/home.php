<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';

// データベースに接続
$dbh = connect_db(); // 特にエラー表示がなければOK


?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_header.html' ?>
<body>
    <h1> -- BATON -- </h1>
    <h5>エラーでてなければOK</h5>
</body>
</html>