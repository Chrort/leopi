<?php

session_start();

$registrationMessage = $_SESSION['registrationMessage'] ?? "";
$loginMessage = $_SESSION['loginMessage'] ?? "";

$messageVisibility = "none";

$registrationMessage == "" && $loginMessage == "" ? $messageVisibility = "none" : $messageVisibility = "flex";

unset($_SESSION['registrationMessage']);
unset($_SESSION['loginMessage']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Leoπ - Login</title>
</head>
<?php require_once '../inc/header.php' ?>

<body>
    <main>
        <div id="forms">
            <form action="../config/login_config.php" method="post" id="loginForm">
                <fieldset>
                    <legend>Benutzername</legend>
                    <input type="text" name="name" id="name" required placeholder="Benutzername">
                </fieldset>
                <fieldset>
                    <legend>Passwort</legend>
                    <input type="password" name="pwd" id="pwd" required placeholder="Passwort">
                </fieldset>
                <input type="submit" value="Login" name="submit" id="submitLogin">
            </form>
            <div id="logMessage" style="display: <?= $messageVisibility ?>;"><?= $loginMessage ?></div>
            <form action="../config/register_config.php" method="post" id="registerForm">
                <fieldset>
                    <legend>Benutzername</legend>
                    <input type="text" name="name" id="name" required placeholder="Benutzername">
                </fieldset>
                <fieldset>
                    <legend>Passwort</legend>
                    <input type="password" name="pwd" id="pwd" required placeholder="Passwort">
                </fieldset>
                <fieldset>
                    <legend>Wiederhole Passwort</legend>
                    <input type="password" name="pwdRepeat" id="pwdRepeat" required placeholder="Passwort">
                </fieldset>
                <input type="submit" value="Register" name="submit" id="submitRegister">
            </form>
            <div id="regMessage" style="display: <?= $messageVisibility ?>;"><?= $registrationMessage ?></div>
            <h5 id="changeForm">Registrieren</h5>
        </div>
    </main>
</body>
<?php require_once '../inc/footer.php' ?>
<script src="./login.js"></script>

</html>