<?php
require_once(dirname(__FILE__)."/../../IsLoggedIn.php");
$logged = new IsLoggedIn();
$dbh = $logged->getDbh();
$uuid = $logged->getUuid();
$subbed_url = explode("/", $_SERVER['HTTP_REFERER']);
$original_url = end($subbed_url);
if ($original_url != "confirm_delete_account") {
    header("Location: /show_event/show_event");
    exit();
}

// アカウント削除
$stmt = $dbh->prepare("UPDATE users SET accountstatus = 'deleted' WHERE id = :uuid");
if($stmt) {
    $stmt->bindParam(":uuid", $uuid);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント削除完了</title>
</head>
<body>
    <?php include("../../header/header.php"); ?>
    <h1 class="container">アカウントを削除しました</h1>
</body>
</html>