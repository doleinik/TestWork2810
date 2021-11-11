<?php

if (isset($_POST["name"]) ) {

    // Формируем массив для JSON ответа
    $result = array(
        'name' => $_POST["your-name"],
        'phone' => $_POST["your-phone"],
        'email' => $_POST["your-email"],

    );

    // Переводим массив в JSON
    echo json_encode($result);
}

?>