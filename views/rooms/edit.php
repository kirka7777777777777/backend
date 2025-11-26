<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать помещение - Система управления помещениями</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            text-decoration: none;
        }

        .nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav a {
            color: #555;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav a:hover {
            background: #667eea;
            color: white;
        }

        .nav a.active {
            background: #667eea;
            color: white;
        }

        .user-menu {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .form-body {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e8ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e8ecef;
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            border-color: #dee2e6;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .error-message p {
            margin: 0.25rem 0;
        }

        .room-info {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .room-info p {
            color: #0369a1;
            font-size: 0.9rem;
            margin: 0.25rem 0;
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .nav {
                gap: 1rem;
            }

            .form-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
<main class="main-content">
    <div class="form-container">
        <div class="form-header">
            <h1>✏️ Редактировать помещение</h1>
            <p>Обновите информацию о помещении</p>
        </div>

        <div class="form-body">
            <?php if (isset($message) && !empty($message)): ?>
                <div class="error-message">
                    <?php
                    $errors = json_decode($message, true);
                    if (is_array($errors)) {
                        foreach ($errors as $field => $errorMessages) {
                            foreach ($errorMessages as $error) {
                                echo "<p>• $error</p>";
                            }
                        }
                    } else {
                        echo "<p>• $message</p>";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($room) && $room): ?>
                <div class="room-info">
                    <p><strong>ID помещения:</strong> #<?= $room->id ?></p>
                    <p><strong>Здание:</strong> <?= htmlspecialchars($room->building->name ?? 'Не указано') ?></p>
                    <p><strong>Тип:</strong> <?= htmlspecialchars($room->type->name ?? 'Не указан') ?></p>
                </div>

                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

                    <div class="form-group">
                        <label class="form-label">🏷️ Название помещения</label>
                        <input type="text" name="name" class="form-input" required
                               placeholder="Введите название помещения"
                               value="<?= htmlspecialchars($room->name) ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">🏢 Здание</label>
                        <select name="building_id" class="form-select" required>
                            <option value="">Выберите здание</option>
                            <?php foreach ($buildings as $building): ?>
                                <option value="<?= $building->id ?>" <?= $room->building_id == $building->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($building->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">📝 Тип помещения</label>
                        <select name="type_id" class="form-select" required>
                            <option value="">Выберите тип помещения</option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?= $type->id ?>" <?= $room->type_id == $type->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($type->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">📐 Площадь (м²)</label>
                        <input type="number" name="area" class="form-input" required
                               placeholder="Введите площадь помещения"
                               value="<?= htmlspecialchars($room->area) ?>"
                               step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">💺 Посадочных мест</label>
                        <input type="number" name="seats" class="form-input" required
                               placeholder="Введите количество посадочных мест"
                               value="<?= htmlspecialchars($room->seats) ?>"
                               min="0">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        💾 Сохранить изменения
                    </button>

                    <a href="<?= app()->route->getUrl('/rooms') ?>" class="btn btn-secondary">
                        ↩️ Отмена
                    </a>
                </form>
            <?php else: ?>
                <div class="error-message">
                    <p>❌ Помещение не найдено</p>
                </div>
                <a href="<?= app()->route->getUrl('/rooms') ?>" class="btn btn-primary">
                    📋 Вернуться к списку помещений
                </a>
            <?php endif; ?>
        </div>
    </div>
</main>
</body>
</html>