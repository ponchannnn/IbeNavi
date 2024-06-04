<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人情報</title>
</head>
<body>

<h2><a href="personal">個人情報</a>→氏名</h2>
<form method="post" action="../save_account_info">
    <label for="lastname" >苗字:</label>
    <input type="text" id="lastname" name="lastname"><br>
    <label for="firstname" >名前:</label>
    <input type="text" id="firstname" name="firstname"><br>
    <input type="submit" value="保存"><!-- script書く-->
</form>

<a href="personal">戻る</a>

</body>
</html>
