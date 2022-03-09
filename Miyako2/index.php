<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';

// $keyword = $_GET['keyword'];
session_start();

//ログインユーザーのメールアドレスを取得する
$user_id = $_SESSION['email'];
//参加コミュニティを取得する
$community_list = search_community_by_user($user_id);

$community = '1';
$orders = select_order_by_community($community_list);

$errors = [];

if (empty($_GET['keyword'])) {
    $keyword = '';
} else {
    $keyword = $_GET['keyword'];
    // compelte_msg.php にリダイレクト
    header('Location: community_list.php?keyword=' . $keyword);
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">

<body>

    <form action="" method="GET">
        <h4>コミュニティを探す <input type="text" name="keyword" value="" placeholder="キーワードを入力して下さい">
            <input type="submit" value="検索" class="btn submit-btn">
        </h4>
    </form>

    <h1>募集中注文一覧</h1>

    <ul>
        <p>注文番号/タイトル/日付/料金/コミュニティ</p>
        <?php foreach ($orders as $order) : ?>
            <li>
                <a href="display_order.php?order_id=<?= h($order['order_id']) ?>" class="btn edit-btn">詳細</a>
                <?= h($order['order_id']) ?>/
                <?= h($order['title']) ?>/
                <?= h($order['day']) ?>/
                <?= h($order['price']) ?>円/
                <?= h($order['community']) ?>

            </li>
        <?php endforeach; ?>
    </ul>
    <a href="create_community.php" class="btn edit-btn">コミュニティを作る</a><br>
    <a href="create_order.php" class="btn edit-btn">仕事を委託する</a><br>
    <a href="transactions.php" class="btn edit-btn">取引中の仕事</a><br>
    <a href="mycommunity.php" class="btn edit-btn">参加コミュニティ一覧</a>
</body>

</html>