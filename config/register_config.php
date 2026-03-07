<?php

session_start();

require_once './connect.php';
//File mit queries für user table
require '../queries/user_queries.php';

if (!isset($_POST['submit'])) {
    exit();
}

//post-form data von ../login/login.php
$name = $_POST['name'];
$pwd = $_POST['pwd'];
$pwdRepeat = $_POST['pwdRepeat'];

//Eingabeüberprüfung
$errorHandlerResult = errorHandlers($conn, $name, $pwd, $pwdRepeat);

if (!$errorHandlerResult[0]) {
    error($errorHandlerResult[1]);
}

//erstelle neuen Nutzer
try {
    addUser($conn, $name, password_hash($pwd, PASSWORD_DEFAULT));
} catch (Exception $e) {
    error($e->getMessage());
}

$_SESSION['loginMessage'] = "Erfolgreich Registriert als " . htmlspecialchars($name) . "!";
$_SESSION['showForm'] = "login";
header("Location: ../login/login.php?registrationSucces=true");
die();

//überprüft Eingabe auf Vollständigkeit/Länge/Stimmigkeit
function errorHandlers(mysqli $conn, string $name, string $pwd, string $pwdRepeat): array
{
    if (empty($name) || empty($pwd) || empty($pwdRepeat)) {
        return [false, "Fehlende Eingabe"];
    }

    if (in_array($name, getUsernames($conn))) {
        return [false, "Benutzername vergeben"];
    }

    if (strlen($name) < 3) {
        return [false, "Benutzername zu kurz"];
    }

    if (strlen($name) > 15) {
        return [false, "Benutzername zu lang"];
    }

    if ($pwd != $pwdRepeat) {
        return [false, "Ungleiche Passwörter"];
    }

    if (strlen($pwd) < 8) {
        return [false, "Passwort zu kurz"];
    }

    return [true, "passed"];
}

//allgemeine Funktion zum redirecten und Nachricht ausgeben
function error(string $message)
{
    $_SESSION['registrationMessage'] = $message;
    $_SESSION['showForm'] = "register";
    header("Location: ../login/login.php?registrationFailed=true");
    die();
}
