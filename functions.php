<?php

require_once __DIR__ . '/config.php';

function connect_db()
{
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function insert_user($email, $name, $password, $company, $post, $prefe)
{
    $dbh = connect_db();
    $sql = <<<EOM
    INSERT INTO
        user
        (email,name,password,company,post,prefe)
    VALUES
    (:email, :name, :password, :company, :post, :prefe);
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
    $stmt->bindParam(':post', $post, PDO::PARAM_STR);
    $stmt->bindParam(':prefe', $prefe, PDO::PARAM_STR);
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $pw_hash, PDO::PARAM_STR);
    $stmt->execute();

}


function find_by_email($email)
{
    $dbh = connect_db();
    $sql = <<<EOM
    SELECT
        *
    FROM
        user
    WHERE
        email = :email;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

}

function signup_validate($email, $name,$password, $company, $post, $prefe)
{
    $erro = [];

    if (empty($email)) {
        $erro[] = MSG_EMAIL_REQUIRED;
    }
    if (empty($name)) {
        $erro[] = MSG_NAME_REQUIRED;
    }
    if (empty($password)) {
        $erro[] = MSG_PASSWORD_REQUIRED;
    }
    if (empty($company)) {
        $erro[] = '会社名が未入力です';
    }
    if (empty($post)) {
        $erro[] = '郵便番号が未入力です';
    }
    if (empty($prefe)) {
        $erro[] = '都道府県が未入力です';
    }

    return $erro;
}

function login_validate($email, $password){
    $error = [];
    if (empty($email)) {
        $error[] = MSG_EMAIL_REQUIRED;
    }
    if (empty($password)) {
        $error[] = MSG_PASSWORD_REQUIRED;
    }
    return $error;

}

function find_user_by_email($email)
{
    $dbh = connect_db();
    $sql = <<<EOM
    SELECT
        *
    FROM
        user
    WHERE
        email = :email;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function find_email()
{
    $dbh = connect_db();
    $sql = <<<EOM
    SELECT
        email
    FROM
        user
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_token_cr()
{
    $token_length = 16;
    $token = openssl_random_pseudo_bytes($token_length);
    return bin2hex($token);
}

function insert_pre_user($email, $urltoken){
    $dbh = connect_db();
    $sql = <<<EOM
    INSERT into 
        pre_user
        (mail,urltoken,date)
    VALUE
        (:email,:urltoken,now())
    EOM;
    $stmt = $dbh -> prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
    $stmt->execute();

}
function url_pre_user($urltoken){
    $result = [];
    $dbh = connect_db();
    $sql = <<<EOM
    SELECT
        mail
    FROM
        pre_user
    WHERE
        urltoken = :url
    AND 
        date > now() - interval 24 hour;
    EOM;
    $stmt = $dbh -> prepare($sql);
    $stmt->bindParam(':url', $urltoken, PDO::PARAM_STR);
    $stmt -> execute();
    $result['email'] = $stmt->fetch(PDO::FETCH_ASSOC);
    $result['count'] = $stmt->rowCount();

    return $result;
}