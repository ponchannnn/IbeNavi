<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>基本情報</title>
</head>
<body>
<?php include("../../header/header.php"); ?><div class="container"></div>
<h2><a href="basic">基本情報</a>→メールアドレス</h2>
<form method="post" action="../save_account_info">
    <label for="email" >メールアドレス:</label>
    <input type="email" id="email" name="email">
    <input type="submit" value="保存"><!-- script書く-->
</form>

<a href="basic">戻る</a>

</body>
</html>
