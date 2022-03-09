<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';


//変数初期化
$adult = '';
$child = '';
$order_user_email = '';
$receive_user_email = '';
$title = '';
$job = '';
$day = '';
$price = '';
$status = '';
$condition1 = '';
$condition2 = '';
$condition3 = '';
$condition4 = '';
$condition5 = '';
$community_id = '';
$errors = [];

//Submitされた場合
if (($_SERVER)['REQUEST_METHOD'] === 'POST') {
    //入力値を取得
    $community = filter_input(INPUT_POST, 'community');
    $title = filter_input(INPUT_POST, 'title');
    $job = filter_input(INPUT_POST, 'job');
    $day = filter_input(INPUT_POST, 'day');
    $price = filter_input(INPUT_POST, 'price');
    $adult = filter_input(INPUT_POST, 'adult');
    $child = filter_input(INPUT_POST, 'child');
    $condition1 = filter_input(INPUT_POST, 'condition1');
    $condition2 = filter_input(INPUT_POST, 'condition2');
    $condition3 = filter_input(INPUT_POST, 'condition3');
    $condition4 = filter_input(INPUT_POST, 'condition4');
    $condition5 = filter_input(INPUT_POST, 'condition5');
    $community_id = filter_input(INPUT_POST, 'community_id');

    //エラーがない場合
    if (empty($errors)) {
        //セッションを開始する
        session_start();
        //ユーザーID（Email）を取得し設定
        $order_user_email = $_SESSION['email'];
        $_SESSION['email'];
        //委託業務をDBテーブルに登録
        $order_user = create_oreder(
            $adult,
            $child,
            $order_user_email,
            $receive_user_email,
            $title,
            $job,
            $day,
            $price,
            $status,
            $condition1,
            $condition2,
            $condition3,
            $condition4,
            $condition5,
            $community_id
        );
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
            <!-- 入入力項目 -->
            コミュニティ番号<input type="int" name="community_id" value=""><br>
            タイトル<input type="text" name="title" value=""><br>
            ジョブ<input type="text" name="job" value=""><br>
            大人<input type="int" name="adult" value=""><br>
            子供 <input type="int" name="child" value=""><br>
            日付<input type="date" name="day" value=""><br>
            料金 <input type="int" name="price" value=""><br>
            条件１ <input type="text" name="condition1" value=""><br>
            条件２ <input type="text" name="condition2" value=""><br>
            条件３ <input type="text" name="condition3" value=""><br>
            条件４ <input type="text" name="condition4" value=""><br>
            条件５ <input type="text" name="condition5" value=""><br>
            <input type="submit" value="登録" class="btn submit-btn">
        </form>
        <a href="index.php" class="btn return-btn">戻る</a>

    </div>
</body>

</html>