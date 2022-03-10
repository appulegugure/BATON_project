<?php

require_once __DIR__ . '/functions.php';


//
//受注テーブルにデータ追加
function create_order($adult,$child,$order_user_email,$title,$job,$day,
                    $price,$status,$condition1,$condition2,$condition3,$condition4,$condition5,$community_id)
{
    $dbh = connect_db();
    try {
        $dbh->beginTransaction();

        $stmt1 = $dbh->prepare('INSERT INTO Number_of_people(adult,child) VALUES (:adult,:child);');
        $stmt2 = $dbh->prepare('SET @LAST_ID_pg = LAST_INSERT_ID();');
        $stmt3 = $dbh->prepare('INSERT INTO job_order(order_user_email,title,job,`day`,
                                people_id,price,status,condition1,condition2,condition3,condition4,condition5,community_id)
                                VALUES (:order_user_email,:receive_user_email,:title,:job,:day,
                                @LAST_ID_pg,:price,:status,:con1,:con2,:con3,:con4,:con5,:community_id);');

        $stmt1->bindParam( ':adult', $adult, PDO::PARAM_INT);
        $stmt1->bindParam( ':child', $child, PDO::PARAM_INT);
        $stmt3->bindParam( ':order_user_email', $order_user_email, PDO::PARAM_STR);
        $stmt3->bindParam( ':receive_user_email', $receive_user_email, PDO::PARAM_STR);
        $stmt3->bindParam( ':title', $title, PDO::PARAM_STR);
        $stmt3->bindParam( ':job', $job, PDO::PARAM_STR);
        $stmt3->bindParam( ':day', $day, PDO::PARAM_STR);
        //$stmt3->bindParam( ':number_of_peaple_id', $number_of_peaple_id, PDO::PARAM_INT);
        $stmt3->bindParam( ':price', $price, PDO::PARAM_INT);
        $stmt3->bindParam( ':status', $status, PDO::PARAM_STR);

        $stmt3->bindParam( ':con1',$condition1, PDO::PARAM_STR);
        $stmt3->bindParam( ':con2',$condition2, PDO::PARAM_STR);
        $stmt3->bindParam( ':con3',$condition3, PDO::PARAM_STR);
        $stmt3->bindParam( ':con4',$condition4, PDO::PARAM_STR);
        $stmt3->bindParam( ':con5',$condition5, PDO::PARAM_STR);
        $stmt3->bindParam( ':community_id', $community_id, PDO::PARAM_INT);

        $res1 = $stmt1->execute();
        $res2 = $stmt2->execute();
        $res3 = $stmt3->execute();

        if( $res1 && $res2 && $res3 ) {
            $dbh->commit();
        }

    }catch(PDOException $e) {
        echo $e->getMessage();
        $dbh->rollBack();
    } finally {
        $dbh = null;
    }
}

//受注テーブルから未受注表示
function select_order_status($status)
{
    $dbh = connect_db();
    try {
        
        $stmt1 = $dbh->prepare('SELECT * from job_order WHERE status = :status;');
        $stmt1->bindParam( ':status', $status, PDO::PARAM_STR);
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    }catch(PDOException $e) {
        echo $e->getMessage();       
    }
}
//受注テーブルから未受注&指定したコミュニティで表示
function select_order_community_and_status($status,$community_id)
{
    $dbh = connect_db();
    try {
        
        $stmt1 = $dbh->prepare('SELECT * from job_order WHERE status = :status AND community_id = :community_id;');
        $stmt1->bindParam( ':status', $status, PDO::PARAM_STR);
        $stmt1->bindParam( ':community_id', $community_id, PDO::PARAM_STR);
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    }catch(PDOException $e) {
        echo $e->getMessage();       
    }
}
//受注テーブル一覧表示
function select_order_all_ALL()
{
    $dbh = connect_db();
    try {
        
        $stmt1 = $dbh->prepare('SELECT * FROM order_ver_1 INNER JOIN person_group ON order_ver_1.community_id = person_group.id;');
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    }catch(PDOException $e) {
        echo $e->getMessage();       
    }
}

//受注テーブル一覧をコミュニティーIDで絞って表示
function select_order_all($community_id)
{
    
    $dbh = connect_db();
    try {

        $stmt1 = $dbh->prepare("");
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e) {
        echo $e->getMessage();        
    }
}
//CREATE OR INSET系
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
    
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
}


function display_community($community_id)
{

    $dbh = connect_db();
    try {

        $stmt1 = $dbh->prepare("");
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e) {

        echo $e->getMessage();

    }
}

//コミュニティ作成時
function create_community($community_name,$user_email,$conndition_1,$conndition_2,$conndition_3,$conndition_4,$conndition_5,$content)
{
    $dbh = connect_db();
    try {
        $dbh->beginTransaction();
        $stmt1 = $dbh->prepare('INSERT INTO community(community_name,user_email,condition1,condition2,condition3,condition4,condition5,community_content) 
                                VALUES (:community_name,:user_email,:conndition_1,:conndition_2,:conndition_3,:conndition_4,:conndition_5,:community_content);');
        $stmt2 = $dbh->prepare('SET @LAST_COM_ID = LAST_INSERT_ID();');
        $stmt3 = $dbh->prepare("INSERT INTO community_user(community,user_email,flag) 
                                VALUES (@LAST_COM_ID,:user_email,TRUE);");
        $stmt1->bindParam( ':community_name', $community_name, PDO::PARAM_STR);
        $stmt1->bindParam( ':user_email', $user_email, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_1', $conndition_1, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_2', $conndition_2, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_3', $conndition_3, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_4', $conndition_4, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_5', $conndition_5, PDO::PARAM_STR);
        $stmt1->bindParam( ':community_content', $content, PDO::PARAM_STR);
        $stmt3->bindParam( ':user_email', $user_email, PDO::PARAM_STR);
        $res1 = $stmt1->execute();
        $res2 = $stmt2->execute();
        $res3 = $stmt3->execute();

        if( $res1 && $res2 && $res3) {
            $dbh->commit();
        }
    }catch(PDOException $e) {
        echo $e->getMessage();
        $dbh->rollBack();
    } finally {
    $dbh = null;
    }
}

//コミュニティ参加時
function insert_community_user($community_id,$user_email)
{
    $dbh = connect_db();
    try {
        $dbh->beginTransaction();
        $stmt1 = $dbh->prepare("INSERT INTO community_user(community,user_email) 
                                VALUES (:community_id,:user_email);");
        $stmt1->bindParam( ':community_id', $community_id, PDO::PARAM_INT);
        $stmt1->bindParam( ':user_email', $user_email, PDO::PARAM_STR);
        $res1 = $stmt1->execute();
        if( $res1 ) { 
            $dbh->commit();
        }
    }catch(PDOException $e) {
        echo $e->getMessage();
        $dbh->rollBack();
    } finally {
    $dbh = null;
    }
}

####################################################################################


function update_order_status($order_id,$user_id)
{
    
    $dbh = connect_db();
    try {

        $stmt1 = $dbh->prepare("");
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    }catch(PDOException $e) {
        
        echo $e->getMessage();

    }
}
// CREATE

//SELECT -- 系 -- 
//全コミュニティーの名前をSELECT

function select_community_all()
{    
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT community_name from community;");
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
}

//コミュニティテーブルからコミュニティidで条件を絞って全絡むをセレクト
function select_community_info($id){
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT * FROM community WHERE id = :id;");
        $stmt1->bindParam( ':id', $id, PDO::PARAM_STR);
        $stmt1->execute();
        return $stmt1->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
}

//userテーブルからemailで条件を絞って全カラムをセレクト
function select_user_info($email){
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT * FROM user WHERE email = :email;");
        $stmt1->bindParam( ':email', $email, PDO::PARAM_STR);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
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
        $stmt1 = $dbh->prepare("SELECT community_name from community 
                                WHERE community_content LIKE :input_word; 
                                OR condition1 LIKE :input_word
                                OR condition2 LIKE :input_word
                                OR condition3 LIKE :input_word
                                OR condition4 LIKE :input_word
                                OR condition5 LIKE :input_word
                                ");
        $stmt1->bindParam( ':input_word', $input_word, PDO::PARAM_STR);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
}


//ユーザーidから所属しているコミュニティを全て取得
//後でuser_idからemailに変更
function select_search_community($user_id)
{
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT community.community_name 
                                from community_user INNER JOIN community ON community_user.community = community.id
                                WHERE community_user.user_email = :user_id;");
        $stmt1->bindParam( ':user_id', $user_id, PDO::PARAM_STR);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
        echo $e->getMessage();

    }
}

//##################   Miyako3 から ファンクションを追加   ##################
// 注文を取得する
function select_order_by_status()
{
    // データベースに接続
    $dbh = connect_db();

    //SQL文
    $sql = <<<EOM
    SELECT
        *
    FROM
        job_order
EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);
    // パラメータのバインド
    // $status = NULL;
    // $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}