<?php

require_once __DIR__ . "/functions.php";



$email = '';
$password = '';
$all_email = find_email();
$errors = [];
$i = 0;
$_SESSION['csrf_token'] = get_token_cr();
$urltoken = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;
if ($urltoken == '') {
    header('location: pass_email_reset.php');
    exit;
} else {
    $result = url_pass_user($urltoken);
    if ($result['count'] === 1) {
        $email = $result['email']['mail'];
    } else {
        $errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度登録をやりなおして下さい。";
    }
}

if (!empty($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $re_password = filter_input(INPUT_POST, 're:password');
    if ($password != $re_password) {
        $errors[] = 'パスワードが一致しません';
    }
    if (empty($errors)) {
        reset_pass($email, $password);
        $body = 'パスワードを変更しました';
        $mb_language = ('japanese');
        $mb_internal_encoding = ('UTF-8');
        $title = "パスワードを変更しました";
        $headers = "From: information.baton@gmail.com";
        if (mb_send_mail($email, $title, $body, $headers)) {
            $_SESSION = [];
            if (isset($_COOKIE["PHPSESSID"])) {
                setcookie("PHPSESSID", '', time() - 1800, '/');
            }
            session_destroy();
        }
        header('Location:login.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <?php if ($errors) : ?>
        <ul class="errors">
            <?php foreach ($errors as $error) : ?>
                <li><?= h($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="" method="post">
        <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">
        <a>:　必須　</a>
        <label for="password">パスワード</label>
        <a>:　必須　</a>
        <input type="password" name="password" id="password" placeholder="8文字以上">
        <label for="password">パスワード(確認用)</label>
        <input type="password" name="re:password" id="re:password" placeholder="">

        <div class="btn-area">
            <input type="submit" value="新規登録" class="btn submit-btn">
            <a href="login.php" class="btn link-btn">ログインはこちら</a>
        </div>
    </form>
</body>

</html>