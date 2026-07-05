<html>
<head>
<meta charset="utf-8">
<title>クローゼット登録</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div style="text-align:center;">
    <a class="page-link" href="read.php">
        ← クローゼット一覧へ
    </a>
</div>

	<h1>クローゼット登録</h1>

<div class="form-container">

<!-- ファイルも送れるようにenctypeを追加 -->
<form action="write.php" method="post" enctype="multipart/form-data">
	<label>表示名</label>
    <input type="text" name="item_name"><br><br>

    <label>シーズン</label>
    <select name="season">
        <option value="春夏">春夏</option>
        <option value="秋冬">秋冬</option>
    </select><br><br>

    <label>カテゴリ</label>
    <select name="category">
        <option value="トップス">トップス</option>
        <option value="ボトムス">ボトムス</option>
        <option value="アウター">アウター</option>
        <option value="シューズ">シューズ</option>
        <option value="その他">その他</option>
    </select><br><br>

    <label>ブランド</label>
    <input type="text" name="brand"><br><br>

    <label>購入日</label>
    <input type="date" name="purchase_date"><br><br>

    <label>写真</label>
    <input type="file" name="image"><br><br>

    <label>コメント</label>
    <textarea name="comment"></textarea><br><br>

    <input type="submit" value="登録">
</form>

</div>

</body>
</html>

