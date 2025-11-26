<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            🏛️ Управление зданиями
        </h1>
        <a href="<?= app()->route->getUrl('/buildings/add') ?>" class="btn">➕ Добавить здание</a>
    </div>

    <form method="post" action="<?= app()->route->getUrl('/buildings') ?>" style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
        <h3 style="margin-bottom: 1rem;">🔍 Поиск зданий</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem;">
            <input type="text" name="name" class="form-control" placeholder="Название здания..."
                   value="<?= htmlspecialchars($search_params['name'] ?? '') ?>">
            <input type="text" name="address" class="form-control" placeholder="Адрес..."
                   value="<?= htmlspecialchars($search_params['address'] ?? '') ?>">
            <button type="submit" class="btn">Найти</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Адрес</th>
                <th>Кол-во помещений</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($buildings) && count($buildings) > 0): ?>
                <?php foreach ($buildings as $building): ?>
                    <tr>
                        <td><?= htmlspecialchars($building->name) ?></td>
                        <td><?= htmlspecialchars($building->address) ?></td>
                        <td>
                            <?= $building->room_count ?>
                        </td>
                        <td>
                            <a href="<?= app()->route->getUrl('/buildings/edit/' . $building->id) ?>" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">✏️</a>
                            <form method="post" action="<?= app()->route->getUrl('/buildings/delete/' . $building->id) ?>" style="display: inline;">
                                <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
                                <button type="submit" class="btn btn-secondary"
                                        style="padding: 0.25rem 0.75rem; font-size: 0.875rem;"
                                        onclick="return confirm('Удалить здание \"<?= htmlspecialchars($building->name) ?>\"?')">
                                🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem; color: #666;">
                        Зданий не найдено
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>