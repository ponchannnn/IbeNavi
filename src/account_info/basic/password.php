<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>基本情報</title>
    <style>
    </style>
</head>
<body>
<?php include("../../header/header.php"); ?><div class="container"></div>
<h2><a href="basic">基本情報</a>→パスワード</h2>
<form method="post" action="../save_account_info">
    <label for="oldMailaddress" >現在のパスワード:</label>
    <input type="password" id="textPassword" name="oldPassword"><br><br>
    <label for="mailaddress" >新しいパスワード:</label>
    <input type="password" id="textPssword" name="newPassword"><br><br>
    <label for="confirmMailaddress" >新しいパスワードの確認:</label>
    <input type="password" id="textPassword" name="confirmPassword"><br><br>
    <input type="submit" value="保存"><br><br><!-- script書く-->
</form>
<a href="basic">戻る</a>

</body>
</html>
