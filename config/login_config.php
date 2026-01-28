<?php

session_start();

require_once './connect.php';
//file mit queries für user table
require '../queries/user_queries.php';

if (!isset($_POST['submit'])) {
    exit();
}

//post form data von ../login/login.php
$name = $_POST['name'];
$pwd = $_POST['pwd'];

//eingabeüberprüfung
$errorHandlerResult = errorHandlers($conn, $name, $pwd);

if (!$errorHandlerResult[0]) {
    error($errorHandlerResult[1]);
}

$_SESSION['loggedIn'] = true;
$_SESSION['username'] = $name;
header("Location: ../startpage/startpage.php?loginSucces=true");
die();

//eingabeüberprüfung
function errorHandlers(mysqli $conn, string $name, string $pwd): array
{
    if (empty($name) || empty($pwd)) {
        return [false, "Fehlende Eingabe"];
    }

    if (!rightPwd($conn, $name, $pwd)) {
        return [false, "Benutzername oder Passwort falsch"];
    }

    return [true, "passed"];
}

//vergleicht pwd mit pwd in der db
function rightPwd(mysqli $conn, string $name, string $pwd): bool
{
    $hashedPwd = getPwdByName($conn, $name);

    if (password_verify($pwd, $hashedPwd)) return true;

    return false;
}

function error(string $message)
{
    $_SESSION['loginMessage'] = $message;
    header("Location: ../login/login.php?loginFailed=true");
    die();
}
