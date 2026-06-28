<?php
//共通に使う関数を記述

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}


//DBConnection
function db_conn(){
    try{

        $pdo = new PDO(
            'mysql:dbname=gs_db;charset=utf8mb4;host=localhost',
            'root',
            ''
        );

        return $pdo;

    }catch(PDOException $e){

        exit("DBConnect Error:".$e->getMessage());

    }

}


//SQLエラー
function sql_error($stmt){

    $error = $stmt->errorInfo();

    exit("SQL Error:".$error[2]);

}


//リダイレクト
function redirect($file_name){

    header("Location: ".$file_name);

    exit();

}


?>