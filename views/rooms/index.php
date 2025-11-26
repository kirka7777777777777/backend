<div class="card">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <h1 style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            🚪 Управление помещениями
        </h1>
        <a href="<?= app()->route->getUrl('/rooms/add') ?>" class="btn">➕ Добавить помещение</a>
    </div>

    <!-- Статистика -->
    <div class="grid-3" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-number">156</div>
            <div class="stat-label">Всего помещений</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">84</div>
            <div class="stat-label">Аудитории</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">2,840</div>
            <div class="stat-label">Посадочных мест</div>
        </div>
    </div>

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
            <tr>
                <td>Аудитория #234</td>
                <td>Главный корпус</td>
                <td>65 м²</td>
                <td>30</td>
                <td>Аудитория</td>
                <td>
                    <button class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">✏️</button>
                    <button class="btn btn-secondary" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">🗑️</button>
                </td>
            </tr>
            <tr>
                <td>Лаборатория #101</td>
                <td>Корпус Б</td>
                <td>45 м²</td>
                <td>20</td>
                <td>Лаборатория</td>
                <td>
                    <button class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">✏️</button>
                    <button class="btn btn-secondary" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">🗑️</button>
                </td>
            </tr>
            <!-- Добавьте больше строк по мере необходимости -->
            </tbody>
        </table>
    </div>
</div>