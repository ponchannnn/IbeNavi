<?php
if (!isset($_GET["channel_id"])) {
    header("Location: /show_event/show_event");
    exit();
}
$channel_id = $_GET["channel_id"];
require_once(dirname(__FILE__).'/../IsLoggedIn.php');
$uuid;
$logged = new IsLoggedIn();
$dbh = $logged->getDbh();
$event_num = 0;
$eventAuthorUuid = $logged->getUuidFromUserId($channel_id);
$stmt = $dbh->prepare("SELECT eventid, eventname, category, runtime, location FROM events WHERE accountid = :id ORDER BY created_at DESC LIMIT 5 OFFSET 0");
if($stmt) {
    $stmt->bindParam(":id", $eventAuthorUuid);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$username = $logged->getUsernameFromUserId($channel_id);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $username ?>のイベント</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <?php include("../header/header.php"); ?><div class="container"></div>
    <div class="container">
        <div class="title-container">
            <h1><?php echo $username ?>のイベント</h1>
            <?php if($logged->is_logged_in()) echo "<button><a href='/show_event/subscribe?id={$channel_id}'>チャンネル登録</a></button>" ?>
        </div>
        <div class="search-container">
            <form action="" method="GET">
                <input type="text" placeholder="キーワードを入力">
                <input type="submit" value="検索">
            </form>
            <div class="sort-container">
                <label for="sort">ソート：</label>
                <select name="sort" id="sort">
                <option value="run_date">開催日時</option>
                <option value="created_date">作成日時</option>
                    <!-- 他のソートオプションを追加 -->
                </select>
            </div>
        </div>
        <div class="event-container">
            <!-- 無限スクロールで読み込む -->
            <!-- jQuery読み込み -->
            <script>const q = "<?php if(!empty($_GET["q"])) echo $_GET["q"]; else echo "null"; ?>";</script>
            <script type="text/javascript">accountId = "<?php echo $channel_id; ?>"</script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript" src="infScroll.js"></script>
            <div id="infinite-content"></div>
                <!-- 追加ここまで -->
            <input type="hidden" id="count" value=<?php echo $event_num ?>>
            <div id ="loading"></div>
        </div>
    </div>
</body>
</html>