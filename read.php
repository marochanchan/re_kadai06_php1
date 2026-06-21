<html>
<head>
<meta charset="utf-8">
<title>クローゼット一覧</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<h1>クローゼット一覧</h1>

<!-- 絞り込み検索機能、GETで条件をread.phpに送る -->
<form method="GET" action="read.php">

シーズン
<select name="season">
    <option value="">指定なし</option>
    <option value="春夏">春夏</option>
    <option value="秋冬">秋冬</option>
</select>

カテゴリ
<select name="category">
    <option value="">指定なし</option>
    <option value="トップス">トップス</option>
    <option value="ボトムス">ボトムス</option>
    <option value="アウター">アウター</option>
    <option value="その他">その他</option>
</select>

<input type="submit" value="検索">

</form>

<?php

// 検索条件の受け取り。GETで送られてきた値を取得。空なら「全件表示」になる
$search_season = $_GET["season"] ?? "";
$search_category = $_GET["category"] ?? "";

$file = fopen("data/data.txt","r"); //rはread（読み込み）

$num = 0; //削除のために何行目なのか区別させる

?>

<div class="container">

<?php
while (($line = fgets($file)) !== false) { 
//fgets($file)＝ノートから１行読む。whileは繰り返しなので、１行読める間はずっと繰り返してね
//forは回数が決まっている時の繰り返し。whileは条件が成り立つ間ずっと繰り返す
    $data = explode(",", $line); //カンマがあったらそこで切り分けてね

    if (count($data) < 7) {
    continue;
}

//絞り込み処理。条件に合わないものはスキップ
//シーズン一致チェック
if ($search_season !== "" && $data[2] !== $search_season) {
    continue;
}
//カテゴリ一致チェック
if ($search_category !== "" && $data[3] !== $search_category) {
    continue;
}

?>

<!-- カードの表示 -->
<div class="card">

<!-- 画像表示（7番目のデータ） -->
<img class="item_image"
     src="upload/<?= $data[7] ?? '' ?>">

    <h2 class="item_name">
        <?= $data[1] ?>
    </h2>

<!-- 項目表示 -->
<p>シーズン：<?= $data[2] ?></p>
<p>カテゴリ：<?= $data[3] ?></p>
<p>ブランド：<?= $data[4] ?></p>
<p>購入日：<?= $data[5] ?></p>
<p>コメント：<?= $data[6] ?></p>

<!-- 編集・削除リンク（行番号で識別） -->
<a href="edit.php?id=<?= $num ?>">編集</a>
<a href="delete.php?id=<?= $num ?>">削除</a>

</div>

<?php

// 次の行へ（ID用）
$num++;

}
?>

</div>

<?php
fclose($file);

?>

</body>
</html>