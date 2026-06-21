<?php

$id = $_GET["id"];

$lines = file("data/data.txt");

$data = explode(",", $lines[$id]);

?>

<html>
<head>
<meta charset="utf-8">
<title>編集</title>
</head>

<body>

<h1>編集画面</h1>

<form action="update.php" method="post">

<input type="hidden"
       name="id"
       value="<?= $id ?>">

<input type="hidden"
       name="image_name"
       value="<?= trim($data[7]) ?>">

表示名
<input type="text"
       name="item_name"
       value="<?= $data[1] ?>">

シーズン
<input type="text"
       name="season"
       value="<?= $data[2] ?>">

<br><br>

カテゴリ
<input type="text"
       name="category"
       value="<?= $data[3] ?>">

<br><br>

ブランド
<input type="text"
       name="brand"
       value="<?= $data[4] ?>">

<br><br>

購入日
<input type="date"
       name="purchase_date"
       value="<?= $data[5] ?>">

<br><br>

コメント
<textarea name="comment"><?= $data[6] ?></textarea>

<br><br>

<input type="submit" value="更新">

</form>

</body>
</html>