<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма</title>
</head>
<body>
    <h1>Заполните форму</h1>
    <form action="process.php" method="POST">

        <label for="text">ФИО:</label>
        <input type="text" id="text" name="text" required pattern="[А-Яа-яЁё\s]+" title="ФИО должно содержать только буквы и пробелы"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="age">Ваш возраст:</label>
        <input type="number" id="age" name="number" required min="1" max="120" title="Возраст должен быть от 1 до 120"><br><br>

        <label for="select">Страна:</label>
        <select id="select" name="select" required>
            <option value="">Выберите</option>
            <option value="Россия">Россия</option>
            <option value="Белоруссия">Белоруссия</option>
            <option value="Украина">Украина</option>
            <option value="Казахстан">Казахстан</option>
        </select><br><br>

        <label>Выберите пол:</label>
        <input type="radio" id="radio1" name="radio" value="Female" required>
        <label for="radio1">Женский</label>
        <input type="radio" id="radio2" name="radio" value="Male">
        <label for="radio2">Мужской</label><br><br>

        <label>Ваша профессия:</label><br>
        <input type="checkbox" id="checkbox1" name="checkbox[]" value="student">
        <label for="checkbox1">студент</label><br>
        <input type="checkbox" id="checkbox2" name="checkbox[]" value="teacher">
        <label for="checkbox2">учитель</label><br>
        <input type="checkbox" id="checkbox3" name="checkbox[]" value="programmer">
        <label for="checkbox3">программист</label><br>
        <input type="checkbox" id="checkbox4" name="checkbox[]" value="economist">
        <label for="checkbox4">экономист</label><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Отправить">
    </form>

    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <ul style='color: red;'>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
</body>
</html>
