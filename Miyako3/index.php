<?php
//セッション処理を開始
session_start();
//ログインユーザーのメールアドレスを取得する
$user_id = $_SESSION['email'];
// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';
//require_once __DIR__ . '/db.functions.php';

// $keyword = $_GET['keyword'];

//ユーザーの参加コミュニティを取得する
// $community_list = search_community_by_user($user_id);
$community_list = select_search_community($user_id);

//参加コミュニティ内の委託業務で未受注のものを取得する
// var_dump($community_list);
$status = '未受注';
// $orders = select_order_by_status($status, $user_id);
$orders = select_order_by_community($status, $community_list, $user_id);


//滝斗変更
//追加
$community_list = $_SESSION['community'];
$community_list_sql = convert_from_array_to_sqlstring($community_list);
$orders_2 = select_order_community_and_status('未受注',$community_list_sql);
//var_dump($orders_2);    


//二時間以内削除
two_hours_order_set_reject();

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
<? include_once __DIR__ . '/header.html'; ?>
<link rel="stylesheet" href="index.css">

<body>
    <div class="wrapper">
        <form>
            <div><input type="text" name="keyword" style="width: 500px;" placeholder="コミュニティを探す" required>
                <!-- <a href="community_list.php"><i class="fa-solid fa-magnifying-glass btn btn-dark"></i></a> -->
                <input type="submit" value="&#xf002;" class="fa-solid fa-magnifying-glass btn btn-dark">
            </div>
        </form>

        <div class="container">
            <div class="text-right mb-2">
                新着順
                <div class="btn btn-light">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <div class="window">
            <!-- エラーがある場合 -->
            <?php if (!empty($errors)) : ?>
                <ul class="errors">
                    <?php foreach ($errors as $error) : ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <ol>
                <?php foreach ($orders_2 as $order) : ?>
                    <li>
                        <div class="row order_btn">
                            <!-- 表示する項目は後で調整 -->
                            <div class="title_btn">
                                <?= h($order['title']) ?>
                            </div>
                            <div class="day_btn">
                                <?= h($order['day']) ?>
                            </div>
                            <div class="price_btn">
                                ￥<?= h($order['price']) ?>
                            </div>
                            <div class="adult_btn">
                                大人:<?= h($order['adult']) ?>
                            </div>
                            <div class="child_btn">
                                小人:<?= h($order['child']) ?>
                            </div>
                            <!-- display_
                            order.phpに遷移してOrder IDを渡す -->
                            <a href="display_order.php?order_id=<?= h($order['order_id']) ?>" class="detail_btn">詳細</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>

        <div class="container nowrap">
            <div class="row info_btn">
                <div class="btn btn-sm btn-light">
                    <a href="create_order.php">

                        <div class="logo">ワンタッチで<br>業務委託!<br>
                            <h4>BATON</h4>
                        </div>
                    </a>
                </div>
                <div class="info">
                    <div class="btn btn-light">
                        <div class="col p-1 mb-2">
                            <a href="create_community.php"><i class="fa-solid fa-plus"></i><br>コミュニティ作成</a>
                        </div>
                    </div>
                    <div class="btn btn-light">
                        <div class="col p-1 mb-2">
                            <a href="transactions.php"><i class="fa-regular fa-rectangle-list fa-1x"></i><br>取引中の仕事</a>
                        </div>
                    </div>
                    <div class="btn btn-light">
                        <div class="col p-1 mb-2">
                            <a href="mycommunity.php"><i class="fa-solid fa-user-group fa-1x"></i><br>参加コミュニティ</a>
                        </div>
                    </div>
                    <div class="btn btn-light">
                        <div class="col p-1 mb-2">
                            <a href="my_page.php"><i class="fa-solid fa-user fa-1x"></i><br>マイページ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <? include_once __DIR__ . '/js.html'; ?>

</body>

</html>