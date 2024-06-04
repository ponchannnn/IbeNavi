<?php
if (!isset($_GET["id"])) exit(); //dfgsgf
$account_userid = $_GET["id"];
require_once(dirname(__FILE__).'/IsLoggedIn.php');
$db = new IsLoggedIn();
$uuid = $db->getUuid();
$dbh = $db->getDbh();
$sub_userid = $db->getUuidFromUserid($account_userid);

$stmt = $dbh->prepare("SELECT EXISTS (SELECT * FROM user_subscriber WHERE id = :id)");
if($stmt) {
    $stmt->bindParam(":id", $uuid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($rpw)) {
        $stmt = $dbh->prepare("INSERT INTO");

    }
}
// header("Location /show_event/channel_event?")// sdfsfasdfafd
?>