<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// idの受け取り
$order_id = filter_input(INPUT_GET, 'order_id');
//対象タスクの取得
$order = display_order_2($order_id);

//タスク更新処理
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $updated_title = filter_input(INPUT_POST, 'title');

    // $errors = update_validate($updated_title, $current_task);
    if (empty($errors)) {
        //注文ステータスの更新
        session_start();
        $user_id = $_SESSION['email'];
        update_order($user_id, $order_id);
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
        <h2>募集中委託詳細</h2>
        <!-- エラーがあったら表示 -->
        <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="post">
            注文番号:<?= h($order['order_id']) ?><br>
            コミュニティ:<?= h($order['community']) ?><br>
            ユーザー:<?= h($order['order_user']) ?><br>
            タイトル:<?= h($order['title']) ?><br>
            ジョブ:<?= h($order['job']) ?><br>
            日付: <?= h($order['day']) ?><br>
            料金: <?= h($order['price']) ?><br>
            <br>
            <input type="submit" value="受注する" class="btn submit-btn">
        </form>
        <a href="index.php" class="btn return-btn">戻る</a>

    </div>
</body>

</html>