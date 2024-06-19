<?php
require_once(dirname(__FILE__)."/../IsLoggedIn.php");
$logged = new IsLoggedIn();
if (!$logged->isOrganizer()) {  
    header("Location: /not_organizer_account");
    exit();
};
$dbh = $logged->getDbh();
$uuid= $logged->getUuid();
$subbed_url = explode("/", $_SERVER['HTTP_REFERER']);
$original_url = end($subbed_url);

$eventname = $_POST["eventname"];
$category = $_POST["category"];
$tags = $_POST["tags"];
$runtime = $_POST["runtime"];
$location = $_POST["location"];
$description = $_POST["description"];
$email = $_POST["email"];
$phonenumber = $_POST["phonenumber"];
$imagepass = $_POST["image"];

if ($original_url == "form") {
    $stmt = $dbh->prepare("INSERT INTO events (eventname, category, tags, runtime, location, description, email, phonenumber, imagepass, accountid) VALUES (:eventname, :category, :tags, :runtime, :location, :description, :email, :phonenumber, :imagepass, :uuid)");
    if($stmt) {
        $stmt->bindParam(":eventname", $eventname);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":tags", $tags);
        $stmt->bindParam(":runtime", $runtime);
        $stmt->bindParam(":location", $location);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phonenumber", $phonenumber);
        $stmt->bindParam(":imagepass", $imagepass);
        $stmt->bindParam(":uuid", $uuid);
        $stmt->execute();
    }
} else if ($original_url == "update_event") {
    if (empty($_POST["eventid"])) {
        header("Location: input_event");
        exit();
    }
    $post_eventid = $_POST["eventid"];
    $stmt = $dbh->prepare("SELECT * FROM events WHERE eventid = :eventid");
    if($stmt) {
        $stmt->bindParam(":eventid", $post_eventid);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if ($row["accountid"] != $uuid) {
        header("Location: ../login/login");
        exit();
    }
    $subbed_time = substr($row["runtime"], -3);
    $replace_time = str_replace($subbed_time, "", $row["runtime"]);
    $removedT_runtime = str_replace("T", " ", $runtime);

    $sql = "UPDATE  events SET ";
    if (!(empty($eventname) || $eventname == $row["eventname"])) $sql .= "eventname = '$eventname', ";
    if (!(empty($category) || $category == $row["category"])) $sql .= "category = '$category', ";
    if (!(empty($tags) || $tags == $row["tags"])) $sql .= "tags = $tags, ";
    if (!(empty($runtime) || $removedT_runtime == $replace_time)) $sql .= "runtime = '$runtime', ";
    if (!(empty($location) || $location == $row["location"])) $sql .= "location = '$location', ";
    if (!(empty($description) || $description == $row["description"])) $sql .= "description = '$description', ";
    if (!(empty($email) || $email == $row["email"])) $sql .= "email = '$email', ";
    if (!(empty($phonenumber) || $phonenumber == $row["phonenumber"])) $sql .= "phonenumber = '$phonenumber', ";
    if (!(empty($imagepass) || $imagepass == $row["imagepass"])) $sql .= "imagepass = '$imagepass', ";
    $sql = rtrim($sql, ', ');
    $sql .= " WHERE eventid = $post_eventid";
    $stmt = $dbh->prepare($sql);
    if($stmt) {
        $stmt->execute();
    }

}
header("Location: /show_event/my_event");
exit();
?>