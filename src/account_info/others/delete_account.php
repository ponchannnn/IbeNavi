<?php
require_once(dirname(__FILE__)."/../../IsLoggedIn.php");
$logged = new IsLoggedIn();
$dbh = $logged->getDbh();
$uuid = $logged->getUuid();

// アカウント削除
$stmt = $dbh->prepare("DELETE FROM users WHERE id = :uuid");
if($stmt) {
    $stmt->bindParam(":uuid", $uuid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <div><?php print_r($row) ?></div>
</body>
</html>