<div class="form-container">
    <div class="card">
        <h2 style="text-align: center; margin-bottom: 0.5rem; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            🔐 Авторизация
        </h2>
        <p style="text-align: center; color: #666; margin-bottom: 2rem;">Войдите в систему управления</p>

        <?php if (isset($message) && !empty($message)): ?>
            <div class="alert alert-error">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <?php if (!app()->auth::check()): ?>
            <form method="post">
                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>">

                <div class="form-group">
                    <label for="login">👤 Логин:</label>
                    <input type="text" id="login" name="login" class="form-control" required
                           placeholder="Введите ваш логин"
                           value="<?= $_POST['login'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="password">🔒 Пароль:</label>
                    <input type="password" id="password" name="password" class="form-control" required
                           placeholder="Введите ваш пароль">
                </div>

                <button type="submit" class="btn btn-block">🚀 Войти</button>
            </form>

            <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e1e5e9;">
                <p style="color: #666;">Нет аккаунта?
                    <a href="<?= app()->route->getUrl('/signup') ?>"
                       style="color: #667eea; text-decoration: none; font-weight: 600;">Зарегистрируйтесь!</a>
                </p>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">✅</div>
                <h3 style="color: #363; margin-bottom: 1rem;">Вы уже авторизованы!</h3>
                <p>Добро пожаловать, <strong><?= app()->auth::user()->name ?></strong>!</p>
                <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                    <a href="<?= app()->route->getUrl('/') ?>" class="btn">📊 На главную</a>
                    <a href="<?= app()->route->getUrl('/logout') ?>" class="btn btn-secondary">🚪 Выйти</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>