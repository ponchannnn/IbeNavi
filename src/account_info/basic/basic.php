<?php
require_once(dirname(__FILE__)."/../../IsLoggedIn.php");
$is_logged = new IsLoggedIn();
$dbh = $is_logged->getDbh();
$uuid = $is_logged->getUuid();
$stmt = $dbh->prepare("SELECT username, email FROM users WHERE id = :uuid");
if($stmt) {
    $stmt->bindParam(":uuid", $uuid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント情報</title>
    <link rel="stylesheet" href="Account_info.css">
</head>
<body>
    <div>
        <p>イベナビ<!-- 後々ロゴにする --></p>
        <div><button type="button">アカウントロゴ</button></div>
    </div>
<div class="tab">
    <div class="tab-link" data-tab="basic"><a href="../basic/basic" class="tab">基本情報</a></div>
    <div class="tab-link" data-tab="personal"><a href="../personal/personal" class="tab">個人情報</a></div>
    <div class="tab-link" data-tab="security"><a href="../security/security" class="tab">セキュリティとプライバシー設定</a></div>
    <div class="tab-link" data-tab="support"><a href="../support/support" class="tab">サポート</a></div>
    <div class="tab-link" data-tab="others"><a href="../others/others" class="tab">その他</a></div>
</div>

<div id="basic" class="tab-content">
    <h2>基本情報</h2>
    <a href="username">ユーザ名:</a>
    <span>
    <?php if ($row) echo($row["username"]);?>
    </span>
    <br><br>
    <a href="mailaddress">メールアドレス:</a>
    <span>
        <?php if($row) echo($row["email"]); ?>
    </span>
    <br><br>
    <a href="password">パスワード:</a><br><br>
</div>
</body>
</html>
