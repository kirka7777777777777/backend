<!DOCTYPE html>
<html>
<head>
    <title>Помещения</title>
</head>
<body>
<h1>Список помещений</h1>
<?php if (app()->auth::user()->isAdmin() || app()->auth::user()->isEmployee()): ?>
    <a href="/rooms/add">Добавить помещение</a>
<?php endif; ?>

<form method="GET" action="/rooms">
    <label>Фильтр по зданию:
        <select name="building_id">
            <option value="">Все здания</option>
            <?php foreach ($buildings as $building): ?>
                <option value="<?= $building->id ?>" <?= isset($_GET['building_id']) && $_GET['building_id'] == $building->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($building->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Применить</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Здание</th>
        <th>Тип</th>
        <th>Площадь</th>
        <th>Посадочных мест</th>
    </tr>
    <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?= $room->id ?></td>
            <td><?= htmlspecialchars($room->name) ?></td>
            <td><?= htmlspecialchars($room->building->name) ?></td>
            <td><?= htmlspecialchars($room->type->name) ?></td>
            <td><?= $room->area ?> м²</td>
            <td><?= $room->seats ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/rooms/stats">Статистика</a>
<a href="/hello">На главную</a>
</body>
</html>