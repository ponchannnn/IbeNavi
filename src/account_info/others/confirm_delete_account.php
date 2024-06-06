<?php
require_once(dirname(__FILE__)."/../../IsLoggedIn.php");
$userid = (new IsLoggedIn())->getUserId();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント削除確認</title>
</head>
<body>
    <?php include("../../header/header.php"); ?><div class="container"></div>
    <h2>ほんとうにアカウント[<?php echo $userid; ?>]を削除しますか？</h2>
    <form action="delete_account">
        <input type="submit" name="accept" value="削除"></input>
    </form>
    <form action="others">
        <input type="submit" name="cancel" value="キャンセル"></input>
    </form>
</body>
</html>