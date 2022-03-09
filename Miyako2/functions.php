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


// タスク照会
function find_task_by_status($status)
{
    // データベースに接続
    $dbh = connect_db();

    //SQL文
    $sql = <<<EOM
    SELECT
        *
    FROM
        tasks
    WHERE
        status = :status
    ORDER BY
    updated_at
EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // // バインド(代入)するパラメータの準備
    // $status = 'notyet';

    // パラメータのバインド
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//タスク入力必須Validation
function insert_validate($title)
{
    $errors = [];
    if (empty($title)) {
        $errors[] = MSG_TITLE_REQUIRED;
    }

    return $errors;
}
//受注テーブルにデータ追加
function create_oreder($adult, $child, $title, $day, $number_of_peaple_id, $price, $Contents, $Prerequisite)
{
    $dbh = connect_db();
    try {
        $dbh->beginTransaction();

        $stmt1 = $dbh->prepare('INSERT INTO person_group(adult,child) VALUES (:adult,:child);');
        $stmt2 = $dbh->prepare('SET @LAST_ID_pg = LAST_INSERT_ID();');
        $stmt3 = $dbh->prepare('INSERT INTO order_ver_1(title,`day`,number_of_peaple_id,price,Contents,Prerequisite,community_id)
                                VALUES (:title,:day,:number_of_peaple_id,:price,:contents,:Prerequisite,@LAST_ID_pg);');

        $stmt1->bindParam(':adult', $adult, PDO::PARAM_INT);
        $stmt1->bindParam(':child', $child, PDO::PARAM_INT);
        $stmt3->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt3->bindParam(':day', $day, PDO::PARAM_STR);
        $stmt3->bindParam(':number_of_peaple_id', $number_of_peaple_id, PDO::PARAM_INT);
        $stmt3->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt3->bindParam(':contents', $Contents, PDO::PARAM_STR);
        $stmt3->bindParam(':Prerequisite', $Prerequisite, PDO::PARAM_STR);

        $res1 = $stmt1->execute();
        $res2 = $stmt2->execute();
        $res3 = $stmt3->execute();

        if ($res1 && $res2 && $res3) {
            $dbh->commit();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        $dbh->rollBack();
    } finally {
        $dbh = null;
    }
}
//タスク登録
function create_order_2($community, $order_user, $title, $job, $day, $price)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    INSERT INTO
        job_order
        (community, order_user, title, job, day, price)
    VALUES
        (:community, :order_user, :title, :job, :day, :price) 
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindParam(':community', $community, PDO::PARAM_STR);
    $stmt->bindParam(':order_user', $order_user, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':job', $job, PDO::PARAM_STR);
    $stmt->bindParam(':day', $day, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
}


// 注文を取得する
function search_community_user($community, $user)
{
    // データベースに接続
    $dbh = connect_db();

    //SQL文
    $sql = <<<EOM
    SELECT
        *
    FROM
        community_user
    WHERE
    community = :community
    AND
    user = :user
EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindParam(':community', $community, PDO::PARAM_STR);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//community登録
function create_community($community_name, $user_id, $condition1, $condition2, $condition3, $condition4, $condition5)
{
    // DBへ接続
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    INSERT INTO
        community
        (community_name, community_maker, condition1, condition2, condition3, condition4, condition5)
    VALUES
        (:community_name, :community_maker, :condition1, :condition2, :condition3, :condition4, :condition5) 
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindParam(':community_name', $community_name, PDO::PARAM_STR);
    $stmt->bindParam(':community_maker', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':condition1', $condition1, PDO::PARAM_STR);
    $stmt->bindParam(':condition2', $condition2, PDO::PARAM_STR);
    $stmt->bindParam(':condition3', $condition3, PDO::PARAM_STR);
    $stmt->bindParam(':condition4', $condition4, PDO::PARAM_STR);
    $stmt->bindParam(':condition5', $condition5, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();
    // 登録されたIDの取得
    return $dbh->lastInsertId();
}

//community登録
function create_community_user($community_id, $user)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    INSERT INTO
        community_user
        (community, user)
    VALUES
        (:community, :user) 
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindParam(':community', $community_id, PDO::PARAM_STR);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();
}

//受注テーブル一覧表示
function select_order_all_ALL()
{
    $dbh = connect_db();
    try {

        $stmt1 = $dbh->prepare('SELECT * FROM order_ver_1 INNER JOIN person_group ON order_ver_1.community_id = person_group.id;');
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// 注文を取得する
function select_order_by_community($community_list)
{
    // データベースに接続
    $dbh = connect_db();

    //SQL文
    $sql = <<<EOM
    SELECT
        *
    FROM
        job_order
    WHERE
    community IN :community
    AND 
    status IS :status
    ORDER BY
    created_at
EOM;

    //community IDを連結する
    $community_keys = '';
    foreach ($community_list as $key => $community) {
        if ($key === 0) {
            $community_keys = '(' . $community['community'];
        } else {
            $community_keys .=  ',' . $community['community'];
        }
        // $community_keys = implode(',', $community);
    }
    $community_keys .= ')';
   
    $community_keys = '(1,2,7,22)';
    var_dump($community_keys);

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);
    // パラメータのバインド
    $stmt->bindParam(':community', $community_keys, PDO::PARAM_STR);
    $status = NULL;
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 注文を取得する
function search_community($keyword)
{
    // データベースに接続
    $dbh = connect_db();

    //SQL文
    $sql = <<<EOM
    SELECT
        *
    FROM
        community
    WHERE
    community_name LIKE :search_term
    OR
    condition1 LIKE :search_term
     OR
    condition2 LIKE :search_term
     OR
    condition3 LIKE :search_term
     OR
    condition4 LIKE :search_term
     OR
    condition5 LIKE :search_term
    ORDER BY
    created_at
EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $search_term = '%' . $keyword . '%';
    $stmt->bindParam(':search_term', $search_term, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// コミュニティを取得する
function search_community_by_user($user_id)
{
    // データベースに接続
    $dbh = connect_db();

    //SQL文
    $sql = <<<EOM
    SELECT
        community.*, community_user.*
    FROM
        community_user
    INNER JOIN
        community
    ON community.community_id = community_user.community
    WHERE
    community_user.user = :user_id
EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function update_status_to_done($id, $status)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    UPDATE
        tasks
    SET
        status = :status
    WHERE id = :id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);


    // パラメータのバインド
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    switch ($status) {
        case TASK_STATUS_DONE:
            $status = TASK_STATUS_DONE;
            break;
        case TASK_STATUS_NOTYET:
            $status = TASK_STATUS_NOTYET;
            break;
        default:
            # code...
            break;
    }

    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    // プリペアドステートメントの実行
    $stmt->execute();
}

//受注テーブルの詳細を表示
function display_order($id)
{

    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT  order_ver_1.title, 
                                        order_ver_1.`day`, 
                                        order_ver_1.Prerequisite,
                                        order_ver_1.Contents, 
                                        order_ver_1.number_of_peaple_id, 
                                        person_group.adult, 
                                        person_group.child 
                                FROM order_ver_1 
                                INNER JOIN person_group ON order_ver_1.community_id = person_group.id
                                WHERE order_ver_1.id = $id;
                                ");

        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function display_order_2($order_id)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    SELECT
    *
        FROM
        job_order
    WHERE 
    order_id = :order_id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);


    // パラメータのバインド
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    // プリペアドステートメントの実行
    $stmt->execute();
    // 結果の取得
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function display_order_by_receiveuser($user_id)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    SELECT
    *
        FROM
        job_order
    WHERE 
    receive_user = :user_id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);


    // パラメータのバインド
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    // プリペアドステートメントの実行
    $stmt->execute();
    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function display_order_by_orderuser($user_id)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    SELECT
    *
        FROM
        job_order
    WHERE 
    order_user = :user_id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);


    // パラメータのバインド
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    // プリペアドステートメントの実行
    $stmt->execute();
    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function display_community($community_id)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    SELECT
    *
        FROM
        community
    WHERE 
    community_id = :community_id
    ORDER BY
    updated_at
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);


    // パラメータのバインド
    $stmt->bindParam(':community_id', $community_id, PDO::PARAM_INT);
    // プリペアドステートメントの実行
    $stmt->execute();
    // 結果の取得
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function update_order($user_id, $order_id)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    UPDATE
        job_order
    SET
        status = :status,
        receive_user = :receive_user
    WHERE order_id = :order_id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);


    // パラメータのバインド
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_STR);
    $status = '受注済';
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':receive_user', $user_id, PDO::PARAM_STR);
    // プリペアドステートメントの実行
    $stmt->execute();
}


function login_validate($email, $password)
{
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
