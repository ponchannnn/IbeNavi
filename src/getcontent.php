<?php
require_once(dirname(__FILE__).'/GetDB.php');
$uuid;
$db = new GetDB();
$dbh = $db->getDbh();
$data = "";

$sql = "SELECT * FROM events";
$stmt = $dbh->prepare($sql);
if($stmt) {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data .= "INSERT INTO events (category, tags, runtime, location, description, email, phonenumber, accountid, eventid, eventname, created_at, event_status) VALUES ";
    foreach ($rows as $row) {
        $data .= "( '" . $row["category"] . "', '" . $row["tags"] . "', '" . $row["runtime"] . "', '" . $row["location"]. "', '" . $row["description"] . "', '" . $row["email"] . "', '" . $row["phonenumber"] . "', '" . $row["accountid"] . "', '" . $row["eventid"] . "', '" . $row["eventname"] . "', '" . $row["created_at"] . "', '" . $row["event_status"] . "'), ";
    };
    $data = substr($data, 0, -2);
    $data .= ";";
};

$sql = "SELECT * FROM users";
$stmt = $dbh->prepare($sql);
if($stmt) {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data .= "INSERT INTO users (id, userid, username, password, email, registrationdate, accountstatus) VALUES ";
    foreach ($rows as $row) {
        $data .= "( '" . $row["id"] . "', '" . $row["userid"] . "', '" . $row["username"] . "', '" . $row["password"]. "', '" . $row["email"] . "', '" . $row["registrationdate"] . "', '" . $row["accountstatus"] . "'), ";
    };
    $data = substr($data, 0, -2);
    $data .= ";";
};

$sql = "SELECT * FROM userprofile";
$stmt = $dbh->prepare($sql);
if($stmt) {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data .= "INSERT INTO userprofile (id, firstname, lastname, dateofbirth, postnumber, address, phonenumber) VALUES ";
    foreach ($rows as $row) {
        $data .= "( '" . $row["id"] . "', '" . $row["firstname"] . "', '" . $row["lastname"] . "', '" . $row["dateofbirth"]. "', '" . $row["postnumber"] . "', '" . $row["address"] . "', '" . $row["phonenumber"] . "'), ";
    };
    $data = substr($data, 0, -2);
    $data .= ";";
};

$sql = "SELECT * FROM userroles";
$stmt = $dbh->prepare($sql);
if($stmt) {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data .= "INSERT INTO userroles (id, roleid) VALUES ";
    foreach ($rows as $row) {
        $data .= "( '" . $row["id"] . "', '" . $row["roleid"] . "'), ";
    };
    $data = substr($data, 0, -2);
    $data .= ";";
};

echo $data;
?>