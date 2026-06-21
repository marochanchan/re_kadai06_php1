<?php
$item_name = $_POST["item_name"];
$season = $_POST["season"];
$category = $_POST["category"];
$brand = $_POST["brand"];
$purchase_date = $_POST["purchase_date"];
$comment = $_POST["comment"];

//画像を受け取る
$image_name = $_FILES["image"]["name"];
$tmp_name = $_FILES["image"]["tmp_name"]; //一時ファイル

//uploadフォルダに移動する
move_uploaded_file(
    $tmp_name,
    "upload/".$image_name
);

$c    = ",";

//保存する文字列(string=文字列)を作る、「.=は追加」
$str = date("Y-m-d H:i:s");
$str .= $c.$item_name;
$str .= $c.$season;
$str .= $c.$category;
$str .= $c.$brand;
$str .= $c.$purchase_date;
$str .= $c.$comment;

//画像名も追加
$str .= $c.$image_name;

//ファイルに追記(ノートを開く（aはappend=追記）→書く→閉じる)
$file = fopen("data/data.txt","a");
fwrite($file, $str."\n"); // \nは改行コード（オプション＋￥）
fclose($file);

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
<p>表示名：<?= $item_name ?></p>
<p>シーズン：<?= $season ?></p>
<p>カテゴリ：<?= $category ?></p>
<p>ブランド：<?= $brand ?></p>
<p>購入日：<?= $purchase_date ?></p>
<p>コメント：<?= $comment ?></p>

<a href="read.php">クローゼットを見る</a>

</div>

</body>
</html>