<!DOCTYPE html>
<html>
<head>
    <title>Hello Page</title>
</head>
<body>
<h1>Hello, <?= app()->auth::user()->name ?>!</h1>

<?php
// Получим базовый путь приложения
$basePath = app()->settings->getRootPath();
?>

<?php if (!empty($avatar)): ?>
    <div>
        <h2>Your Avatar:</h2>
        <img src="<?= $basePath ?>/uploads/<?= $avatar ?>" alt="User Avatar" style="max-width: 200px; border-radius: 50%;">
    </div>
<?php else: ?>
    <p>No avatar uploaded yet.</p>
<?php endif; ?>

<a href="<?= $basePath ?>/logout">logout </a>
</body>
</html>