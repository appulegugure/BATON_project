<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// idの受け取り
$community_id = filter_input(INPUT_GET, 'community_id');
//対象コミュニティの取得
$community = display_community($community_id);

//タスク更新処理
$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Community_userテーブルを取得
    session_start();
    $user = $_SESSION['email'];
    $community_user = search_community_user($community_id, $user);
    if (!empty($community_user)) {
        $errors[] = 'このコミュニティには既に参加済みです';
    }

    // $errors = update_validate($updated_title, $current_task);
    if (empty($errors)) {
        //注文ステータスの更新
        session_start();
        $user = $_SESSION['email'];
        create_community_user($community_id, $user);
        // compelte_msg.php にリダイレクト
        header('Location: complete_msg.php?comment=コミュニティへの参加');
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
            コミュニティ番号:<?= h($community['community_id']) ?><br>
            コミュニティ名:<?= h($community['community_name']) ?><br>
            ユーザー:<?= h($community['community_maker']) ?><br>
            条件１:<?= h($community['condition1']) ?><br>
            条件２:<?= h($community['condition2']) ?><br>
            条件３:<?= h($community['condition3']) ?><br>
            条件４:<?= h($community['condition4']) ?><br>
            条件５:<?= h($community['condition5']) ?><br>
            <br>
            <input type="submit" value="参加する" class="btn submit-btn">
        </form>
        <a href="community_list.php" class="btn return-btn">戻る</a><br>
        <a href="index.php" class="btn edit-btn">トップへ戻る</a><br>

    </div>
</body>

</html>