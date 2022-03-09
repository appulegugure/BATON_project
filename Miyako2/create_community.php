<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// idの受け取り
// $id = filter_input(INPUT_GET, 'id');
//対象タスクの取得
// $current_task = find_task_by_id($id);

//タスク更新処理
$community_name = '';
$user_id = '';
$condition1 = '';
$condition2 = '';
$condition3 = '';
$condition4 = '';
$condition5 = '';
$errors = [];

if (($_SERVER)['REQUEST_METHOD'] === 'POST') {
    $community_name = filter_input(INPUT_POST, 'community_name');
    $condition1 = filter_input(INPUT_POST, 'condition1');
    $condition2 = filter_input(INPUT_POST, 'condition2');
    $condition3 = filter_input(INPUT_POST, 'condition3');
    $condition4 = filter_input(INPUT_POST, 'condition4');
    $condition5 = filter_input(INPUT_POST, 'condition5');


    if (empty($errors)) {
        //タスク内容の編集
        session_start();
        $user_id = $_SESSION['email'];
        //コミュニティテーブルに登録
        $community_id = create_community($community_name, $user_id, $condition1, $condition2, $condition3, $condition4, $condition5);
        //コミュニティ・ユーザテーブルに登録
        create_community_user($community_id, $user_id);
        // compelte_msg.php にリダイレクト
        header('Location: complete_msg.php?comment=コミュニティ登録');
        exit;
    }
}


?>


<!DOCTYPE html>
<html lang="ja">


<body>
    <div>
        <h2>コミュニティを作る</h2>
        <!-- エラーがあったら表示 -->
        <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="post">
            コミュニティ名<input type="text" name="community_name" value=""><br>
            参加条件１<input type="text" name="condition1" value=""><br>
            参加条件２<input type="text" name="condition2" value=""><br>
            参加条件３<input type="text" name="condition3" value=""><br>
            参加条件４<input type="text" name="condition4" value=""><br>
            参加条件５<input type="text" name="condition5" value=""><br>
            <input type="submit" value="登録" class="btn submit-btn">
        </form>
        <a href="index.php" class="btn return-btn">戻る</a>

    </div>
</body>

</html>