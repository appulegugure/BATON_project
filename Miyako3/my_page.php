<?php
require_once __DIR__ . '/functions.php';

session_start();

select_user_info($_SESSION['email']);
// 関数ファイルを読み込む
include_once __DIR__ . '/all.html';

//require_once __DIR__ . '/db_function/db_function.php';

// データベースに接続
$dbh = connect_db(); // 特にエラー表示がなければOK
?>
<!DOCTYPE html>
<html lang="ja">

<head>

</head>

<body>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="名前"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="会社名"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="法人の有無"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="サービス内容"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="会社の強み"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="会社の所在地"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="創立年月日"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="会社の規模"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="参加中のコミュニティ"><br>
    <label class="col-md-5 control-label"></label><input type="text" placeholder="会社の実績"><br>
    <div class="text-center">
        <a href="index.php" class="btn btn-secondary">戻る</a>
    </div>
</body>

</html>