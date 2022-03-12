<?php

require_once __DIR__ . "/functions.php";

session_start();
$token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['csrf_token'] = $token;


$email = '';
$name = '';
$password = '';
$message = '';
$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_SESSION['email'])) {
        $email = $_SESSION['email'];
    }else{
        $email = filter_input(INPUT_POST, 'email');
    }
    $result = find_user_by_email($email);

    if (empty($result['email'])) {
        $errors[] = '存在しないアカウントです';
    }

    if (empty($email)) {
        $errors[] = 'メールアドレスが未入力です。';
    }

    //$csrf_token = filter_input(INPUT_POST, 'csrf_token');
    //if ($_SESSION['csrf_token'] != $csrf_token) {
    //$errors[] = '不正なアクセスです.';
    //var_dump($_SESSION['csrf_token']);
    //var_dump($csrf_token);
    //}
    if (empty($errors)) {
        $urltoken = hash('sha256', uniqid(rand(), 1));
        $url = "http://localhost/BATON_project/true_pass.php?urltoken=" . $urltoken;
        insert_pre_user($email, $urltoken);

        //$message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";

        $body  = <<< EOM
            パスワード変更の確認。
            10分以内に下記のURLから変更下さい。
        {$url}
        EOM;

        $mb_language = ('japanese');
        $mb_internal_encoding = ('UTF-8');
        $title = "パスワード変更のお知らせ";
        $headers = "From: information.baton@gmail.com";
        if (mb_send_mail($email, $title, $body, $headers)) {
            $_SESSION = [];
            if (isset($_COOKIE["PHPSESSID"])) {
                setcookie("PHPSESSID", '', time() - 1800, '/');
            }
            session_destroy();
            $message = "メールをお送りしました。10分以内にメールに記載されたURLからご登録下さい。";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/all.html' ?>

<body>
    <?php if (isset($_POST['submit']) && empty($errors)) : ?>
        <h3>パスワードの変更を承りました</h3>
        <p><?= h($email) ?></p>
        <p><?= $message ?></p>
        <a href="<?= $url ?>"><?= $url ?></a>

    <?php else : ?>
        <div class="wrapper">
            <h1 class="title">パスワード変更</h1>
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
                <input type="submit" value="変更" class="btn submit-btn" name='submit'>
            
        </div>
        </form>
        </div>
    <?php endif; ?>
</body>

</html>