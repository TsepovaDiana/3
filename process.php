<?php
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
    return "Необходимо выбрать опцию";
}

function validatePassword($password) {
    return !empty($password) ? htmlspecialchars($password) : "Пароль не может быть пустым";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $data = [];

    $data['text'] = validateText($_POST['text']);
    if ($data['text'] === "Введите ФИО") $errors[] = $data['text'];

    $data['email'] = validateEmail($_POST['email']);
    if ($data['email'] === "Эмейл не может быть пустым" || $data['email'] === "Неверный формат эмейла") $errors[] = $data['email'];

    $data['number'] = validateNumber($_POST['number']);
    if ($data['number'] === "Введите возраст") $errors[] = $data['number'];

    $data['select'] = validateSelect($_POST['select']);
    if ($data['select'] === "Выберите страну из списка") $errors[] = $data['select'];

    $data['radio'] = validateRadio($_POST['radio']);
    if ($data['radio'] === "Выберите пол") $errors[] = $data['radio'];

    $data['checkbox'] = validateCheckbox($_POST['checkbox'] ?? []);
    if ($data['checkbox'] === "Необходимо выбрать опцию") $errors[] = $data['checkbox'];

    $data['password'] = validatePassword($_POST['password']);
    if ($data['password'] === "Пароль не может быть пустым") $errors[] = $data['password'];

    if ($errors) {
        header('Location: index.php?errors=' . urlencode(json_encode($errors)));
        exit();
    } else {
        $data['timestamp'] = date("Y-m-d H:i:s");
        file_put_contents('log.json', json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);
        echo "<p style='color:green;'>Данные успешно записаны!</p>";
    }
}
?>
