<?php

// 関数ファイルを読み込む
// require_once __DIR__ . '/db.functions.php';
require_once __DIR__ . '/functions.php';

// $keyword = $_GET['keyword'];

//セッション処理を開始
session_start();
//ログインユーザーのメールアドレスを取得する
$user_id = $_SESSION['email'];

//ユーザーの参加コミュニティを取得す
// $community_list = search_community_by_user($user_id);
$community_list = select_search_community($user_id);

//参加コミュニティ内の委託業務で未受注のものを取得する
//けど、上手く動かないから全取得している。後で直す
// $orders = select_order_by_community($community_list);
$status = '未受注';
$orders = select_order_by_status($status);

$errors = [];
//対象の委託業務がない場合
if (empty($orders)) {
    //募集中の注文はありません (後でConstantに入れる)
    $errors[] = '募集中の注文はありません';
}


//コミュニティ検索語句がNULLの場合
if (empty($_GET['keyword'])) {
    $keyword = '';
} else {
    $keyword = $_GET['keyword'];
    // community_list.php にリダイレクト
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

    <h1>募集中委託業務一覧</h1>
    <!-- エラーがある場合 -->
    <?php if (!empty($errors)) : ?>
        <ul class="errors">
            <?php foreach ($errors as $error) : ?>
                <li><?= h($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <ul>
        <p>注文番号/タイトル/日付/料金/コミュニティ</p>
        <?php foreach ($orders as $order) : ?>
            <li>
                <!-- display_order.phpに遷移してOrder IDを渡す -->
                <a href="display_order.php?order_id=<?= h($order['order_id']) ?>" class="btn edit-btn">詳細</a>
                <!-- 表示する項目は後で調整 -->
                <?= h($order['order_id']) ?>/
                <?= h($order['title']) ?>/
                <?= h($order['day']) ?>/
                <?= h($order['price']) ?>円/
                <?= h($order['community_id']) ?>

            </li>
        <?php endforeach; ?>
    </ul>
    <!-- create_community.phpに遷移する -->
    <a href="create_community.php" class="btn edit-btn">コミュニティを作る</a><br>
    <!-- create_order.phpに遷移する -->
    <a href="create_order.php" class="btn edit-btn">仕事を委託する</a><br>
    <!-- transactions.phpに遷移する -->
    <a href="transactions.php" class="btn edit-btn">取引中の仕事</a><br>
    <!-- mycommunity.phpに遷移する -->
    <a href="mycommunity.php" class="btn edit-btn">参加コミュニティ一覧</a>
</body>

</html>