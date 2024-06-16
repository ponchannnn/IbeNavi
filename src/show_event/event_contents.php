<?php
header("Content-type: application/json; charset=UTF-8");
$count = $_POST["count"];
$sort = getSortName($_POST["sort"]);
$countV = strval($count);
$max = 5;

require_once(dirname(__FILE__).'/../GetDB.php');
$uuid;
$db = new GetDB();
$dbh = $db->getDbh();

if (!isset($_POST["accountId"])) {
    $sql = "SELECT id FROM users WHERE accountstatus = 'active'";
    $stmt = $dbh->prepare($sql);
    $ids = "";
    if($stmt) {
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $ids .= "accountid = '" . $row["id"] . "' OR ";
        }
        $ids = substr($ids, 0, -4);
    }
    $sql = "SELECT eventid, eventname, category, runtime, location FROM events WHERE ({$ids}) AND event_status = 'active' ORDER BY {$sort}, eventid ASC LIMIT {$max} OFFSET {$countV}";
}
else {
    $uuid = $db->getUuidFromUserId($_POST["accountId"]);
    $sql = "SELECT eventid, eventname, category, runtime, location FROM events WHERE accountId = '{$uuid}' AND event_status = 'active' ORDER BY {$sort}, eventid ASC LIMIT {$max} OFFSET {$countV}";
}
$stmt = $dbh->prepare($sql);
if($stmt) {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
array_push($rows, ["count" => $countV]);
echo json_encode($rows);

function getSortName ($sort) {
    switch ($sort) {
        case "run_date" :
            return "runtime DESC";
            break;
        case "created_date" :
            return "created_at DESC";
            break;
        default :
            return "runtime DESC";
    }
};
?>