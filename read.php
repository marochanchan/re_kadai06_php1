<html>
<head>
<meta charset="utf-8">
<title>クローゼット一覧</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php

// funcs.phpを読み込む（DB接続やXSS対策の関数を使用するため）
require_once("funcs.php");

//DB接続
$pdo = db_conn();

// ----------------------------
// 検索条件を受け取る
// season：シーズン検索
// category：カテゴリボタン検索
// sort：新しい順・古い順
// ----------------------------
$search_season = $_GET["season"] ?? "";
$search_category = $_GET["category"] ?? "";
$sort = $_GET["sort"] ?? "new";

// お気に入りだけ表示するか
$favorite = $_GET["favorite"] ?? "";

// ----------------------------
// カテゴリごとの登録枚数を取得
// GROUP BYでカテゴリごとに件数を集計する
//COUNT(*) 件数を数える
//GROUP BY categoryごとにまとめる
// ----------------------------
$sql_count = "SELECT category, COUNT(*) AS cnt
              FROM closet_table
              GROUP BY category";

$stmt_count = $pdo->prepare($sql_count);

$status = $stmt_count->execute();

if($status == false){
    sql_error($stmt_count);
}

// ----------------------------
// 一覧表示用SQL
// WHERE 1=1 にしておくことで
// 後からAND条件を追加しやすくしている
// ----------------------------
$sql = "SELECT * FROM closet_table WHERE 1=1";

// シーズン検索が指定されたら条件追加
if($search_season != ""){
    $sql .= " AND season = :season";
}

// カテゴリボタンが押されたら条件追加
if($search_category != ""){
    $sql .= " AND category = :category";
}

// お気に入りだけ表示
if($favorite == "1"){
    $sql .= " AND favorite = 1";
}

// ----------------------------
// 表示順を変更
// new：新しい順
// old：古い順
// ----------------------------
if($sort == "old"){
    $sql .= " ORDER BY id ASC";
}else{
    $sql .= " ORDER BY id DESC";
}

// SQLの準備
$stmt = $pdo->prepare($sql);

// 検索条件をSQLに渡す
if($search_season != ""){
    $stmt->bindValue(":season",$search_season);
}

if($search_category != ""){
    $stmt->bindValue(":category",$search_category);
}

// SQL実行
$status = $stmt->execute();

if($status==false){

    sql_error($stmt);

}

?>

<h1>クローゼット一覧</h1>

<div style="text-align:center;">
    <a class="page-link" href="post.php">
        ＋ 新しく登録する
    </a>
</div>

<!-- 絞り込み検索機能、GETで条件をread.phpに送る -->
<form method="GET" action="read.php">

シーズン
<select name="season">
    <option value=""
<?php if($search_season=="") echo "selected"; ?>>
指定なし
</option>
    <option value="春夏"
<?php if($search_season=="春夏") echo "selected"; ?>>
春夏
</option>
    <option value="秋冬"
<?php if($search_season=="秋冬") echo "selected"; ?>>
秋冬
</option>
</select>

<label>並び順</label>

<select name="sort">

<option value="new"
<?= $sort=="new" ? "selected" : "" ?>>
新しい順
</option>

<option value="old"
<?= $sort=="old" ? "selected" : "" ?>>
古い順
</option>

</select>

<input type="submit" value="検索する">

</form>

<div class="favorite-filter">

<a
class="<?= $favorite=="" ? "active" : "" ?>"
href="read.php?season=<?= h($search_season) ?>&category=<?= h($search_category) ?>&sort=<?= h($sort) ?>">

📋 すべて表示

</a>

<a
class="<?= $favorite=="1" ? "active" : "" ?>"
href="read.php?season=<?= h($search_season) ?>&category=<?= h($search_category) ?>&sort=<?= h($sort) ?>&favorite=1">

❤️ お気に入りだけ

</a>

</div>

<h2 class="category-title">
カテゴリから探す
</h2>


<!-- カテゴリボタン -->
<div class="category-buttons">

<!-- 全件表示 -->
<a href="read.php?season=<?= h($search_season) ?>&sort=<?= h($sort) ?>"
class="<?= $search_category=="" ? "active" : "" ?>">

<div class="category-icon">🧺</div>
<div class="category-name">すべて</div>
<div class="count">全件</div>

</a>

<?php
// ----------------------------
// GROUP BYで取得したカテゴリを
// ボタンとして自動生成
// カテゴリが増えてもボタンは自動で追加される
// ----------------------------
while($count = $stmt_count->fetch(PDO::FETCH_ASSOC)){
?>

<a href="read.php?season=<?= h($search_season) ?>&category=<?= h($count["category"]) ?>&sort=<?= h($sort) ?>"
class="<?= $search_category==$count["category"] ? "active" : "" ?>">

<?php

// カテゴリごとのアイコン設定
// カテゴリが追加された場合は
// 必要に応じてアイコンを追加する
$icon = "";

if($count["category"]=="トップス"){
    $icon = "👕";
}
elseif($count["category"]=="ボトムス"){
    $icon = "👖";
}
elseif($count["category"]=="アウター"){
    $icon = "🧥";
}
elseif($count["category"]=="シューズ"){
    $icon = "👟";
}
else{
    $icon = "📦";
}

?>


<div class="category-icon">
    <?= $icon ?>
</div>

<div class="category-name">
    <?= h($count["category"]) ?>
</div>

<div class="count">
    <?= h($count["cnt"]) ?>着
</div>

</a>

<?php
}
?>

</div>

<div class="container">

<?php
// SQLで取得したデータを1件ずつ取り出してカード表示する
while($result = $stmt->fetch(PDO::FETCH_ASSOC)){


?>

<!-- カードの表示 -->
<div class="card">

<!-- お気に入りボタン -->
<a class="favorite-btn"
   href="favorite.php?id=<?= $result["id"] ?>">

<?= $result["favorite"] ? "❤️" : "🤍" ?>

</a>

<!-- 画像表示 -->
<?php if(!empty($result["image_name"])): ?>
<img class="item_image"
     src="upload/<?= h($result["image_name"]) ?>">
<?php endif; ?>

<h2 class="item_name">
    <?= h($result["item_name"]) ?>
</h2>

<!-- 項目表示 -->
<p>シーズン：<?= h($result["season"]) ?></p>
<p>カテゴリ：<?= h($result["category"]) ?></p>
<p>ブランド：<?= h($result["brand"]) ?></p>
<p>購入日：<?= h($result["purchase_date"]) ?></p>
<p>コメント：<?= h($result["comment"]) ?></p>

<!-- 編集・削除リンク（行番号で識別） -->
<div class="card-buttons">

    <a class="edit-btn"
       href="edit.php?id=<?= $result["id"] ?>">
        ✏️ 編集
    </a>

<a class="delete-btn"
   href="delete.php?id=<?= $result["id"] ?>"
   onclick="return confirm('本当に削除しますか？');">
    🗑️ 削除
</a>

</div>

</div>

<?php

}

?>

</div>



</body>
</html>