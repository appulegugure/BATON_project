<?php

require_once __DIR__ . "/functions.php";

session_start();
if (!isset($_SESSION['csrf_token'])) {
    $token = base64_encode(openssl_random_pseudo_bytes(32));
    $_SESSION['csrf_token'] = $token;
}


$email = '';
$name = '';
$password = '';
$message = '';
$errors = [];

if (!empty($_SESSION['id'])) {
    header('Location: show.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $result = find_user_by_email($email);
    if (isset($result['mail'])) {
        $errors[] = "このメールアドレスはすでに利用されています。";
    }
    if (empty($email)) {
        $errors[] = 'メールアドレスが未入力です。';
    }
    $csrf_token = filter_input(INPUT_POST, 'csrf_token');
    if ($_SESSION['csrf_token'] != $csrf_token) {
        $errors[] = '不正なアクセスです.';
    }
    if (empty($errors)) {
        $urltoken = hash('sha256', uniqid(rand(), 1));
        $url = "http://localhost/BATON_project/true_signup.php?urltoken=" . $urltoken;
        insert_pre_user($email, $urltoken);

        $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";

        $body  = <<< EOM
            この度はご登録いただきありがとうございます。
        24時間以内に下記のURLからご登録下さい。
        {$url}
        EOM;

        $mb_language = ('japanese');
        $mb_internal_encoding = ('UTF-8');
        $title = "ご登録いただきありがとうございます";
        $headers = "From: information.baton@gmail.com";
        if (mb_send_mail($email, $title, $body, $headers)) {
            $_SESSION = [];
            if (isset($_COOKIE["PHPSESSID"])) {
                setcookie("PHPSESSID", '', time() - 1800, '/');
            }
            session_destroy();
            $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";
        }
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
    <?php if (isset($_POST['submit']) && empty($errors)) : ?>
        <p><?= $message ?></p>
        <a href="<?= $url ?>"><?= $url ?></a>

    <?php else : ?>
        <div class="wrapper">
            <h1 class="title">仮会員登録</h1>
            <?php if ($errors) : ?>
                <ul class="errors">
                    <?php foreach ($errors as $error) : ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form action="" method="post">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">
                <input type="submit" value="新規登録" class="btn submit-btn" name='submit'>
                <a href="login.php" class="btn link-btn">ログインはこちら</a>
                
            </form>
        </div>
    <?php endif; ?>
</body>

</html>