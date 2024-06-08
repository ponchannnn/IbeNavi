<?php
isset($_GET["eventid"])? $eventid = $_GET["eventid"] : header("Location: ".dirname(__FILE__)."event_nothing.html");
require_once(dirname(__FILE__).'/../GetDB.php');
$db = new GetDB();
$dbh = $db->getDbh();
$stmt = $dbh->prepare("SELECT * FROM events WHERE eventid = :eventid");
if($stmt) {
    $stmt->bindParam(":eventid", $eventid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $eventname = $row["eventname"];
        $category = $row["category"];
        $tags = $row["tags"];
        $datetime = $row["runtime"];
        $location = $row["location"];
        $description = $row["description"];
        $email = $row["email"];
        $phone = $row["phonenumber"];
        $accountid = $row["accountid"];
    }
}
$account_userid = $db->getUserIdFromUuid($accountid);
$stmt = $dbh->prepare("SELECT username FROM users WHERE id = :accountid");
if($stmt) {
    $stmt->bindParam(":accountid", $accountid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $username = $row["username"];
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベント情報</title>
</head>
<body>
<?php include("../header/header.php"); ?><div class="container"></div>
<div class="event-container">
    <div class="event-header">
        <div>
            <h2><?php echo $eventname; ?></h2>
            <p>カテゴリ: <span id="category"><?php echo($category); ?></span></p>
            <p>タグ: <span id="tags"><?php echo($tags); ?></span></p>
        </div>
    </div>
    
    <div class="event-details">
        <p>日時: <span id="date-time"><?php echo($datetime); ?></span></p>
        <p>場所: <span id="location"><?php echo($location); ?></span></p>
        <p><a href="/show_event/channel_event?channel_id=<?php echo($account_userid); ?>">投稿者: <span id="subscriber"><?php echo($username); ?></span></a>
            <form action="/subscribe" method="get">
                <input type="hidden" name="id" value=<?php echo($account_userid); ?>>
                <input type="submit" value="登録">
            </form>
        </p>
        <p>概要: <span id="description"><?php echo($description); ?></span></p>
    </div>
    
    <div class="map">
        <h3>地図</h3>
        <div id="map">
            <iframe 
                src="http://maps.google.co.jp/maps?q=<?php echo($location); ?>&output=embed&t=m&z=16&hl=ja"
                width="100%" 
                height="300" 
                frameborder="0" 
                style="border:0;" 
                allowfullscreen="" 
                aria-hidden="false" 
                tabindex="0">
            </iframe>
        </div>
    </div>
    
    <div class="contact">
        <h3>連絡先</h3>
        <p>メール: <a href="mailto:<?php $email; ?>"><?php echo $email; ?></a></p>
        <p>電話: <a href="tel:+81<?php echo str_replace('-', '', $phone); ?>"><?php echo $phone; ?></a></p>
    </div>
</div>

</body>
</html>
