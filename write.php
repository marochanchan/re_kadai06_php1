<?php

session_start();

require_once("funcs.php");

sschk();

if($_SESSION["kanri_flg"] != 1){
    exit("権限がありません");
}

$item_name = $_POST["item_name"];
$season = $_POST["season"];
$category = $_POST["category"];
$brand = $_POST["brand"];
$purchase_date = $_POST["purchase_date"];
$comment = $_POST["comment"];

// 元の画像名を取得
$image_name = $_FILES["image"]["name"];
$tmp_name = $_FILES["image"]["tmp_name"];

// 同じ画像名でも重複しないよう現在時刻をファイル名に付ける
$image_name = date("YmdHis") . "_" . $image_name;

// 画像をuploadフォルダへ保存
move_uploaded_file(
    $tmp_name,
    "upload/".$image_name
);

//画像を保存した後に保存した画像名をDBへ登録
$pdo = db_conn();

//DB登録
$sql = "INSERT INTO closet_table
(item_name, season, category, brand, purchase_date, comment, image_name, indate)

VALUES

(:item_name, :season, :category, :brand, :purchase_date, :comment, :image_name, sysdate())";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':item_name', $item_name);
$stmt->bindValue(':season', $season);
$stmt->bindValue(':category', $category);
$stmt->bindValue(':brand', $brand);
$stmt->bindValue(':purchase_date', $purchase_date);
$stmt->bindValue(':comment', $comment);
$stmt->bindValue(':image_name', $image_name);

$status = $stmt->execute();

if($status == false){

    sql_error($stmt);

}

?>

<html>
<head>
<meta charset="utf-8">
<title>登録確認</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">

<h1>登録内容</h1>
<p>表示名：<?= h($item_name) ?></p>
<p>シーズン：<?= h($season) ?></p>
<p>カテゴリ：<?= h($category) ?></p>
<p>ブランド：<?= h($brand) ?></p>
<p>購入日：<?= h($purchase_date) ?></p>
<p>コメント：<?= h($comment) ?></p>

<a href="read.php">クローゼットを見る</a>

</div>

</body>
</html>