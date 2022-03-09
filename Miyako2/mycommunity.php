<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';

// $keyword = $_GET['keyword'];
session_start();
$user_id = $_SESSION['email'];
$community_list = search_community_by_user($user_id);


?>

<!DOCTYPE html>
<html lang="ja">

<body>
    <h1>コミュニティ一覧</h1>
    <ul>
        <? if ($community_list == NULL) : ?>
            対象のコミュニティがありません
        <? else : ?>
            <p>注文番号/タイトル/日付/料金/コミュニティ</p>
            <?php foreach ($community_list as $community) : ?>
                <li>
                    <a href="display_community.php?community_id=<?= h($community['community_id']) ?>" class="btn edit-btn">詳細</a>
                    <?= h($community['community_id']) ?>/
                    <?= h($community['community_name']) ?>/
                    <?= h($community['community_maker']) ?>/
                    <?= h($community['condition1']) ?>/
                    <?= h($community['condition2']) ?>/
                    <?= h($community['condition3']) ?>/
                    <?= h($community['condition4']) ?>/
                    <?= h($community['condition5']) ?>/

                </li>
            <?php endforeach; ?>
        <? endif; ?>
    </ul>
    <a href="index.php" class="btn edit-btn">トップへ戻る</a><br>
</body>

</html>