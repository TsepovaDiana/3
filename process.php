<?php
session_start();

function validateText($text) {
    if (empty($text)) {
        return "Введите ФИО";
    }
    if (!preg_match("/^[А-Яа-яЁё\s]+$/u", $text)) {
        return "ФИО должно содержать только буквы и пробелы";
    }
    return htmlspecialchars($text);
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
    if (empty($number)) {
        return "Введите возраст";
    } elseif (!is_numeric($number) || $number < 1 || $number > 120) {
        return "Возраст должен быть от 1 до 120";
    }
    return htmlspecialchars($number);
}

function validateSelect($select) {
    if (empty($select)) {
        return "Выберите страну из списка";
    }
    return htmlspecialchars($select);
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
    if (empty($password)) {
        return "Пароль не может быть пустым";
    }
    if (strlen($password) < 6) {
        return "Пароль должен содержать минимум 6 символов";
    }
    return htmlspecialchars($password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $data = [];

    $data['FIO'] = validateText($_POST['text']);
    if ($data['FIO'] === "Введите ФИО" || strpos($data['FIO'], "ФИО") !== false) $errors[] = $data['FIO'];

    $data['Email'] = validateEmail($_POST['email']);
    if ($data['Email'] === "Эмейл не может быть пустым" || $data['Email'] === "Неверный формат эмейла") $errors[] = $data['Email'];

    $data['Age'] = validateNumber($_POST['number']);
    if ($data['Age'] === "Введите возраст" || strpos($data['Age'], "Возраст") !== false) $errors[] = $data['Age'];

    $data['Country'] = validateSelect($_POST['select']);
    if ($data['Country'] === "Выберите страну из списка") $errors[] = $data['Country'];

    $data['Gender'] = validateRadio($_POST['radio']);
    if ($data['Gender'] === "Выберите пол") $errors[] = $data['Gender'];

    $data['Profession'] = validateCheckbox($_POST['checkbox'] ?? []);
    if ($data['Profession'] === "Необходимо выбрать хотя бы одну профессию") $errors[] = $data['Profession'];

    $data['Password'] = validatePassword($_POST['password']);
    if ($data['Password'] === "Пароль не может быть пустым" || strpos($data['Password'], "Пароль") !== false) $errors[] = $data['Password'];

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit();
    } else {
        $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
        $data['Timestamp'] = date("Y-m-d H:i:s");
        file_put_contents('log.json', json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);
        echo "<p style='color:green;'>Данные успешно записаны!</p>";
    }
}
?>
