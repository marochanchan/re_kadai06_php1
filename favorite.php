<?php

session_start();

require_once("funcs.php");

sschk();

if($_SESSION["kanri_flg"] != 1){
    exit("権限がありません");
}

$id = $_GET["id"];
$return = $_GET["return"] ?? "";

$pdo = db_conn();

// 現在のお気に入り状態を取得
$sql = "SELECT favorite FROM closet_table WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id",$id,PDO::PARAM_INT);

$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// 0⇔1を切り替え
$newFavorite = ($result["favorite"] == 1) ? 0 : 1;

// 更新
$sql = "UPDATE closet_table
SET favorite=:favorite
WHERE id=:id";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(":favorite",$newFavorite,PDO::PARAM_INT);
$stmt->bindValue(":id",$id,PDO::PARAM_INT);

$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
}

if($return != ""){
    header("Location: read.php#$return");
}else{
    header("Location: read.php");
}

exit();

?>