<?php
require_once(dirname(__FILE__)."/../IsLoggedIn.php");
$is_logged = new IsLoggedIn();
$dbh = $is_logged->getDbh();
$uuid = $is_logged->getUuid();

if (!empty($_POST["username"])) {
    $sql = "UPDATE users SET username = '{$_POST['username']}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "basic/basic");
    exit();
} else if (!empty($_POST["userid"])) {
    $sql = "UPDATE users SET userid = '{$_POST['userid']}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "basic/basic");
    exit();
} else if (!empty($_POST["password"])) {
    $hashedPassword = password_hash($_POST["password"], \PASSWORD_BCRYPT);
    $sql = "UPDATE users SET password = '{$hashedPassword}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "basic/basic");
    exit();
} else if (!empty($_POST["email"])) {
    $sql = "UPDATE users SET email = '{$_POST['email']}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "basic/basic");
    exit();
} else if (!empty($_POST["lastname"]) && empty($_POST["firstname"])) {
    $sql = "UPDATE userprofile SET lastname = '{$_POST['lastname']}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "personal/personal");
    exit();
} else if (!empty($_POST["firstname"]) && empty($_POST["lastname"])) {
    $sql = "UPDATE userprofile SET firstname = '{$_POST['firstname']}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "personal/personal");
    exit();
} else if (!empty($_POST["firstname"]) && !empty($_POST["lastname"])) {
    $sql = "UPDATE userprofile SET firstname = '{$_POST['firstname']}', lastname = '{$_POST['lastname']}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "personal/personal");
    exit();
} else if (!empty($_POST["postnumber"]) && !empty($_POST["address"])) {
    $sql = "UPDATE userprofile SET postnumber = {$_POST['postnumber']} WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "personal/personal");
    exit();
} else if (!empty($_POST["address"]) && empty($_POST["postnumber"])) {
    $sql = "UPDATE userprofile SET address = '{$_POST['address']}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "personal/personal");
    exit();
} else if (!empty($_POST["address"]) && $_POST["postnumber"]) {
    $sql = "UPDATE userprofile SET address = '{$_POST['address']}', postnumber = {$_POST['postnumber']} WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "personal/personal");
    exit();
} else if (!empty($_POST["phonenumber"])) {
    $sql = "UPDATE userprofile SET phonenumber = '{$_POST["phonenumber"]}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "personal/personal");
    exit();
} else if (!empty($_POST["birthday"])) {
    $sql = "UPDATE userprofile SET birthday = '{$_POST['birthday']}' WHERE id = '{$uuid}'";
    setDb($dbh, $sql, "personal/personal");
    exit();
}

function setDb ($dbh, $sql, $location) {
    $stmt = $dbh->query($sql);
    if($stmt) {
        $stmt->execute();
    }
    header("Location: ". $location);
}
?>