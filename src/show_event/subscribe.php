<?php
if (!isset($_GET["id"])) exit(); //dfgsgf
$sub_userid = $_GET["id"];
require_once(dirname(__FILE__).'/../IsLoggedIn.php');
$db = new IsLoggedIn();
$uuid = $db->getUuid();
$dbh = $db->getDbh();
$sub_id = $db->getUuidFromUserid($sub_userid);

$stmt = $dbh->prepare("SELECT EXISTS (SELECT * FROM user_subscriber WHERE id = :id)");
if($stmt) {
    $stmt->bindParam(":id", $uuid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row["exists"] == true) {   // true
        $stmt = $dbh->prepare("UPDATE user_subscriber SET subscribe_uuid=:sub_id WHERE id = :id");
        $stmt->bindParam(":id", $uuid);
        $subid_append = "array_append(subscribe_uuid, '" . $sub_id . "')";
        $stmt->bindParam(":sub_id", $subid_append);
        if($stmt) {
            $row = $stmt->execute();
        }
    } else {   // false
        $stmt = $dbh->prepare("INSERT INTO user_subscriber (id, subscribe_uuid) VALUES (:id, :sub_id)");
        $stmt->bindParam(":id", $uuid);
        $subid_append = "CAST({'" . $sub_id . "'} AS UUID[])";
        $stmt->bindParam(":sub_id", $subid_append);
        if($stmt) {
            $row = $stmt->execute();
        }
    }
}
header("Location /show_event/channel_event?$sub_userid")// sdfsfasdfafd
?>