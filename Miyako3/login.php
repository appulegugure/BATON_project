<?php

session_start();
$email = '';
$password = '';

require_once __DIR__ . "/functions.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $errors = login_validate($email, $password);
    $user = find_user_by_email($email);
    if (empty($user)) {
        $errors[] = '存在しないアカウントです';
    }
    if (empty($errors)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            header('Location: index.php');
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

<body>
    <div class="wrapper">
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
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>"><br>
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password" placeholder="Password: 8文字以上">
                <div class="mt-3">
                    <input type="submit" value="ログイン" class="btn btn-primary mb-1"><br>
                </div>
                <div class="mt-3">
                    <a href="signup.php" class="btn btn-secondary">新規ユーザー登録はこちら</a>
                </div>
            </div>
        </form>
    </div>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>