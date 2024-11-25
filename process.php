<?php
session_start();

function validateText($text) {
    return !empty($text) ? htmlspecialchars($text) : "Введите ФИО";
}

function validateEmail($email) {
    if (empty($email)) {
        return "Эмейл не может быть пустым";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Неверный формат эмейла";
    }
    return htmlspecialchars($email);
}

function validateNumber($number) {
    return !empty($number) ? htmlspecialchars($number) : "Введите возраст";
}

function validateSelect($select) {
    return !empty($select) ? htmlspecialchars($select) : "Выберите страну из списка";
}

function validateRadio($radio) {
    return !empty($radio) ? htmlspecialchars($radio) : "Выберите пол";
}

function validateCheckbox($checkbox) {
    if (is_array($checkbox) && !empty($checkbox)) {
        return htmlspecialchars(implode(", ", $checkbox));
    } 
    return "Необходимо выбрать хотя бы одну профессию";
}

function validatePassword($password) {
    return !empty($password) ? htmlspecialchars($password) : "Пароль не может быть пустым";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $data = [];

    $data['FIO'] = validateText($_POST['text']);
    if ($data['FIO'] === "Введите ФИО") $errors[] = $data['FIO'];

    $data['Email'] = validateEmail($_POST['email']);
    if ($data['Email'] === "Эмейл не может быть пустым" || $data['Email'] === "Неверный формат эмейла") $errors[] = $data['Email'];

    $data['Age'] = validateNumber($_POST['number']);
    if ($data['Age'] === "Введите возраст") $errors[] = $data['Age'];

    $data['Country'] = validateSelect($_POST['select']);
    if ($data['Country'] === "Выберите страну из списка") $errors[] = $data['Country'];

    $data['Gender'] = validateRadio($_POST['radio']);
    if ($data['Gender'] === "Выберите пол") $errors[] = $data['Gender'];

    $data['Profession'] = validateCheckbox($_POST['checkbox'] ?? []);
    if ($data['Profession'] === "Необходимо выбрать опцию") $errors[] = $data['Profession'];

    $data['Password'] = validatePassword($_POST['password']);
    if ($data['Password'] === "Пароль не может быть пустым") $errors[] = $data['Password'];

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit();
    } else {
        $data['Timestamp'] = date("Y-m-d H:i:s");
        file_put_contents('log.json', json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);
        echo "<p style='color:green;'>Данные успешно записаны!</p>";
    }
}
?>
