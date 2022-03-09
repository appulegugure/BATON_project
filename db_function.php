<?php

require_once __DIR__ . '/functions.php';

//受注テーブルにデータ追加
function create_oreder($adult,$child,$title,$day,$number_of_peaple_id,$price,$Contents,$Prerequisite)
{
    $dbh = connect_db();
    try {
        $dbh->beginTransaction();

        $stmt1 = $dbh->prepare('INSERT INTO person_group(adult,child) VALUES (:adult,:child);');
        $stmt2 = $dbh->prepare('SET @LAST_ID_pg = LAST_INSERT_ID();');
        $stmt3 = $dbh->prepare('INSERT INTO order_ver_1(title,`day`,number_of_peaple_id,price,Contents,Prerequisite,community_id)
                                VALUES (:title,:day,:number_of_peaple_id,:price,:contents,:Prerequisite,@LAST_ID_pg);');

        $stmt1->bindParam( ':adult', $adult, PDO::PARAM_INT);
        $stmt1->bindParam( ':child', $child, PDO::PARAM_INT);
        $stmt3->bindParam( ':title', $title, PDO::PARAM_STR);
        $stmt3->bindParam( ':day', $day, PDO::PARAM_STR);
        $stmt3->bindParam( ':number_of_peaple_id', $number_of_peaple_id, PDO::PARAM_INT);
        $stmt3->bindParam( ':price', $price, PDO::PARAM_INT);
        $stmt3->bindParam( ':contents', $Contents, PDO::PARAM_STR);
        $stmt3->bindParam( ':Prerequisite', $Prerequisite, PDO::PARAM_STR);

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

//コミュニティ検索
function search_community_word($input_word)
{
    
    $dbh = connect_db();
    try {

        $stmt1 = $dbh->prepare("SELECT community_name from community WHERE community_content LIKE '%$input_word%';");
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e) {

        echo $e->getMessage();

    }
}

function search_community($user_id)
{
    $dbh = connect_db();
    try {
        $stmt1 = $dbh->prepare("SELECT community.community_name 
                                from community_user_test INNER JOIN community ON community_user_test.community = community.id
                                WHERE community_user_test.user_test = $user_id;");
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

//コミュニティ作成
function create_community($community_name,$community_maker,$conndition_1,$conndition_2,$conndition_3,$conndition_4,$conndition_5)
{
    $dbh = connect_db();
    try {
        $dbh->beginTransaction();
        $stmt1 = $dbh->prepare('INSERT INTO community(community_name,community_maker,condition1,condition2,condition3,condition4,condition5) 
                                VALUES (:community_name,:community_maker,:conndition_1,:conndition_2,:conndition_3,:conndition_4,:conndition_5);');
        $stmt1->bindParam( ':community_name', $community_name, PDO::PARAM_STR);
        $stmt1->bindParam( ':community_maker', $community_maker, PDO::PARAM_INT);
        $stmt1->bindParam( ':conndition_1', $conndition_1, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_2', $conndition_2, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_3', $conndition_3, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_4', $conndition_4, PDO::PARAM_STR);
        $stmt1->bindParam( ':conndition_5', $conndition_5, PDO::PARAM_STR);
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

function create_community_user($user_id,$community_id)
{
    $dbh = connect_db();
    try {
        $dbh->beginTransaction();
        $stmt1 = $dbh->prepare("INSERT INTO community_user_test(user_test,community) 
                                VALUES (:user_id_s,:community_id);");
        $stmt1->bindParam( ':user_id_s', $user_id, PDO::PARAM_INT);
        $stmt1->bindParam( ':community_id', $community_id, PDO::PARAM_INT);
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


function create_order($a,$b,$c,$e,$d)
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


function community_all()
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
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
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