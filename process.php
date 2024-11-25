<?php
session_start();

function validateText($text): string {
    if (empty($text)) {
        return "Введите ФИО";
    }
    if (!preg_match("/^[А-Яа-яЁё\s]+$/u", $text)) {
        return "ФИО должно содержать только буквы и пробелы";
    }
    return htmlspecialchars($text);
}

function validateEmail($email): string {
    if (empty($email)) {
        return "Эмейл не может быть пустым";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Неверный формат эмейла";
    }
    return htmlspecialchars($email);
}

function validateNumber($number): string {
    if (empty($number) || $number < 1 || $number > 120) {
        return "Возраст должен быть от 1 до 120";
    }
    return htmlspecialchars($number);
}

function validateSelect($select): string {
    if (empty($select)) {
        return "Выберите страну из списка";
    }
    return htmlspecialchars($select);
}

function validateRadio($radio): string {
    if (empty($radio)) {
        return "Выберите пол";
    }
    return htmlspecialchars($radio);
}

function validateCheckbox($checkbox): string {
    if (!is_array($checkbox) || empty($checkbox)) {
        return "Необходимо выбрать хотя бы одну профессию";
    } 
    return htmlspecialchars(implode(", ", $checkbox));
}

function validatePassword($password): string {
    if (empty($password)) {
        return "Пароль не может быть пустым";
    }
    if (strlen($password) < 6) {
        return "Пароль должен содержать минимум 6 символов";
    }
    return htmlspecialchars($password);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];
    $data = [];

    $validators = [
        'FIO' => 'validateText',
        'Email' => 'validateEmail',
        'Age' => 'validateNumber',
        'Country' => 'validateSelect',
        'Gender' => 'validateRadio',
        'Profession' => 'validateCheckbox',
        'Password' => 'validatePassword'
    ];

    $postKeys = [
        'text' => 'FIO', 
        'email' => 'Email', 
        'number' => 'Age', 
        'select' => 'Country', 
        'radio' => 'Gender', 
        'checkbox' => 'Profession', 
        'password' => 'Password'
    ];

    foreach ($postKeys as $key => $dataKey) {
        $data[$dataKey] = isset($_POST[$key]) ? $validators[$dataKey]($_POST[$key]) : null;

        if (strpos($data[$dataKey], "не может быть пустым") !== false || strpos($data[$dataKey], "должен") !== false) {
            $errors[] = $data[$dataKey];
        }
    }

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
