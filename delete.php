<?php

// funcs.phpを読み込む
require_once("funcs.php");

// idを取得
$id = $_GET["id"];

// DB接続
$pdo = db_conn();

// 削除SQL
$sql = "DELETE FROM closet_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

// エラー処理
if($status == false){
    sql_error($stmt);
}else{
    header("Location: read.php");
    exit();
}

?>