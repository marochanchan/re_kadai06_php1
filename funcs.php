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
            'mysql:dbname=gs_db_kadai08;charset=utf8mb4;host=localhost',
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

//SessionCheck
function sschk(){

    if(
        !isset($_SESSION["chk_ssid"]) ||
        $_SESSION["chk_ssid"] != session_id()
    ){

        exit("LOGIN ERROR");

    }else{

        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();

    }

}

//リダイレクト
function redirect($file_name){

    header("Location: ".$file_name);

    exit();

}


?>