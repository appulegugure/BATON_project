<?php
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

    if (empty($errors)) {
        //タスク内容の編集
        // create_order($community, $order_user, $title, $job, $day, $price)
        session_start();
        $order_user = $_SESSION['email'];
        create_order_2($community, $order_user, $title, $job, $day, $price);
        // create_oreder($adult, $child, $title, $day, $number_of_peaple_id, $price, $Contents, $Prerequisite);
        // compelte_msg.php にリダイレクト
        header('Location: complete_msg.php?comment=委託登録');
        exit;
    }
}


?>


<!DOCTYPE html>
<html lang="ja">


<body>
    <div>
        <h2>委託登録</h2>
        <!-- エラーがあったら表示 -->
        <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="post">
            コミュニティ番号<input type="int" name="community" value=""><br>
            <!-- ユーザー<input type="text" name="order_user" value=""><br> -->
            タイトル<input type="text" name="title" value=""><br>
            ジョブ<input type="text" name="job" value=""><br>
            日付<input type="date" name="day" value=""><br>
            料金 <input type="text" name="price" value=""><br>
            <input type="submit" value="登録" class="btn submit-btn">
        </form>
        <a href="index.php" class="btn return-btn">戻る</a>

    </div>
</body>

</html>