<?php
header("Content-type: application/json; charset=UTF-8");
$count = $_POST["count"];
$countV = strval($count);
$max = 5;

require_once(dirname(__FILE__).'/../GetDB.php');
$uuid;
$db = new GetDB();
$dbh = $db->getDbh();
if (!isset($_POST["accountId"])) $sql = "SELECT eventid, eventname, category, runtime, location FROM events ORDER BY created_at DESC, eventid ASC LIMIT {$max} OFFSET {$countV}";
else {
    $uuid = $db->getUuidFromUserId($_POST["accountId"]);
    $sql = "SELECT eventid, eventname, category, runtime, location FROM events WHERE accountId = '{$uuid}' ORDER BY created_at DESC, eventid ASC LIMIT {$max} OFFSET {$countV}";
}
$stmt = $dbh->prepare($sql);
if($stmt) {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
array_push($rows, ["count" => $countV]);
echo json_encode($rows);
?>