<?php

session_start();
$user_id = $_SESSION['email'];


require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// idの受け取り
// $order_id = filter_input(INPUT_GET, 'order_id');
// //対象タスクの取得

$status = '取消済';

$orders_by_me = display_order_by_orderuser($user_id, $status);
$orders_to_me = display_order_by_receiveuser($user_id, $status);

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
<? include_once __DIR__ . '/header.html'; ?>
<link rel="stylesheet" href="transactions.css">

<body>
    <div class="border transactions_wrapper">
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
            <div class="mt-5 mb-3">
                <h3>委託中の業務</h3>
            </div>
                <?php foreach ($orders_by_me as $order) : ?>
                    <li>
                        <?= h($order['order_id']) ?>/
                        <?= h($order['title']) ?>/
                        <?= h($order['day']) ?>
                        <a href="display_order_by_me.php?order_id=<?= h($order['order_id']) ?>" class="btn btn-outline-primary">詳細</a>
                    </li>
                <?php endforeach; ?>
                
                <div class="mt-5 mb-3">
                    <h3>受注中の業務</h3>
                </div>
                <?php foreach ($orders_to_me as $order) : ?>
                    <li>
                        <?= h($order['order_id']) ?>/
                        <?= h($order['title']) ?>/
                        <?= h($order['day']) ?>
                        <a href="display_order_to_me.php?order_id=<?= h($order['order_id']) ?>" class="btn btn-outline-primary">詳細</a>
                    </li>
                <?php endforeach; ?>
        </ul>
        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-secondary">戻る</a>
        </div>
    </div>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>