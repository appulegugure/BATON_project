<?php

require_once __DIR__ . "/functions.php";



$name = '';
$email = '';
$password = '';
$company = '';
$post = '';
$prefe = '';
$all_email = find_email();
$errors = [];
$i = 0;
$_SESSION['csrf_token'] = get_token_cr();

if (empty($_GET)) {
    header("Location: provi_signup");
    exit();

if (!empty($_SESSION['id'])) {
    header('Location: show.php');
    
    exit;

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $name = filter_input(INPUT_POST, 'name');
    $password = filter_input(INPUT_POST, 'password');
    $company = filter_input(INPUT_POST, 'password');
    $post = filter_input(INPUT_POST, 'post');
    $prefe = filter_input(INPUT_POST, 'prefe');
    $errors = signup_validate($email, $name, $password, $company, $post, $prefe);
    while (count($all_email) > $i) {
        if ($all_email[$i]['email'] == $email) {
            $errors[] = '既に使用されているメールアドレスです';
        }
        $i++;
    }
    if ($_SESSION['csrf_token'] != $_POST['token']) {
        $errors[] = '不正なアクセスです.';
    }
    if (empty($errors)) {
        insert_user($email, $name, $password, $company, $post, $prefe);
        header('Location:login.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
        <a>:　必須　</a>
        <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">
        <label for="name">ユーザー名</label>
        <a>:　必須　</a>
        <input type="text" name="name" id="name" placeholder="UserName" value="<?= h($name) ?>">
        <label for="password">パスワード</label>
        <a>:　必須　</a>
        <input type="password" name="password" id="password" placeholder="Password">

        <label for="company">会社名</label>
        <a>:　必須　</a>
        <input type="text" name="company" id="company" placeholder="会社名">
        <label for="post">郵便番号</label>
        <a>:　必須　</a>
        <input type="text" name="post" id="post" placeholder="郵便番号">
        <label for="prefe">都道府県</label>
        <a>:　必須　</a>
        <input type="prefe" name="prefe" id="prefe" placeholder="都道府県">

        <div class="btn-area">
            <input type="submit" value="新規登録" class="btn submit-btn">
            <a href="login.php" class="btn link-btn">ログインはこちら</a>
        </div>
    </form>
</body>

</html>