<?php

session_start();

require_once("funcs.php");

sschk();

if($_SESSION["kanri_flg"] != 1){
    exit("権限がありません");
}

// POSTデータを取得
$id = $_POST["id"];
$item_name = $_POST["item_name"];
$season = $_POST["season"];
$category = $_POST["category"];
$brand = $_POST["brand"];
$purchase_date = $_POST["purchase_date"];
$comment = $_POST["comment"];
$image_name = $_POST["image_name"] ?? "";

// DB接続
$pdo = db_conn();

// 更新用SQL
$sql = "UPDATE closet_table SET
            item_name = :item_name,
            season = :season,
            category = :category,
            brand = :brand,
            purchase_date = :purchase_date,
            comment = :comment,
            image_name = :image_name
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

// フォームの値をSQLに渡す
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->bindValue(":item_name", $item_name);
$stmt->bindValue(":season", $season);
$stmt->bindValue(":category", $category);
$stmt->bindValue(":brand", $brand);
$stmt->bindValue(":purchase_date", $purchase_date);
$stmt->bindValue(":comment", $comment);
$stmt->bindValue(":image_name", $image_name);

// SQL実行
$status = $stmt->execute();

// エラー処理
if($status == false){

    sql_error($stmt);

}else{

    // 更新後は一覧画面へ戻る
    header("Location: read.php");
    exit();

}

?>