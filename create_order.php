<?php

include_once __DIR__ . '/all.html';
require_once __DIR__ . '/db_function.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// idの受け取り
$id = filter_input(INPUT_GET, 'id');
//対象タスクの取得
// $current_task = find_task_by_id($id);

//タスク更新処理
$community = '';
$order_user = '';
$title = '';
$job  = '';
$day  = '';
$price  = '';
$errors = [];

if (($_SERVER)['REQUEST_METHOD'] === 'POST') {
    $community = filter_input(INPUT_POST, 'community');
    // $order_user = filter_input(INPUT_POST, 'order_user');
    $title = filter_input(INPUT_POST, 'title');
    $job = filter_input(INPUT_POST, 'job');
    $day = filter_input(INPUT_POST, 'day');
    $price = filter_input(INPUT_POST, 'price');
    $adult = filter_input(INPUT_POST, 'adult');
    $child = filter_input(INPUT_POST, 'child');
    $community_id = filter_input(INPUT_POST, 'community_id');

    if (empty($errors)) {
        //タスク内容の編集
        // create_order($community, $order_user, $title, $job, $day, $price)
        $order_user = 2;
        //create_order();
        // compelte_order.php にリダイレクト
        header('Location: /complete_order.php');
        //exit;
    }
}

?>


<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="create_order.css" />

<body>
    <div class="wrapper">
        <h2>依頼内容</h2>
        <!-- エラーがあったら表示 -->
        <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="post">
            <select name="" id="">
                <option value="community">委託するコミュニティ</option><br>
            </select><br>
            <!-- ユーザー<input type="text" name="order_user" value=""><br> -->
            <input type="text" name="title" placeholder="タイトル"><br>
            <input type="text" name="adult" placeholder="大人"><br>
            <input type="text" name="child" placeholder="子供"><br>
            <input type="text" name="community_id" placeholder="流すコミュニティ"><br>

            <input type="text" name="job" placeholder="業務内容"><br>
            開催日<input type="date" name="day" placeholder="業務内容"><br>
            <input type="text" name="time" placeholder="開始時刻">※開始時刻の2時間前に有効期限が切れます。<br>
            <input type="text" name="price" placeholder="料金"><br>
            <input type="text" name="condition1" placeholder="条件１"><br>
            <input type="text" name="condition2" placeholder="条件２"><br>
            <input type="text" name="condition3" placeholder="条件３"><br>
            <input type="text" name="condition4" placeholder="条件４"><br>
            <input type="text" name="condition5" placeholder="条件５"><br>
            <input type="submit" value="登録" class="btn submit-btn">
        </form>
        <a href="index.php" class="btn return-btn">戻る</a>
    </div>
</body>
</html>
