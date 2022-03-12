<?php
//セッションを開始する
session_start();

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';


//変数初期化
$adult = '';
$child = '';
$order_user_email = '';
$receive_user_email = '';
$title = '';
$job = '';
$day = '';
$time ='';
$price = '';
$status = '';
$condition1 = '';
$condition2 = '';
$condition3 = '';
$condition4 = '';
$condition5 = '';
$community_id = '';
$errors = [];

//Submitされた場合
if (($_SERVER)['REQUEST_METHOD'] === 'POST') {
    //入力値を取得
    $community = filter_input(INPUT_POST, 'community');
    $title = filter_input(INPUT_POST, 'title');
    $job = filter_input(INPUT_POST, 'job');
    $day = filter_input(INPUT_POST, 'day');
    $time = filter_input(INPUT_POST, 'time');
    $price = filter_input(INPUT_POST, 'price');
    $adult = filter_input(INPUT_POST, 'adult');
    $child = filter_input(INPUT_POST, 'child');
    $condition1 = filter_input(INPUT_POST, 'condition1');
    $condition2 = filter_input(INPUT_POST, 'condition2');
    $condition3 = filter_input(INPUT_POST, 'condition3');
    $condition4 = filter_input(INPUT_POST, 'condition4');
    $condition5 = filter_input(INPUT_POST, 'condition5');
    $community_id = filter_input(INPUT_POST, 'community_id');

    $day = $day . ' ' . $time;   
    //エラーがない場合
    if (empty($errors)) {

        //ユーザーID（Email）を取得し設定
        $order_user_email = $_SESSION['email'];
        //Statusを未受注にする
        $status = '未受注';
        $_SESSION['email'];
        //委託業務をDBテーブルに登録
        $order_user = create_oreder(
            $adult,
            $child,
            $order_user_email,
            $receive_user_email,
            $title,
            $job,
            $day,
            $price,
            $status,
            $condition1,
            $condition2,
            $condition3,
            $condition4,
            $condition5,
            $community_id
        );
        // compelte_msg.php にリダイレクト
        header('Location: complete_msg.php?comment=委託登録');
        exit;
    }
}


?>


<!DOCTYPE html>
<html lang="ja">
<? include_once __DIR__ . '/header.html'; ?>

<body>
    <div class="wrapper">
        <div class="m-5"> 
        <div class="text-center mb-5">
            <h2>依頼内容</h2>
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
                <!-- 入力項目 -->
                <div class="form-group">
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="int" name="community_id" value="" placeholder="コミュニティ名" required><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" name="title" value="" placeholder="タイトル" required><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" name="job" value="" placeholder="業務内容"required><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" name="job" value="" placeholder="開始時刻"required><br>
                    <div class= "text-right">
                        <h6>※開始時刻の2時間前に、有効期限が切れます。</h6>
                    </div>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2"type="int" name="adult" value="" placeholder="大人" required><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="int" name="child" value="" placeholder="子供" required><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="date" name="day" value="" placeholder="日付" required><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="int" name="price" value="" placeholder="単価" required><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" name="condition1" value="" placeholder="条件１"><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" name="condition2" value="" placeholder="条件２"><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" name="condition3" value="" placeholder="条件３"><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" name="condition4" value="" placeholder="条件４"><br>
                    <label class="col-md-3 control-label"></label><input class="mb-2 mt-2" type="text" name="condition5" value="" placeholder="条件５"><br>
                    <div class="text-center">
                        <input type="submit" value="登録" class="btn btn-primary mt-4">
                    </div>
                </div>
            </form>
            <div class="text-center">
                <a href="index.php" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </div>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>