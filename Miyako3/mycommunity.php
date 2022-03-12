<?php
//セッションを開始する
session_start();

// 関数ファイルを読み込む
include_once __DIR__ . '/all.html';
require_once __DIR__ . '/functions.php';


//ユーザーID（Email）を取得
$user_id = $_SESSION['email'];
//ユーザーが参加しているコミュニティ一覧を表示
$community_list = search_community_by_user($user_id);

?>

<!DOCTYPE html>
<html lang="ja">
    
<?php include_once __DIR__ . '/all.html'; ?>

<body>
    <div class="wrapper">
            <div class="mb-5">
                <h1>コミュニティ一覧</h1>
            </div>
        <div class="container">
            <div class="row">
                <ul>
                    <!-- 参加コミュニティがない場合 -->
                    <? if ($community_list == NULL) : ?>
                        対象のコミュニティがありません
                        <!-- 参加コミュニティがある場合 -->
                    <? else : ?>
                        <?php foreach ($community_list as $community) : ?>
                            <li>
                                <!-- 表示項目は要調整 -->
                                <div class="col xs-3">
                                    <?= h($community['community_name']) ?>
                                </div>
                                <!-- 詳細ボタンをクリックしたらCommunityのIDを渡す -->
                                <a href="display_community.php?community_id=<?= h($community['id']) ?>" class="btn btn-outline-primary">詳細</a>
                            </li>
                        <?php endforeach; ?>
                    <? endif; ?>
                </ul>
            </div>
        </div>
        <div class="mt-5 text-center">
            <a href="index.php" class="btn btn-secondary">戻る</a><br>
        </div>
    </div>
</body>

</html>