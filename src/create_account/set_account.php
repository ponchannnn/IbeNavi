<?php
require_once(dirname(__FILE__).'/../GetDB.php');
$dbh = (new GetDB())->getDbh();

$roleid = intval($_POST["account_roles"]);
$username = $_POST["username"];
$userid = $_POST["userid"];
$hashedPassword = password_hash($_POST["password"], \PASSWORD_BCRYPT);
$email = $_POST["email"];
$lastname = $_POST["lastname"];
$firstname = $_POST["firstname"];
$postnumber = $_POST["postnumber"];
$address = $_POST["address"];
$phonenumber = $_POST["phonenumber"];
$birthday = $_POST["birthday"];
$uuid;

$stmt = $dbh->prepare("INSERT INTO users (userid, username, password, email, accountstatus) VALUES (:userid, :username, :password, :email, 'active')");
if ($stmt) {
    $stmt->bindParam(":userid", $userid);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hashedPassword);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
}

$stmt = $dbh->prepare("SELECT id FROM users WHERE userid = :userid");
if ($stmt) {
    $stmt->bindParam(":userid", $userid);
    $stmt->execute();
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    $uuid = $result["id"];
}

$stmt = $dbh->prepare("INSERT INTO userprofile (id, firstname, lastname, dateofbirth, postnumber, address, phonenumber) VALUES (:id, :firstname, :lastname, :dateofbirth, :postnumber, :address, :phonenumber)");
if ($stmt) {
    $stmt->bindParam(":id", $uuid);
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":dateofbirth", $birthday);
    $stmt->bindParam(":postnumber", $postnumber);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":phonenumber", $phonenumber);
    $stmt->execute();
}

$stmt = $dbh->prepare("INSERT INTO userroles (id, roleid) VALUES (:id, :roleid)");
if ($stmt) {
    $stmt->bindParam(":id", $uuid);
    $stmt->bindParam(":roleid", $roleid);
    $stmt->execute();
}

header("Location: /../login/login.html");
?>