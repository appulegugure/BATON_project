<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// Order IDの受け取り
$order_id = filter_input(INPUT_GET, 'order_id');
//Order IDをキーに委託業務の詳細を取得
$order = display_order_2($order_id);
// $order = display_order($order_id);

//エラー変数初期化
$errors = [];

//Submitされた場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validation必要なら追加する
    //エラーがない場合
    if (empty($errors)) {
        //セッションを開始する
        session_start();
        //ユーザーID（Email)を取得
        $user_id = $_SESSION['email'];
        $status = '受注済';
        //委託業務の受注ユーザーとステータスを更新
        update_order($user_id, $order_id, $status);
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
            <!-- 表示項目は要調整。Nullの場合の処理追加 -->
            注文番号:<?= h($order['order_id']) ?><br>
            大人:<?= h($order['adult']) ?><br>
            子供:<?= h($order['child']) ?><br>
            コミュニティ:<?= h($order['community_id']) ?><br>
            ユーザー:<?= h($order['order_user_email']) ?><br>
            タイトル:<?= h($order['title']) ?><br>
            ジョブ:<?= h($order['job']) ?><br>
            日付: <?= h($order['day']) ?><br>
            料金: <?= h($order['price']) ?><br>
            <!-- 条件1: <?= h($order['condition1']) ?><br>
            条件2: <?= h($order['condition2']) ?><br>
            条件3: <?= h($order['condition3']) ?><br>
            条件4: <?= h($order['condition4']) ?><br>
            条件5: <?= h($order['condition5']) ?><br> -->
            <br>
            <input type="submit" value="受注する" class="btn submit-btn">
        </form>
        <a href="index.php" class="btn return-btn">戻る</a>

    </div>
</body>

</html>