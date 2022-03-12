<?php

//セッション開始
session_start();

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';


//変数初期化
$community_name = '';
$user_id = '';
$condition1 = '';
$condition2 = '';
$condition3 = '';
$condition4 = '';
$condition5 = '';
$community_content = '';
$errors = [];

//Submitされた場合
if (($_SERVER)['REQUEST_METHOD'] === 'POST') {
    //入力値を変数に設定
    $community_name = filter_input(INPUT_POST, 'community_name');
    $condition1 = filter_input(INPUT_POST, 'condition1');
    $condition2 = filter_input(INPUT_POST, 'condition2');
    $condition3 = filter_input(INPUT_POST, 'condition3');
    $condition4 = filter_input(INPUT_POST, 'condition4');
    $condition5 = filter_input(INPUT_POST, 'condition5');
    $community_content = filter_input(INPUT_POST, 'community_content');

    //エラーがない場合
    if (empty($errors)) {

        //ユーザーID(Email)を取得し変数に設定
        $user_id = $_SESSION['email'];
        //コミュニティテーブルに登録し、Community IDを取得
        $community_id = create_community($community_name, $user_id, $condition1, $condition2, $condition3, $condition4, $condition5, $community_content);
        //コミュニティ・ユーザテーブルに登録
        $owner_flag = 1;
        create_community_user($community_id, $user_id, $owner_flag);
        // compelte_msg.php にリダイレクト
        header('Location: complete_msg.php?comment=コミュニティ登録');
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/all.html'; ?>

<body>
    <div class="wrapper">
        <div class="text-center mb-5">
            <h2>コミュニティ作成</h2>
        </div>
            <!-- エラーがあったら表示 -->
            <?php if (!empty($errors)) : ?>
                <ul class="errors">
                    <?php foreach ($errors as $error) : ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form action="" method="post" class="form-horizontal">
                <div class="form-group mb-5">
                    <!--入力項目-->
                    <label class="col-md-3 control-label"></label><input type="text" name="community_name" value="" placeholder="コミュニティ名"><br>
                    <label class="col-md-3 control-label"></label><input type="text" name="condition1" value="" placeholder="参加条件１"><br>
                    <label class="col-md-3 control-label"></label><input type="text" name="condition2" value="" placeholder="参加条件２"><br>
                    <label class="col-md-3 control-label"></label><input type="text" name="condition3" value="" placeholder="参加条件３"><br>
                    <label class="col-md-3 control-label"></label><input type="text" name="condition4" value="" placeholder="参加条件４"><br>
                    <label class="col-md-3 control-label"></label><input type="text" name="condition5" value="" placeholder="参加条件５"><br>
                    <label class="col-md-3 control-label"></label><input type="text" name="community_content" value="" placeholder="内容"><br>
                </div>
            </form>
            <div class="text-center mb-3">
                <input type="submit" value="登録" class="btn btn-primary">
            </div>
            <div class="text-center">
                <a href="index.php" class="btn btn-secondary">戻る</a>
            </div>
    </div>
</body>

</html>