<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма</title>
</head>
<body>
    <h1>Заполните форму</h1>
    <form action="" method="POST">
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
        <input type="checkbox" id="checkbox" name="checkbox" value="1">
        <label for="checkbox">студент</label><br><br>
        <input type="checkbox" id="checkbox" name="checkbox" value="2">
        <label for="checkbox">учитель</label><br><br>
        <input type="checkbox" id="checkbox" name="checkbox" value="3">
        <label for="checkbox">программист</label><br><br>
        <input type="checkbox" id="checkbox" name="checkbox" value="4">
        <label for="checkbox">экономист</label><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Отправить">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $data = [];

    if (empty($_POST['text'])) {
        $errors['text'] = "Введите ФИО";
    } else {
        $data['text'] = htmlspecialchars($_POST['text']);
    }

    if (empty($_POST['email'])) {
        $errors['email'] = "Эмейл не может быть пустым";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Неверный формат эмейла";
    } else {
        $data['email'] = htmlspecialchars($_POST['email']);
    }

    if (empty($_POST['number'])) 
    {
        $errors['number'] = "Введите возраст";
    } 
    else 
    {
        $data['number'] = htmlspecialchars($_POST['number']);
    }

    if (empty($_POST['select'])) 
    {
        $errors['select'] = "Выберите страну из списка";
    } 
    else 
    {
        $data['select'] = htmlspecialchars($_POST['select']);
    }

    if (empty($_POST['radio'])) 
    {
        $errors['radio'] = "Выберите пол";
    } 
    else 
    {
        $data['radio'] = htmlspecialchars($_POST['radio']);
    }


    $data['checkbox'] = isset($_POST['checkbox']) ? 1 : 0;

    if (empty($_POST['password'])) 
    {
        $errors['password'] = "Пароль не может быть пустым";
    } 
    else 
    {
        $data['password'] = htmlspecialchars($_POST['password']);
    }

    if ($errors) 
    {
        foreach ($errors as $error) 
        {
            echo "<p style='color:red;'>$error</p>";
        }
    } 
    
    else 
    {
        $data['timestamp'] = date("Y-m-d H:i:s");
        file_put_contents('log.json', json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);
        echo "<p style='color:green;'>Данные успешно записаны!</p>";
    }
}
?>
