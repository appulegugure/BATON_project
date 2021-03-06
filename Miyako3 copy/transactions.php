<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// idの受け取り
// $order_id = filter_input(INPUT_GET, 'order_id');
// //対象タスクの取得
session_start();
$user_id = $_SESSION['email'];
$orders_by_me = display_order_by_orderuser($user_id);
$orders_to_me = display_order_by_receiveuser($user_id);

//タスク更新処理
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $updated_title = filter_input(INPUT_POST, 'title');

    // $errors = update_validate($updated_title, $current_task);
    if (empty($errors)) {
        //注文ステータスの更新
        // $user_id = 2;
        // update_order($user_id, $order_id);
        // compelte_msg.php にリダイレクト
        header('Location: complete_msg.php?comment=受注');
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="ja">

<body>
    <div>
        <h2>取引中の仕事</h2>
        <!-- エラーがあったら表示 -->
        <!-- <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?> -->
        <ul>
            <h3>委託中ジョブ</h3>
            <p>注文番号/タイトル/日付/料金/コミュニティ</p>
            <?php foreach ($orders_by_me as $order) : ?>
                <li>
                    <a href="display_order_by_me.php?order_id=<?= h($order['order_id']) ?>" class="btn edit-btn">詳細</a>
                    <?= h($order['order_id']) ?>/
                    <?= h($order['title']) ?>/
                    <?= h($order['day']) ?>/
                    <?= h($order['price']) ?>円/
                    <?= h($order['community_id']) ?>

                </li>
            <?php endforeach; ?>
            <h3>受注中ジョブ</h3>
            <p>注文番号/タイトル/日付/料金/コミュニティ</p>
            <?php foreach ($orders_to_me as $order) : ?>
                <li>
                    <a href="display_order_to_me.php?order_id=<?= h($order['order_id']) ?>" class="btn edit-btn">詳細</a>
                    <?= h($order['order_id']) ?>/
                    <?= h($order['title']) ?>/
                    <?= h($order['day']) ?>/
                    <?= h($order['price']) ?>円/
                    <?= h($order['community_id']) ?>

                </li>
            <?php endforeach; ?>
        </ul>
        <a href="index.php" class="btn return-btn">戻る</a>

    </div>
</body>

</html>