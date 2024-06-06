<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント情報</title>
    <link rel="stylesheet" href="../account_info.css">
</head>
<body>
<?php include("../../header/header.php"); ?><div class="container"></div>
    <div class="tab">
        <div class="tab-link" data-tab="basic"><a href="../basic/basic" class="tab">基本情報</a></div>
        <div class="tab-link" data-tab="personal"><a href="../personal/personal" class="tab">個人情報</a></div>
        <div class="tab-link" data-tab="security"><a href="../security/security" class="tab">セキュリティとプライバシー設定</a></div>
        <div class="tab-link" data-tab="support"><a href="../support/support" class="tab">サポート</a></div>
        <div class="tab-link" data-tab="others"><a href="../others/others" class="tab">その他</a></div>
    </div>

<div id="basic" class="tab-content">
    <h2>その他</h2>
    <a href="confirm_delete_account">アカウント削除</a><br><br>
</div>
</body>
</html>
