<?php

require_once __DIR__ . "/functions.php";
session_start();
$_SESSION['csrf_token'] = get_token_cr();

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
    if (isset($result)) {
        $errors[] = "このメールアドレスはすでに利用されています。";
    }
    if (empty($email)) {
        $errors[] = 'メールアドレスが未入力です。';
    }
    if ($_SESSION['csrf_token'] != $_POST['token']) {
        $errors[] = '不正なアクセスです.';
    }
    if (empty($errors)) {
        $urltoken = hash('sha256', uniqid(rand(), 1));
        $url = "http://localhost:8080/true_signup.php?urltoken=" . $urltoken;
        insert_pre_user($email, $urltoken);

        $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";

        $body  = <<< EOM
            この度はご登録いただきありがとうございます。
        24時間以内に下記のURLからご登録下さい。
        {$url}
        EOM;

        $mb_language = ('japanese');
        $mb_internal_encoding('UTF-8');
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

<?php include_once __DIR__ . '/_header.html' ?>

<body>
    <?php if (isset($_POST['submit']) && empty($errors)) : ?>
        <p><?= $message ?></p>

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
                <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">
                <input type="submit" value="新規登録" class="btn submit-btn" name='submit'>
                <a href="login.php" class="btn link-btn">ログインはこちら</a>
        </div>
        </form>
        </div>
    <?php endif; ?>
</body>

</html>