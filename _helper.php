<?php

function dd($data) {
    header('Content-type: application/json');
    echo json_encode($data);
    die();
}

function get($key) {
    if (isset($_GET[$key])) return trim($_GET[$key]);
    return "";
}

function post($key) {
    if (isset($_POST[$key])) {
        return trim($_POST[$key]);
    }
    return "";
}

function redirect($location) {
    header("location: $location");
    die();
}

function flashMessage($name, $message, $type) {

    // remove existing message with the name
    if (isset($_SESSION[FLASH][$name])) {
        unset($_SESSION[FLASH][$name]);
    }

    $_SESSION[FLASH][$name] = ['message' => $message, 'type' => $type];
}

function formattedFlashMessage($flashMessage) {
    return sprintf("<div class='alert alert-%s'>%s</div>",
        $flashMessage['type'],
        $flashMessage['message']
    );
}

function displayFlashMessage($name) {

    if (!isset($_SESSION[FLASH][$name])) return;

    $flashMessage = $_SESSION[FLASH][$name];

    unset($_SESSION[FLASH][$name]);

    echo formattedFlashMessage($flashMessage);
}