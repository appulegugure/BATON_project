<?php

require_once '../functions.php';

function create_oreder($adult,$child,$title,$day,$number_of_peaple_id,$price,$Contents,$Prerequisite)
{
    
    // データベースに接続
    $dbh = connect_db();

    try {
        $dbh->beginTransaction();

        // (4) データを登録するSQL
        $stmt1 = $dbh->prepare('INSERT INTO person_group(adult,child) VALUES (:adult,:child);');
        $stmt2 = $dbh->prepare('SET @LAST_ID_pg = LAST_INSERT_ID();');
        $stmt3 = $dbh->prepare('INSERT INTO order_ver_1(title,`day`,number_of_peaple_id,price,Contents,Prerequisite,community_id)
                                VALUES (:title,:day,:number_of_peaple_id,:price,:contents,:Prerequisite,@LAST_ID_pg);');

        // (5) 値をセット
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

    // (10) データベースの接続解除
    $dbh = null;
    }
}




function select_order_all_ALL()
{
    
    // データベースに接続
    $dbh = connect_db();
    try {
        
        $stmt1 = $dbh->prepare('SELECT * FROM order_ver_1 INNER JOIN person_group ON order_ver_1.community_id = person_group.id;');
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    }catch(PDOException $e) {
        
        echo $e->getMessage();
        
    }
}


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

function display_order($id)
{
    
    // データベースに接続
    $dbh = connect_db();
    try {
        // (4) データを登録するSQL
        $stmt1 = $dbh->prepare("
                                SELECT 
                                order_ver_1.title, 
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
        // (8) エラーメッセージを出力
        echo $e->getMessage();
        // (9) ロールバック
    }
}

function search_community($input_word)
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

function create_community($a,$b,$c,$e,$d)
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


function create_community_user($user_id)
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
