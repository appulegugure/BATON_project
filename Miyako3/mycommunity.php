<?php
//セッションを開始する
session_start();

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once BATON_PATH_DB_FUNCTION;


//ユーザーID（Email）を取得
$user_id = $_SESSION['email'];
//ユーザーが参加しているコミュニティ一覧を表示
$community_list = search_community_by_user($user_id);

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/header.html'; ?>
<link rel="stylesheet" href="mycommunity.css">

<body>
    <div class="mycommunity_wrapper">
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
                            <ul class="col1">
                                <!-- 表示項目は要調整 -->
                                <div class="col xs-3">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>〇
                                                </td>
                                                <td style="width: 300px;"> <?= h($community['community_name']) ?></td>
                                                <!-- 詳細ボタンをクリックしたらCommunityのIDを渡す -->
                                                <td>
                                                    <a display:block; href="display_mycommunity.php?community_id=<?= h($community['id']) ?>" class="btn btn-outline-primary">詳細</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </ul>
                        <?php endforeach; ?>
                    <? endif; ?>
                </ul>
            </div>
        </div>
        <div class="mt-5 text-center">
            <a href="index.php" class="btn btn-secondary">戻る</a><br>
        </div>
    </div>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>