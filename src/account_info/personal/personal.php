<?php
require_once(dirname(__FILE__)."/../../IsLoggedIn.php");
$is_logged = new IsLoggedIn();
$dbh = $is_logged->getDbh();
$uuid = $is_logged->getUuid();
$stmt = $dbh->prepare("SELECT firstname, lastname, dateofbirth, postnumber, address, phonenumber FROM userprofile WHERE id = :uuid");
if($stmt) {
    $stmt->bindParam(":uuid", $uuid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);print_r($uuid);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人情報</title>
</head>
<body>
<div class="tab">
    <div class="tab-link" data-tab="basic"><a href="../basic/basic" class="tab">基本情報</a></div>
    <div class="tab-link" data-tab="personal"><a href="../personal/personal" class="tab">個人情報</a></div>
    <div class="tab-link" data-tab="security"><a href="../security/security" class="tab">セキュリティとプライバシー設定</a></div>
    <div class="tab-link" data-tab="support"><a href="../support/support" class="tab">サポート</a></div>
    <div class="tab-link" data-tab="others"><a href="../others/others" class="tab">その他</a></div>
</div>

<div id="personalInfo" class="tab-content">
    <h2>個人情報</h2>
    <a href="name">氏名</a>
    <span>
    <?php if ($row) echo($row["lastname"]);?>
    <?php if ($row) echo($row["firstname"]);?>
    </span>
    <br><br>
    <a href="birthday">生年月日:</a>
    <span>
    <?php if ($row) echo($row["dateofbirth"]);?>
    </span>
    <br><br>
    <a href="address">住所</a>
    <span>
    <?php if ($row) echo($row["postnumber"]);?>
    <?php if ($row) echo($row["address"]);?>
    </span>
    <br><br>
    <a href="phonenumber">電話番号</a>
    <span>
    <?php if ($row) echo($row["phonenumber"]);?>
    </span>
    <br><br>
</div>
</body>
</html>
