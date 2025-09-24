<!DOCTYPE html>
<html>
<head>
    <title>Управление пользователями</title>
</head>
<body>
<h1>Пользователи системы</h1>
<a href="/admin/users/add">Добавить пользователя</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Логин</th>
        <th>Роль</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= htmlspecialchars($user->name) ?></td>
            <td><?= htmlspecialchars($user->login) ?></td>
            <td><?= $user->role === 'admin' ? 'Администратор' : 'Сотрудник' ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/hello">На главную</a>
</body>
</html>