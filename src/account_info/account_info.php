<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント情報</title>
    <link rel="stylesheet" href="account_info.css">
</head>
<body>

<div class="tab">
    <div class="tab-link" data-tab="basic"><a href="basic/basic.php" class="tab">基本情報</a></div>
    <div class="tab-link" data-tab="personal"><a href="personal/personal.php" class="tab">個人情報</a></div>
    <div class="tab-link" data-tab="security"><a href="security/security.php" class="tab">セキュリティとプライバシー設定</a></div>
    <div class="tab-link" data-tab="support"><a href="support/support.html" class="tab">サポート</a></div>
    <div class="tab-link" data-tab="others"><a href="others/others.html" class="tab">その他</a></div>
</div>

<script>
    document.querySelectorAll('.tab-link').forEach(link => {
        link.addEventListener('click', () => {
            document.querySelectorAll('.tab-link').forEach(item => item.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            link.classList.add('active');
            document.getElementById(link.dataset.tab).classList.add('active');
        });
    });
</script>

</body>
</html>
