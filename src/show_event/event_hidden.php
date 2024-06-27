<?php
header("Content-type: application/json; charset=UTF-8");
require_once(dirname(__FILE__)."/../IsLoggedIn.php");
$logged = new IsLoggedIn();
$dbh = $logged->getDbh();
$uuid = $logged->getUuid();
$eventId = $_POST["eventId"];
$flag = $_POST["flag"];
if ($flag == "true") $sql = "UPDATE events SET event_status = 'hidden' WHERE accountid = :uuid AND eventid = :eventid";
else if ($flag == "false") $sql = "UPDATE events SET event_status = 'active' WHERE accountid = :uuid AND eventid = :eventid";

$stmt = $dbh->prepare($sql);
if($stmt) {
    $stmt->bindParam(":eventid", $eventId);
    $stmt->bindParam(":uuid", $uuid);
    $stmt->execute();
}
?>  