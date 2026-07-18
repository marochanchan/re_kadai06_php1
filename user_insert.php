<?php

session_start();

require_once("funcs.php");

sschk();

// 管理者のみ
if($_SESSION["kanri_flg"] != 1){
    exit("権限がありません");
}

$name = $_POST["name"];
$lid = $_POST["lid"];
$lpw = password_hash($_POST["lpw"], PASSWORD_DEFAULT);

$kanri_flg = $_POST["kanri_flg"];

$pdo = db_conn();

$sql = "INSERT INTO gs_user_table
(name,lid,lpw,kanri_flg,life_flg)

VALUES

(:name,:lid,:lpw,:kanri_flg,0)";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(":name",$name);
$stmt->bindValue(":lid",$lid);
$stmt->bindValue(":lpw",$lpw);
$stmt->bindValue(":kanri_flg",$kanri_flg,PDO::PARAM_INT);

$status = $stmt->execute();

if($status==false){

    sql_error($stmt);

}

redirect("read.php");