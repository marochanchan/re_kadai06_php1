<?php

session_start();

require_once("funcs.php");

sschk();

// 管理者以外は入れない
if($_SESSION["kanri_flg"] != 1){
    exit("権限がありません");
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ユーザー登録</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<h1>ユーザー登録</h1>

<div class="form-container">

<form action="user_insert.php" method="post">

<label>名前</label>
<input type="text" name="name" required>

<label>ログインID</label>
<input type="text" name="lid" required>

<label>パスワード</label>
<input type="password" name="lpw" required>

<label>権限</label>

<select name="kanri_flg">

<option value="0">一般ユーザー</option>

<option value="1">管理者</option>

</select>

<br><br>

<input type="submit" value="登録">

</form>

</div>

</body>
</html>