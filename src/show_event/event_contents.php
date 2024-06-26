<?php
header("Content-type: application/json; charset=UTF-8");
$count = $_POST["count"];
$sort = getSortName($_POST["sort"]);
$q = $_POST["q"];
$countV = strval($count);
$max = 9;

$subbed_url = explode("/", $_SERVER['HTTP_REFERER']);
$original_url = end($subbed_url);

require_once(dirname(__FILE__).'/../IsLoggedIn.php');
$db = new IsLoggedIn();
$dbh = $db->getDbh();

if (!isset($_POST["accountId"])) {
    if ($q == "null") {
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
    $sql = "SELECT eventid, eventname, category, runtime, location, event_status FROM events WHERE ({$ids}) AND event_status = 'active' ORDER BY {$sort}, eventid ASC LIMIT {$max} OFFSET {$countV}";
    } else {    // has searching
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
        $sql = "SELECT eventid, eventname, category, runtime, location, event_status FROM events WHERE eventname LIKE '%{$q}%' AND ({$ids}) AND event_status = 'active' ORDER BY {$sort}, eventid ASC LIMIT {$max} OFFSET {$countV}";
    }
}
else {  // set accountid
    if ($q == "null") {
        $uuid = $db->getUuidFromUserId($_POST["accountId"]);
    if ($original_url == "my_event" && $db->is_logged_in() && $db->getUuid() == $uuid) $sql = "SELECT eventid, eventname, category, runtime, location, event_status FROM events WHERE accountId = '{$uuid}'AND event_status != 'deleted'  ORDER BY {$sort}, eventid ASC LIMIT {$max} OFFSET {$countV}";
    else  $sql = "SELECT eventid, eventname, category, runtime, location, event_status FROM events WHERE accountId = '{$uuid}' AND event_status = 'active' ORDER BY {$sort}, eventid ASC LIMIT {$max} OFFSET {$countV}";
    } else {    // has searching
        $uuid = $db->getUuidFromUserId($_POST["accountId"]);
        if ($original_url == "my_event" && $db->is_logged_in() && $db->getUuid() == $uuid) $sql = "SELECT eventid, eventname, category, runtime, location, event_status FROM events WHERE eventname LIKE '%{$q}%' AND accountId = '{$uuid}'AND event_status != 'deleted'  ORDER BY {$sort}, eventid ASC LIMIT {$max} OFFSET {$countV}";
        else  $sql = "SELECT eventid, eventname, category, runtime, location, event_status FROM events WHERE eventname LIKE '%{$q}%' AND accountId = '{$uuid}' AND event_status = 'active' ORDER BY {$sort}, eventid ASC LIMIT {$max} OFFSET {$countV}";
    }

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
            return "runtime ASC";
            break;
        case "created_date" :
            return "created_at DESC";
            break;
        default :
            return "runtime ASC";
    }
};
?>