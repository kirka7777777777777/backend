<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление помещениями</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-main {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-main a {
            color: #333;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-main a:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px);
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #667eea;
        }

        /* Main Content */
        main {
            padding: 2rem 0;
            min-height: calc(100vh - 140px);
        }

        /* Card Styles */
        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        /* Grid Layout */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        /* Button Styles */
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .btn-block {
            width: 100%;
        }

        /* Form Styles */
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .data-table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #e1e5e9;
        }

        .data-table tr:hover {
            background-color: #f8f9fa;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }

        .alert-error {
            background-color: #fee;
            border-color: #fcc;
            color: #c33;
        }

        .alert-success {
            background-color: #efe;
            border-color: #cfc;
            color: #363;
        }

        /* Stats Cards */
        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: rgba(255, 255, 255, 0.9);
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }

            .nav-main {
                flex-direction: column;
                gap: 0.5rem;
            }

            nav {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <nav>
            <div class="logo">🏢 Управление помещениями</div>
            <ul class="nav-main">
                <li><a href="<?= app()->route->getUrl('/') ?>">Главная</a></li>
                <li><a href="<?= app()->route->getUrl('/buildings') ?>">Здания</a></li>
                <li><a href="<?= app()->route->getUrl('/rooms') ?>">Помещения</a></li>
                <?php if (app()->auth::check() && app()->auth::user()->role === 'admin'): ?>
                    <li><a href="<?= app()->route->getUrl('/admin/users') ?>">Пользователи</a></li>
                <?php endif; ?>
            </ul>
            <div class="nav-auth">
                <?php if (!app()->auth::check()): ?>
                    <a href="<?= app()->route->getUrl('/login') ?>" class="btn">Войти</a>
                    <a href="<?= app()->route->getUrl('/signup') ?>" class="btn btn-secondary">Регистрация</a>
                <?php else: ?>
                    <div class="user-info">
                        <?php if (!empty(app()->auth::user()->avatar)): ?>
                            <img src="/uploads/avatars/<?= app()->auth::user()->avatar ?>"
                                 alt="Аватар" class="avatar">
                        <?php endif; ?>
                        <span><?= app()->auth::user()->name ?></span>
                        <a href="<?= app()->route->getUrl('/logout') ?>" class="btn btn-secondary">Выйти</a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <?= $content ?? '' ?>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; 2024 Система управления помещениями. Все права защищены.</p>
    </div>
</footer>
</body>
</html>