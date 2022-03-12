<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// Communityのidの受け取り
$community_id = filter_input(INPUT_GET, 'community_id');
//Community IDをキーにコミュニティの詳細を取得
// $community = display_community($community_id);
$community = select_community_info($community_id);

//変数初期化
$errors = [];

//Submitされた場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //セッション開始
    session_start();
    //ユーザID（（Email)を取得し変数に設定
    $user = $_SESSION['email'];
    //コミュニティ作成者か確認
    $community_user = search_community_user($community_id, $user);
    if ($community_user['flag'] == 1) {
        //'コミュニティ作成者のため抜けられません'
        $errors[] = 'コミュニティ作成者のためコミュニティから抜けられません';
    }

    //エラーがない場合
    if (empty($errors)) {
        //コミュニティ参加者テーブルのレコードを削除
        withdraw_from_community($community_id, $user);
        // compelte_msg.php にリダイレクト
        header('Location: complete_msg.php?comment=コミュニティからの脱退');
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="ja">
<? include_once __DIR__ . '/header.html'; ?>


<body>
    <div>
        <h2>コミュニティ詳細</h2>
        <!-- エラーがあったら表示 -->
        <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="post">
            <!-- コミュニティの項目を表示-->
            コミュニティ番号:<?= h($community['id']) ?><br>
            コミュニティ名:<?= h($community['community_name']) ?><br>
            ユーザー:<?= h($community['user_email']) ?><br>
            条件１:<?= h($community['condition1']) ?><br>
            条件２:<?= h($community['condition2']) ?><br>
            条件３:<?= h($community['condition3']) ?><br>
            条件４:<?= h($community['condition4']) ?><br>
            条件５:<?= h($community['condition5']) ?><br>
            内容:<?= h($community['community_content']) ?><br>
            <br>
            <input type="submit" value="コミュニティから抜ける" class="btn submit-btn">
        </form>
        <!-- 戻るボタンは上手く動かないから後で -->
        <!-- <a href="community_list.php" class="btn return-btn">戻る</a><br> -->
        <a href="index.php" class="btn edit-btn">トップへ戻る</a><br>

    </div>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>