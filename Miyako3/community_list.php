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

<?php include_once __DIR__ . '/all.html'; ?>

<body>
    <div class="wrapper">
        <div class="mb-5">
            <h1>コミュニティ一覧</h1>
        </div>
        <ul>
            <!-- 対象コミュニティがない場合 -->
            <? if ($community_list == NULL) : ?>
                対象のコミュニティがありません
            <? else : ?>
                <?php foreach ($community_list as $community) : ?>
                    <li>
                        <!-- コミュニティの項目を表示 -->
                        <?= h($community['id']) ?>/
                        <?= h($community['community_name']) ?>/
                        <?= h($community['user_email']) ?>/
                        <?= h($community['condition1']) ?>/
                        <?= h($community['condition2']) ?>/
                        <?= h($community['condition3']) ?>/
                        <?= h($community['condition4']) ?>/
                        <?= h($community['condition5']) ?>/
                        <?= h($community['community_content']) ?>
                        <a href="display_community.php?community_id=<?= h($community['id']) ?>" class="btn btn btn-outline-primary">詳細</a>
                    </li>
                <?php endforeach; ?>
            <? endif; ?>
        </ul>
        <div class="text-center">
            <a href="index.php" class="btn btn-secondary">戻る</a><br>
        </div>
    </div>
</body>

</html>