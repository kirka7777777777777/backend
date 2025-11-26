<div class="card">
    <h1 style="text-align: center; margin-bottom: 0.5rem; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        🏢 Система управления помещениями
    </h1>
    <p style="text-align: center; color: #666; margin-bottom: 2rem;">
        Современная система для учета и управления зданиями и помещениями
    </p>

    <?php if (!app()->auth::check()): ?>
        <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #f8f9ff, #f0f2ff); border-radius: 10px;">
            <h3 style="margin-bottom: 1rem;">Добро пожаловать!</h3>
            <p style="margin-bottom: 2rem; color: #666;">Для доступа к системе требуется авторизация</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="<?= app()->route->getUrl('/login') ?>" class="btn" style="min-width: 150px;">Войти в систему</a>
                <a href="<?= app()->route->getUrl('/signup') ?>" class="btn btn-secondary" style="min-width: 150px;">Зарегистрироваться</a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid-3" style="margin-bottom: 2rem;">
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Зданий</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">156</div>
                <div class="stat-label">Помещений</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">2,840</div>
                <div class="stat-label">Посадочных мест</div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <h3 style="margin-bottom: 1rem;">📊 Быстрые действия</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <a href="<?= app()->route->getUrl('/buildings/add') ?>" class="btn btn-block">➕ Добавить здание</a>
                    <a href="<?= app()->route->getUrl('/rooms/add') ?>" class="btn btn-block">➕ Добавить помещение</a>
                    <a href="<?= app()->route->getUrl('/reports') ?>" class="btn btn-block">📈 Смотреть отчеты</a>
                </div>
            </div>

            <div class="card">
                <h3 style="margin-bottom: 1rem;">📋 Последние помещения</h3>
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                    <p style="color: #666; text-align: center;">Здесь будут отображаться последние добавленные помещения</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="grid-3">
    <div class="card">
        <h3 style="margin-bottom: 1rem;">🏛️ Управление зданиями</h3>
        <p>Добавляйте, редактируйте и просматривайте информацию о зданиях учебного заведения.</p>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 1rem;">🚪 Учет помещений</h3>
        <p>Ведите подробный учет всех помещений с указанием площади, типа и количества мест.</p>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 1rem;">📊 Аналитика и отчеты</h3>
        <p>Получайте подробные отчеты по площадям, загрузке и другим метрикам.</p>
    </div>
</div>