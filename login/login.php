<?php

session_start();

$registrationMessage = $_SESSION['registrationMessage'] ?? "";
$messageVisibility = "none";

$registrationMessage == "" ? $messageVisibility = "none" : $messageVisibility = "flex";

unset($_SESSION['registrationMessage']);

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
        <form action="../config/login_config.php" method="post" id="loginForm">
            <fieldset>
                <legend>Benutzername</legend>
                <input type="text" name="name" id="name" required>
            </fieldset>
            <fieldset>
                <legend>Passwort</legend>
                <input type="password" name="pwd" id="pwd" required>
            </fieldset>
            <input type="submit" value="Login" name="submit" id="submitLogin">
        </form>
        <form action="../config/register_config.php" method="post" id="registerForm">
            <fieldset>
                <legend>Benutzername</legend>
                <input type="text" name="name" id="name" required>
            </fieldset>
            <fieldset>
                <legend>Passwort</legend>
                <input type="password" name="pwd" id="pwd" required>
            </fieldset>
            <fieldset>
                <legend>Wiederhole Passwort</legend>
                <input type="password" name="pwdRepeat" id="pwdRepeat" required>
            </fieldset>
            <input type="submit" value="Register" name="submit" id="submitRegister">
        </form>
        <div id="regMessage" style="display: <?= $messageVisibility ?>;"><?= $registrationMessage ?></div>
    </main>
</body>
<?php require_once '../inc/footer.php' ?>
<script src="./login.js"></script>

</html>