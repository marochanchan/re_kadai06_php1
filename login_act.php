<?php

session_start();

$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

require_once("funcs.php");

$pdo = db_conn();

$sql = "SELECT * FROM gs_user_table
        WHERE lid=:lid
        AND life_flg=0";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(":lid",$lid,PDO::PARAM_STR);

$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user && password_verify($lpw,$user["lpw"])){

    session_regenerate_id(true);

    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["kanri_flg"] = $user["kanri_flg"];
    $_SESSION["name"] = $user["name"];

    redirect("read.php");

}else{

    redirect("login.php");

}