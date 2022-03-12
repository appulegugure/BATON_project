<?php

session_start();
$email = '';
$password = '';

include_once __DIR__ . '/all.html';
require_once __DIR__ . "/functions.php";


$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $errors = login_validate($email, $password);
    $user = find_user_by_email($email);
    if(empty($user)){
        $errors[] = '存在しないアカウントです';
    }
    if (empty($errors)){
        if(password_verify($password, $user['password'])){
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

<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head> -->

<body>
    <div class="wrapper m-5">
        <h1 class="title">Log In</h1>
        <?php if ($errors) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="" method="post">
        <div class="container d-flex align-items-center justify-content-center" style="height:300px;">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password" placeholder="Password: 8文字以上">
            <div class="btn-area">
                <input type="submit" value="ログイン" class="btn btn-primary mb-1"><br>
                <a href="signup.php" class="btn btn-secondary">新規ユーザー登録はこちら</a>
            </div>
        </form>
        </div>
    </div>
</body>

</html>

