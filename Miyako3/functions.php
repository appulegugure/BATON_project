<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

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
    // if (!empty($str)) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    // } else {
    //     return '';
    // }
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
    user_email = :user
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
function create_community($community_name, $user_id, $condition1, $condition2, $condition3, $condition4, $condition5, $community_content)
{
    // DBへ接続
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    INSERT INTO
        community
        (community_name, user_email, condition1, condition2, condition3, condition4, condition5, community_content)
    VALUES
        (:community_name, :user_email, :condition1, :condition2, :condition3, :condition4, :condition5, :community_content) 
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindParam(':community_name', $community_name, PDO::PARAM_STR);
    $stmt->bindParam(':user_email', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':condition1', $condition1, PDO::PARAM_STR);
    $stmt->bindParam(':condition2', $condition2, PDO::PARAM_STR);
    $stmt->bindParam(':condition3', $condition3, PDO::PARAM_STR);
    $stmt->bindParam(':condition4', $condition4, PDO::PARAM_STR);
    $stmt->bindParam(':condition5', $condition5, PDO::PARAM_STR);
    $stmt->bindParam(':community_content', $community_content, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();
    // 登録されたIDの取得
    return $dbh->lastInsertId();
}

//community登録
function create_community_user($community_id, $user_email, $owner_flag)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    INSERT INTO
        community_user
        (community, user_email, flag)
    VALUES
        (:community, :user_email, :flag) 
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindParam(':community', $community_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
    $stmt->bindParam(':flag', $owner_flag, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();
}


//communityから抜ける
function withdraw_from_community($community_id, $user_email)
{
    // データベースに接続
    $dbh = connect_db();

    $sql = <<<EOM
    DELETE FROM
        community_user
    WHERE
        community = :community
    AND
        user_email = :user_email
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindParam(':community', $community_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);

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
function select_order_by_community($status, $community_list, $user_id)
{
    // データベースに接続
    $dbh = connect_db();

    //SQL文
    $sql = <<<EOM
    SELECT
        *
    FROM
        job_order
    INNER JOIN number_of_people
    ON job_order.people_id = number_of_people.id
    WHERE
        job_order.community_id IN (:community)
    AND
        status = :status
    AND NOT
        (order_user_email = :user_id)
    ORDER BY
        created_at
EOM;

    // community IDを連結する
    $community_keys = '';
    foreach ($community_list as $key => $community) {
        if ($key === 0) {
            $community_keys = $community['id'];
        } else {
            $community_keys .=  ',' . $community['id'];
        }
        // $community_keys = implode(',', $community);
    }

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);
    // パラメータのバインド
    $stmt->bindParam(':community', $community_keys, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 注文を取得する

function select_order_by_status($status, $user_id)

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
        status = :status
    AND NOT
        (order_user_email    = :user_id)

EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);
    // パラメータのバインド
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);


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
    ON community.id = community_user.community
    WHERE
    community_user.user_email = :user_id
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



//Order IDをキーに委託業務の詳細を取得する
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
    INNER JOIN number_of_people
    ON job_order.people_id = number_of_people.id
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
    receive_user_email = :user_id
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

function display_order_by_orderuser($user_id, $status)
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
    order_user_email = :user_id
    AND NOT
    status = :status
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);


    // パラメータのバインド
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
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


function update_order($user_id, $order_id, $status)
{
    // データベースに接続
    $dbh = connect_db();

    // Statusを抽出条件に指定してデータ取得

    $sql = <<<EOM
    UPDATE
        job_order
    SET
        status = :status,
        receive_user_email = :receive_user
    WHERE order_id = :order_id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);


    // パラメータのバインド
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_STR);
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

//ユーザーidから所属しているコミュニティを全て取得
//後でuser_idからemailに変更
function select_search_community($user_id)
{
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT community.id, community.community_name 
                                from community_user INNER JOIN community ON community_user.community = community.id
                                WHERE community_user.user_email = :user_id;");
        $stmt1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//コミュニティテーブルからcontentカラムを曖昧検索して該当したコミュニティネームを取得
//☆バインドでエラー
function select_search_community_word($input_word)
{
    $input_word = '%' . $input_word . '%';
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT community_name from community WHERE community_content LIKE :input_word;");
        $stmt1->bindParam(':input_word', $input_word, PDO::PARAM_STR);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//コミュニティテーブルからコミュニティidで条件を絞って全絡むをセレクト
function select_community_info($id)
{
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT * FROM community WHERE id = :id;");
        $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt1->execute();
        return $stmt1->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function create_oreder(
    $adult,
    $child,
    $order_user_email,
    $receive_user_email,
    $title,
    $job,
    $day,
    $price,
    $status,
    $condition1,
    $condition2,
    $condition3,
    $condition4,
    $condition5,
    $community_id
) {
    $dbh = connect_db();
    try {
        $dbh->beginTransaction();
        $stmt1 = $dbh->prepare('INSERT INTO Number_of_people(adult,child) VALUES (:adult,:child);');
        $stmt2 = $dbh->prepare('SET @LAST_ID_pg = LAST_INSERT_ID();');
        $stmt3 = $dbh->prepare('INSERT INTO job_order(order_user_email,receive_user_email,title,job,`day`,
                                people_id,price,status,condition1,condition2,condition3,condition4,condition5,community_id)
                                VALUES (:order_user_email,:receive_user_email,:title,:job,:day,
                                @LAST_ID_pg,:price,:status,:con1,:con2,:con3,:con4,:con5,:community_id);');
        $stmt1->bindParam(':adult', $adult, PDO::PARAM_INT);
        $stmt1->bindParam(':child', $child, PDO::PARAM_INT);
        $stmt3->bindParam(':order_user_email', $order_user_email, PDO::PARAM_STR);
        $stmt3->bindParam(':receive_user_email', $receive_user_email, PDO::PARAM_STR);
        $stmt3->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt3->bindParam(':job', $job, PDO::PARAM_STR);
        $stmt3->bindParam(':day', $day, PDO::PARAM_STR);
        //$stmt3->bindParam( ':number_of_peaple_id', $number_of_peaple_id, PDO::PARAM_INT);
        $stmt3->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt3->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt3->bindParam(':con1', $condition1, PDO::PARAM_STR);
        $stmt3->bindParam(':con2', $condition2, PDO::PARAM_STR);
        $stmt3->bindParam(':con3', $condition3, PDO::PARAM_STR);
        $stmt3->bindParam(':con4', $condition4, PDO::PARAM_STR);
        $stmt3->bindParam(':con5', $condition5, PDO::PARAM_STR);
        $stmt3->bindParam(':community_id', $community_id, PDO::PARAM_INT);
        $res1 = $stmt1->execute();
        $res2 = $stmt2->execute();
        $res3 = $stmt3->execute();
        // var_dump($res1);
        // var_dump($res2);
        // var_dump($res3);
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


function select_user_info($email)
{
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT * FROM user WHERE email = :email;");
        $stmt1->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt1->execute();
        return $stmt1->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function signup_validate($email, $name, $password, $company, $post, $prefe)
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
//二時間前のオーダーをセレクト
function two_hours_order()
{
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("
                                SELECT * FROM job_order WHERE SUBTIME(day,'02:00:00') <= NOW() AND NOT day < NOW();
                                ;");
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//委託中_進行_開催日-2時間で絞る
function select_search_received_progress_time_minus2($user_id)
{
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT * FROM job_order
                                WHERE order_user_email = :user_id 
                                AND status = '受注済'
                                -- AND day = --  
                                ;");
        $stmt1->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//開始日二時間前でステータス取り消し
function two_hours_order_set_reject()
{
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("UPDATE job_order
                                SET status = '取消し'
                                WHERE SUBTIME(day,'02:00:00') <= NOW(); 
                                -- AND NOT day < NOW();
                                ");
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function convert_from_array_to_sqlstring($array){
    $convert_to_array = [];
    $escape ='';
    foreach ($array as $key => $value) {
        $escape = "'".$value['community_name']."'";
        array_push($convert_to_array,$escape);
    }
    return implode(',',$convert_to_array);
    
}

//受注テーブルから未受注&指定したコミュニティで表示
//脆弱--バインド付けれない
function select_order_community_and_status($status,$community_id)
{
    $dbh = connect_db();
    try {
        
        //$stmt1 = $dbh->prepare('SELECT * from job_order INNER JOIN community ON job_order.community_id = community.id 
                                //WHERE status = :status AND (community.community_name = :community_id );');
        $stmt1 = $dbh->prepare("SELECT * from job_order INNER JOIN community ON job_order.community_id = community.id 
                                INNER JOIN Number_of_people ON job_order.people_id = Number_of_people.id
                                WHERE job_order.status = :status 
                                AND !SUBTIME(day,'02:00:00') <= NOW() 
                                AND NOT day < NOW()
                                AND community.community_name 
                                IN($community_id);");
        $stmt1->bindParam( ':status', $status, PDO::PARAM_STR);
        //$stmt1->bindParam( ':community_id', $community_id, PDO::PARAM_STR);
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    }catch(PDOException $e) {
        echo $e->getMessage();       
    }
}
/*
//二時間以内のオーダーはstatus = '取消し'
function select_order_community_and_status($status,$community_id)
{
    $dbh = connect_db();
    try {
        
        //$stmt1 = $dbh->prepare('SELECT * from job_order INNER JOIN community ON job_order.community_id = community.id 
                                //WHERE status = :status AND (community.community_name = :community_id );');
        $stmt1 = $dbh->prepare("SELECT * from job_order INNER JOIN community ON job_order.community_id = community.id 
                                WHERE job_order.status = :status 
                                AND !SUBTIME(day,'02:00:00') <= NOW() AND NOT day < NOW()
                                AND community.community_name 
                                IN($community_id);");
        $stmt1->bindParam( ':status', $status, PDO::PARAM_STR);
        //$stmt1->bindParam( ':community_id', $community_id, PDO::PARAM_STR);
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    }catch(PDOException $e) {
        echo $e->getMessage();       
    }
}

function convert_from_array_to_sqlstring($array){
    $convert_to_array = [];
    $escape ='';
    foreach ($array as $key => $value) {
        $escape = "'".$value['community_name']."'";
        array_push($convert_to_array,$escape);
    }
    return implode(',',$convert_to_array);
    
}
*/