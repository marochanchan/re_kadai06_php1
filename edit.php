<?php

require_once("funcs.php");

// idを取得
$id = $_GET["id"];

// DB接続
$pdo = db_conn();

// 編集するデータを取得
$sql = "SELECT * FROM closet_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status == false){
    sql_error($stmt);
}

// 1件だけ取得
$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<html>
<head>
<meta charset="utf-8">
<title>編集</title>
</head>

<body>

<h1>編集画面</h1>

<form action="update.php" method="post">

<!-- idを更新時に渡す -->
<input type="hidden"
       name="id"
       value="<?= h($id) ?>">

<!-- 画像名を更新時に渡す -->
<input type="hidden"
       name="image_name"
       value="<?= h($result["image_name"]) ?>">

表示名
<input type="text"
       name="item_name"
       value="<?= h($result["item_name"]) ?>">

シーズン

<!-- 現在登録されているシーズンを選択状態で表示する -->
<select name="season">
    <option value="春夏"
    <?php if($result["season"]=="春夏") echo "selected"; ?>>
    春夏
    </option>

    <option value="秋冬"
    <?php if($result["season"]=="秋冬") echo "selected"; ?>>
    秋冬
    </option>
</select>

<br><br>

カテゴリ

<!-- 現在登録されているカテゴリを選択状態で表示する -->
<select name="category">
    <option value="トップス"
    <?php if($result["category"]=="トップス") echo "selected"; ?>>
    トップス
    </option>

    <option value="ボトムス"
    <?php if($result["category"]=="ボトムス") echo "selected"; ?>>
    ボトムス
    </option>

    <option value="アウター"
    <?php if($result["category"]=="アウター") echo "selected"; ?>>
    アウター
    </option>

    <option value="シューズ"
    <?php if($result["category"]=="シューズ") echo "selected"; ?>>
    シューズ
    </option>


    <option value="その他"
    <?php if($result["category"]=="その他") echo "selected"; ?>>
    その他
    </option>
</select>

<br><br>

ブランド
<input type="text"
       name="brand"
       value="<?= h($result["brand"]) ?>">

<br><br>

購入日
<input type="date"
       name="purchase_date"
       value="<?= h($result["purchase_date"]) ?>">

<br><br>

コメント
<textarea name="comment"><?= h($result["comment"]) ?></textarea>

<br><br>

<input type="submit" value="更新">

</form>

</body>
</html>