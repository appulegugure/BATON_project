<?php

include_once __DIR__ . '/all.html';
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
$orders = select_order_by_status();

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
<head>
    <style> 
        .h1{
            text-align: center;
        }
        .wrapper {
            width: 700px;
            margin: 30px auto;
            padding: 40px 50px;
            border: 1px solid #dfdfdc;
            border-radius: 5px;
        }

    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="container">
                <div class="container w-auto text-right">
                    <div class="border" style="padding:30px;">
                        <form>
                            <div><input type="text" style="width: 370px;" placeholder="コミュニティを探す">
                                <a href="community_list.php"><i class="fa-solid fa-magnifying-glass btn btn-dark"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container">
                <h1>募集中委託業務一覧</h1>
                <!-- エラーがある場合 -->
                <?php if (!empty($errors)) : ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= h($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="container border">
                <ul>
                    <p>注文番号/タイトル/日付/料金/コミュニティ</p>
                    <?php foreach ($orders as $order) : ?>
                            <li>
                                <div class="row border">
                                    <!-- 表示する項目は後で調整 -->
                                    <div class="bg- col p-1 mb-2 text-black">
                                        <br><?= h($order['order_id']) ?>/
                                    </div>
                                    <div class="bg- col p-1 mb-2 text-black">
                                        <br><?= h($order['title']) ?>/
                                    </div>
                                    <div class="bg- col p-1 mb-2 text-black">
                                        <br><?= h($order['day']) ?>/
                                    </div>
                                    <div class="bg- col p-1 mb-2 text-black">
                                        <br><?= h($order['price']) ?>円/
                                    </div>
                                    <div class="bg- col p-1 mb-2 text-black">
                                        <br>
                                    </div><?= h($order['community_id']) ?>
                                    <!-- display_order.phpに遷移してOrder IDを渡す -->
                                    <a href="display_order.php?order_id=<?= h($order['order_id']) ?>" class="btn btn-outline-primary">詳細</a>
                                </div>
                            </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="container nowrap">
                <div class="row"> 
                    <div class="btn btn-danger">    
                        <a href="create_order.php"><div class="col text-white">BATON<br>ーーーーー<br>委託する</div></a>
                    </div>
                    <div class="btn btn-default">
                        <div class="col p-1 mb-2 text-black">
                            <a href="create_community.php"><i class="fa-solid fa-user-group fa-1x"></i><br>コミュニティ作成</a>
                        </div>
                    </div>
                    <div class="btn btn-default">
                        <div class="col p-1 mb-2 text-black">
                            <a href="transactions.php"><i class="fa-regular fa-rectangle-list fa-1x"></i><br>取引中の仕事</a>
                        </div>
                    </div>
                    <div class="btn btn-default">
                        <div class="col p-1 mb-2 text-black">
                            <a href="my_page.php"><i class="fa-solid fa-user fa-1x"></i><br>マイページ</a>
                        </div>
                    </div>
                    <div class="btn btn-default">
                        <div class="col p-1 mb-2 text-black">
                            <a href="my_community"><i class="fa-solid fa-user fa-1x"></i><br>参加コミュニティ</a>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</body>

</html>

