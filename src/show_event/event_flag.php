<?php
header("Content-type: application/json; charset=UTF-8");
require_once(dirname(__FILE__)."/../IsLoggedIn.php");
$logged = new IsLoggedIn();
$dbh = $logged->getDbh();
$uuid = $logged->getUuid();
$eventId = $_POST["eventId"];
$flag = $_POST["flag"];
if ($flag == "true") {
    $event_append = "CAST('{" . $eventId . "}' AS int[])";
    $sql = "INSERT INTO user_favorite (id, favorite_eventid) VALUES (:uuid, {$event_append}) ON CONFLICT (id) DO UPDATE SET favorite_eventid = array_append(user_favorite.favorite_eventid, :eventId) WHERE user_favorite.id = :uuid";
    $stmt = $dbh->prepare($sql);
    if($stmt) {
        $stmt->bindParam(":eventId", $eventId);
        $stmt->bindParam(":uuid", $uuid);
        $stmt->execute();
    }
} else if ($flag == "false") {
    $sql = "UPDATE user_favorite SET favorite_eventid = array_remove(favorite_eventid, :eventId) WHERE id = :uuid";
    $stmt = $dbh->prepare($sql);
    if($stmt) {
        $stmt->bindParam(":eventId", $eventId);
        $stmt->bindParam(":uuid", $uuid);
        $stmt->execute();
    }
}
?>  