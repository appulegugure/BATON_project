<?php

require_once '../functions.php';

function insert_oreder($adult,$child,$title,$day,$number_of_peaple_id,$price,$Contents,$Prerequisite)
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

        // (6) SQL実行
        $res1 = $stmt1->execute();
        $res2 = $stmt2->execute();
        $res3 = $stmt3->execute();

        // test_1
        //var_dump($res1);
        //var_dump($res2);
        //var_dump($res3);

        if( $res1 && $res2 && $res3 ) {
            $dbh->commit();
        }

    }catch(PDOException $e) {
        // (8) エラーメッセージを出力
        echo $e->getMessage();
        // (9) ロールバック
        $dbh->rollBack();

    } finally {

    // (10) データベースの接続解除
    $dbh = null;
    }
}



