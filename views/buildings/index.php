<!DOCTYPE html>
<html>
<head>
    <title>Здания</title>
</head>
<body>
<h1>Список зданий</h1>
<?php if (app()->auth::user()->isAdmin() || app()->auth::user()->isEmployee()): ?>
    <a href="/buildings/add">Добавить здание</a>
<?php endif; ?>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Адрес</th>
        <th>Количество помещений</th>
    </tr>
    <?php foreach ($buildings as $building): ?>
        <tr>
            <td><?= $building->id ?></td>
            <td><?= htmlspecialchars($building->name) ?></td>
            <td><?= htmlspecialchars($building->address) ?></td>
            <td><?= count($building->rooms) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/hello">На главную</a>
</body>
</html>