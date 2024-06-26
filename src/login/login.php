<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント情報</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <?php include("../header/header.php"); ?>
    <div class="container">
        <p>イベナビ<!-- 後々ロゴにする --></p>
    </div>
<div class="tab">
    <form method="post" action="<?php if (empty($_GET['original_url'])) echo "login_user"; else echo "login_user?original_url={$_GET['original_url']}" ?>">
        <label for="userId">ユーザID</label><br></br><label>@</label>
        <input type="text" id="userId" name="userId" autocomplete=”username” required><br></br>
        <label for="password">パスワード</label><br></br>
        <input type="password" id="password" name="password" autocomplete=”current-password” required><br></br>
        <input type="submit" value="ログイン"><!-- script書く-->
    </form>
</div>
</body>
</html>
