<?php
require_once __DIR__ . "/functions.php";

require_once __DIR__ . "/db_function.php";

session_start();

$email = '';
$password = '';
if (!isset($_SESSION['csrf_token'])) {
    $token = base64_encode(openssl_random_pseudo_bytes(32));
    $_SESSION['csrf_token'] = $token;
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $errors = login_validate($email, $password);
    $user = find_user_by_email($email);
    //追加
    $user_communitys = select_search_community($user['email']);

    if (empty($user)) {

        $errors[] = '存在しないアカウントです';
    }
    if ($_SESSION['csrf_token'] != $_POST['token']) {
        $errors[] = '不正なアクセスです.';
    }
    if (empty($errors)) {
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['email'] = $user['email'];
            //追加
            $_SESSION['community'] = $user_communitys;
            //変更前
            //-->> header('Location: index.php');
            //変更後
            header('Location: Miyako3/index.php');


            exit;
        } else {
            $errors[] = MSG_EMAIL_PASSWORD_NOT_MATCH;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<? include_once __DIR__ . '/header.html'; ?>
<link rel="stylesheet" href="login.css">

<body>
    <div class="login_wrapper">
        <h1 class="title mb-5">ログイン</h1>
        <?php if ($errors) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="" method="post">
            <div class="" style="height:300px;">
                <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>"><br>
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password" placeholder="Password: 8文字以上">
                <div class="mt-3">
                    <input type="submit" value="ログイン" class="btn btn-primary">
                </div>
                <div class="mt-3">
                    <a href="provi_signup.php" class="btn btn-info">新規ユーザー登録はこちら</a>
                </div>
                <div class="mt-3">
                    <a href="pass_email_reset.php" class="btn btn-secondary">パスワードを忘れた方</a>
                </div>
            </div>
        </form>
    </div>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>