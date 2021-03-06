<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';

//セッションを開始する
session_start();
//ユーザーID（Email）を取得
$user_id = $_SESSION['email'];
//ユーザーが参加しているコミュニティ一覧を表示
$community_list = search_community_by_user($user_id);

?>

<!DOCTYPE html>
<html lang="ja">

<body>
    <h1>コミュニティ一覧</h1>
    <ul>
        <!-- 参加コミュニティがない場合 -->
        <? if ($community_list == NULL) : ?>
            対象のコミュニティがありません
            <!-- 参加コミュニティがある場合 -->
        <? else : ?>
            <p>コミュニティ番号/コミュニティ名/作成者/条件１/条件２/条件3/条件４/条件５/内容/日付/作成者フラグ</p>
            <?php foreach ($community_list as $community) : ?>
                <li>
                    <!-- 詳細ボタンをクリックしたらCommunityのIDを渡す -->
                    <a href="display_mycommunity.php?community_id=<?= h($community['id']) ?>" class="btn edit-btn">詳細</a>
                    <!-- 表示項目は要調整 -->
                    <?= h($community['id']) ?>/
                    <?= h($community['community_name']) ?>/
                    <?= h($community['user_email']) ?>/
                    <?= h($community['condition1']) ?>/
                    <?= h($community['condition2']) ?>/
                    <?= h($community['condition3']) ?>/
                    <?= h($community['condition4']) ?>/
                    <?= h($community['condition5']) ?>/
                    <?= h($community['community_content']) ?>/
                    <?= h($community['flag']) ?>
                </li>
            <?php endforeach; ?>
        <? endif; ?>
    </ul>
    <a href="index.php" class="btn edit-btn">トップへ戻る</a><br>
</body>

</html>