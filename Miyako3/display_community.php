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
    //コミュニティに参加済みかを確認
    $community_user = search_community_user($community_id, $user);
    //コミュニティに参加済みの場合
    if (!empty($community_user)) {
        // エラーメッセージ「このコミュニティには既に参加済みです」後でConstantに設定
        $errors[] = 'このコミュニティには既に参加済みです';
    }
    //エラーがない場合
    if (empty($errors)) {
        //フラグをオフにする
        $owner_flag = 0;
        //コミュニティ参加者テーブルに登録
        create_community_user($community_id, $user, $owner_flag);
        // compelte_msg.php にリダイレクト
        header('Location: complete_msg.php?comment=コミュニティへの参加');
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
            <input type="submit" value="参加する" class="btn submit-btn">
        </form>
        <!-- 戻るボタンは上手く動かないから後で -->
        <!-- <a href="community_list.php" class="btn return-btn">戻る</a><br> -->
        <a href="index.php" class="btn edit-btn">トップへ戻る</a><br>

    </div>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>