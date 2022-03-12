<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';
// require_once __DIR__ . '/db.functions.php';

//入力された検索ワードを取得
$keyword = $_GET['keyword'];
//入力された検索ワードを含むコミュニティをあいまい検索
$community_list = search_community($keyword);
// $community_list = select_search_community_word($keyword);


?>

<!DOCTYPE html>
<html lang="ja">
<? include_once __DIR__ . '/header.html'; ?>

<body>
    <h1>コミュニティ一覧</h1>
    <ul>
        <!-- 対象コミュニティがない場合 -->
        <? if ($community_list == NULL) : ?>
            対象のコミュニティがありません
        <? else : ?>
            <p>注文番号/タイトル/日付/料金/コミュニティ</p>
            <?php foreach ($community_list as $community) : ?>
                <li>
                    <!-- コミュニティの項目を表示 -->
                    <a href="display_community.php?community_id=<?= h($community['id']) ?>" class="btn edit-btn">詳細</a>
                    <?= h($community['id']) ?>/
                    <?= h($community['community_name']) ?>/
                    <?= h($community['user_email']) ?>/
                    <?= h($community['condition1'] ?? '') ?>/
                    <?= h($community['condition2'] ?? '')  ?>/
                    <?= h($community['condition3'] ?? '') ?>/
                    <?= h($community['condition4'] ?? '') ?>/
                    <?= h($community['condition5'] ?? '') ?>/
                    <?= h($community['community_content']) ?>

                </li>
            <?php endforeach; ?>
        <? endif; ?>
    </ul>
    <a href="index.php" class="btn edit-btn">トップへ戻る</a><br>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>