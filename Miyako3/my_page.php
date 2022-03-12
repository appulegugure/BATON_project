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
<? include_once __DIR__ . '/header.html'; ?>

<body>
    <a href="index.php" class="btn return-btn">戻る</a>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>