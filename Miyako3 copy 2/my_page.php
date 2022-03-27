<?php
require_once __DIR__ . '/functions.php';

session_start();

select_user_info($_SESSION['email']);
// 関数ファイルを読み込む

require_once __DIR__ . '/functions.php';
// require_once __DIR__ . '/db_function/db_function.php';

?>
<!DOCTYPE html>
<html lang="ja">

<? include_once __DIR__ . '/header.html'; ?>
<link rel="stylesheet" href="my_page.css">

<body>
    <div class="my_page_wrapper">
        <div class="text-center mb-5">
            <h1>マイページ</h1>
        </div>
        <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" placeholder="名前"><br>
        <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" placeholder="会社名"><br>
        <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" placeholder="法人の有無"><br>
        <label class="col-md-3 control-label"></label><textarea class="mb-2 mt-2" type="text" placeholder="サービスの内容"></textarea><br>
        <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" placeholder="会社の所在地"><br>
        <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" placeholder="社員数"><br>
        <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" placeholder="創立年月日"><br>
        <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" placeholder="参加中のコミュニティ"><br>
        <label class="col-md-3 control-label"></label><textarea class="mb-2 mt-2" type="text" placeholder="会社の実績"></textarea><br>
        <div class="text-center">
            <a href="index.php" class="btn btn-secondary mt-5">戻る</a>
        </div>
    </div>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>
