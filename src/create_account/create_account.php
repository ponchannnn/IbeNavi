<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
</head>
<body>
    <?php include("../header/header.php"); ?><div class="container"></div>
    <h1>会員登録</h1>
    <form method="post" action="set_account">
        <input type="radio" name="account_roles" id="participant" value="1">
        <label for="participant">参加者</label>
		<input type="radio" name="account_roles" id="organizer" value="2">
        <label for="organizer">主催者</label><br>
        <label for="username">ユーザ名:</label>
        <input type="text" name="username" id="username" required>
        <label id="username_chk" style="display: none; color: red;"></label><br>
        <label for="userid">ユーザID:</label>
        <label>@</label><input type="text" name="userid" id="userid" autocomplete=”username” required>
        <label id="userid_chk" style="display: none; color: red;"></label><br>
        <label for="password">パスワード:</label>
        <input type="password" name="password"  id="password" autocomplete=”new-password” required>
        <label id="password_chk" style="display: none; color: red;"></label><br>
        <label for="password2">パスワード再入力:</label>
        <input type="password" name="password2" id="password2" required>
        <label id="upassword2_chk" style="display: none; color: red;"></label><br>
        <label for="email">メールアドレス:</label>
        <input type="email" name="email" id="email" autocomplete=”email” required>
        <label id="email_chk" style="display: none; color: red;"></label><br>
        <label for="birthday">誕生日:</label>
        <input type="date" name="birthday" id="birthday" required>
        <label id="birthday_chk" style="display: none; color: red;"></label><br>
        <label for="lastname">苗字:</label>
        <input type="text" name="lastname" id="lastname" required>
        <label id="lastname_chk" style="display: none; color: red;"></label><br>
        <label for="firstname">名前:</label>
        <input type="text" name="firstname" id="firstname" required>
        <label id="firstnam_chk" style="display: none; color: red;"></label><br>
        <label for="postnumber">郵便番号:</label>
        <input type="text" name="postnumber" id="postnumber" required>
        <label id="postnumber_chk" style="display: none; color: red;"></label><br>
        <label for="address">住所:</label>
        <input type="text" name="address" id="address" required>
        <label id="address_chk" style="display: none; color: red;"></label><br>
        <label for="phonenumber">電話番号:</label>
        <input type="text" name="phonenumber" id="phonenumber" required>
        <label id="phonenumber_chk" style="display: none; color: red;"></label><br>
        <input type="submit" id="confirm" value="確認">
    </form>
</body>
</html>