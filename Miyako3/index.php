<?php

//セッション処理を開始
session_start();
//ログインユーザーのメールアドレスを取得する
$user_id = $_SESSION['email'];

include_once __DIR__ . '/all.html';
// 関数ファイルを読み込む
// require_once __DIR__ . '/db.functions.php';
require_once __DIR__ . '/functions.php';

// $keyword = $_GET['keyword'];



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
        .a {
            background-color: #ccffff; 
        }
        .b{
            background-color: #ccffcc;
        }
        .c{
            background-color: #ffffcc;
        }
        .d{
            background-color: #ffcc99;
        }
        .e{
            background-color: #ffccff;
        }
        .btnbtn{
            color: red;
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
                            <div><input type="text" style="width: 340px;" placeholder="コミュニティを探す">
                                <a href="community_list.php"><i class="fa-solid fa-magnifying-glass btn btn-dark"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container">
                <h1 class="mt-5 mb-3">業務 一覧</h1>
                <div class="text-right mb-2">
                    新着順
                    <div class="btn btn-light">
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
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
                    <?php foreach ($orders as $order) : ?>
                            <li>
                                <div class="row">
                                    <!-- 表示する項目は後で調整 -->
                                    <div class="a col mb-2 mr-1 text-center">
                                        <br><?= h($order['order_id']) ?>
                                    </div>
                                    <div class="b col mb-2 mr-1 text-center">
                                        <br><?= h($order['title']) ?>
                                    </div>
                                    <div class="c col mb-2 mr-1 text-center">
                                        <br><?= h($order['day']) ?>
                                    </div>
                                    <div class="d col mb-2 mr-1 text-center">
                                        <br><?= h($order['price']) ?>円
                                    </div>
                                    <div class="e col mb-2 mr-1 text-center">
                                        <br><?= h($order['community_id']) ?>
                                    </div>

                                    <!-- display_order.phpに遷移してOrder IDを渡す -->
                                    <a href="display_order.php?order_id=<?= h($order['order_id']) ?>" class="btn btn-outline-primary btn-sm">詳細</a>
                                </div>
                            </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="container nowrap">
                <div class="row"> 
                    <div class="btn btn-sm btn-light mr-2">    
                        <a href="create_order.php"><div class="btnbtn">ワンタッチで<br>業務委託!<br><h4>BATON</h4></div></a>
                    </div> 
                    <div class="btn btn-default btn-light">
                        <div class="col p-1 mb-2 text-black mr-1 ml-1">
                            <a href="create_community.php"><i class="fa-solid fa-user-group fa-1x"></i><br>コミュニ<br>ティ作成</a>
                        </div>
                    </div>
                    <div class="btn btn-default btn-light">
                        <div class="col p-1 mb-2 text-black mr-1 ml-1">
                            <a href="transactions.php"><i class="fa-regular fa-rectangle-list fa-1x"></i><br>取引中<br>の仕事</a>
                        </div>
                    </div>
                    <div class="btn btn-default btn-light">
                        <div class="col p-1 mb-2 text-black ml-2">
                            <a href="my_community"><i class="fa-solid fa-user fa-1x"></i><br>参加コミ<br>ュニティ</a>
                        </div>
                    </div>
                    <div class="btn btn-default btn-light">
                        <div class="col p-1 mb-2 text-black mr-1 ml-1">
                            <a href="my_page.php"><i class="fa-solid fa-user fa-1x"></i><br>マイペ<br>ージ</a>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</body>

</html>

