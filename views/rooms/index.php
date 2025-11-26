<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление помещениями</title>
    <style>
        /* Стили как в buildings/index.php */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<!-- Header (как в buildings) -->

<div class="main-content">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                🏛️ Управление помещениями
            </h1>
            <a href="<?= app()->route->getUrl('/rooms/add') ?>" class="btn">➕ Добавить помещение</a>
        </div>

        <!-- Статистика -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number"><?= $totalRooms ?? 0 ?></div>
                <div class="stat-label">Всего помещений</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $totalAuditoriums ?? 0 ?></div>
                <div class="stat-label">Аудитория</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $totalSeats ?? 0 ?></div>
                <div class="stat-label">Посадочных мест</div>
            </div>
        </div>

        <!-- Фильтр по зданиям -->
        <form method="get" action="<?= app()->route->getUrl('/rooms') ?>" style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">🏢 Фильтр по зданиям</h3>
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem;">
                <select name="building_id" class="form-control">
                    <option value="">Все здания</option>
                    <?php foreach ($buildings as $building): ?>
                        <option value="<?= $building->id ?>" <?= ($buildingId ?? '') == $building->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($building->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn">Применить</button>
            </div>
        </form>

        <!-- Таблица помещений -->
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Здание</th>
                    <th>Площадь</th>
                    <th>Посадочных мест</th>
                    <th>Вид</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($rooms) && count($rooms) > 0): ?>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?= htmlspecialchars($room->name) ?></td>
                            <td><?= htmlspecialchars($room->building->name ?? 'Не указано') ?></td>
                            <td><?= htmlspecialchars($room->area) ?> м²</td>
                            <td><?= htmlspecialchars($room->seats) ?></td>
                            <td><?= htmlspecialchars($room->type->name ?? 'Не указан') ?></td>
                            <td>
                                <a href="<?= app()->route->getUrl('/rooms/edit/' . $room->id) ?>" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">✏️</a>
                                <form method="post" action="<?= app()->route->getUrl('/rooms/delete/' . $room->id) ?>" style="display: inline;">
                                    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
                                    <button type="submit" class="btn btn-secondary"
                                            style="padding: 0.25rem 0.75rem; font-size: 0.875rem;"
                                            onclick="return confirm('Удалить помещение \"<?= htmlspecialchars($room->name) ?>\"?')">
                                    🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: #666;">
                            Помещений не найдено
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Footer -->
</body>
</html>