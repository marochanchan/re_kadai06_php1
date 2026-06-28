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

// 検索条件の受け取り。GETで送られてきた値を取得。空なら「全件表示」になる
$search_season = $_GET["season"] ?? "";
$search_category = $_GET["category"] ?? "";

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


//一覧表示用のSQLを作る
$sql = "SELECT * FROM closet_table WHERE 1=1";

// シーズンが選ばれていたら条件を追加
if($search_season != ""){
    $sql .= " AND season = :season";
}

// カテゴリが選ばれていたら条件を追加
if($search_category != ""){
    $sql .= " AND category = :category";
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

カテゴリ
<select name="category">

<option value=""
<?php if($search_category=="") echo "selected"; ?>>
指定なし
</option>

<option value="トップス"
<?php if($search_category=="トップス") echo "selected"; ?>>
トップス
</option>

<option value="ボトムス"
<?php if($search_category=="ボトムス") echo "selected"; ?>>
ボトムス
</option>

<option value="アウター"
<?php if($search_category=="アウター") echo "selected"; ?>>
アウター
</option>

<option value="その他"
<?php if($search_category=="その他") echo "selected"; ?>>
その他
</option>
</select>

<input type="submit" value="検索">

</form>

<!-- ==========================
カテゴリ別登録枚数
GROUP BYで集計した結果を表示
========================== -->

<div class="summary-card">

<h2>📊 カテゴリ別登録枚数</h2>

<?php
while($count = $stmt_count->fetch(PDO::FETCH_ASSOC)){
?>

<p>
<strong><?= h($count["category"]) ?></strong>
：<?= h($count["cnt"]) ?>着
</p>

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
<a href="edit.php?id=<?= $result["id"] ?>">編集</a>
<a href="delete.php?id=<?= $result["id"] ?>">削除</a>

</div>

<?php

}

?>

</div>



</body>
</html>