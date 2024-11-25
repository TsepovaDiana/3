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
        <input type="text" id="text" name="text" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="number">Ваш возраст:</label>
        <input type="number" id="number" name="number" required><br><br>

        <label for="select">Страна:</label>
        <select id="select" name="select" required>
            <option value="">Выберите</option>
            <option value="option1">Россия</option>
            <option value="option2">Белоруссия</option>
            <option value="option3">Украина</option>
            <option value="option4">Казахстан</option>
        </select><br><br>

        <label>Выберите пол:</label>
        <input type="radio" id="radio1" name="radio" value="option1" required>
        <label for="radio1">Женский</label>
        <input type="radio" id="radio2" name="radio" value="option2">
        <label for="radio2">Мужской</label><br><br>

        <label>Ваша профессия:</label><br>
        <input type="checkbox" id="checkbox1" name="checkbox[]" value="1">
        <label for="checkbox1">студент</label><br>
        <input type="checkbox" id="checkbox2" name="checkbox[]" value="2">
        <label for="checkbox2">учитель</label><br>
        <input type="checkbox" id="checkbox3" name="checkbox[]" value="3">
        <label for="checkbox3">программист</label><br>
        <input type="checkbox" id="checkbox4" name="checkbox[]" value="4">
        <label for="checkbox4">экономист</label><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Отправить">
    </form>

    <?php
    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
        echo "<ul style='color: red;'>";
        foreach ($_SESSION['errors'] as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        unset($_SESSION['errors']);
    }
    ?>
</body>
</html>
