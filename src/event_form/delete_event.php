<?php
if (empty($_GET["eventid"])) {
    header("Location: input_event");
    exit();
}
$get_eventid = $_GET["eventid"];
require_once(dirname(__FILE__)."/../IsLoggedIn.php");
$logged = new IsLoggedIn();
$logged->setOriginalUrl("/show_event/my_event");
$dbh = $logged->getDbh();
$uuid = $logged->getUuid();
$stmt = $dbh->prepare("SELECT * FROM events WHERE eventid = :eventid");
if($stmt) {
    $stmt->bindParam(":eventid", $get_eventid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
if (!$row) {
    header("Location: input_event");
    exit();
} else if ($row["accountid"] != $uuid) {
    header("Location: not_your_event");
    exit();
}

// イベント削除
$stmt = $dbh->prepare("DELETE FROM events WHERE eventid = :eventid");
if($stmt) {
    $stmt->bindParam(":eventid", $get_eventid);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベント削除完了</title>
</head>
<body>
    <?php include("../header/header.php"); ?>
    <h1 class="container">イベントを削除しました</h1>
</body>
</html>