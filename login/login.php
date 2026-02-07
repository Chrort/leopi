<?php

session_start();

$displayLoginForm = "none";
$displayRegisterForm = "none";

$showForm = $_SESSION["showForm"] ?? "login";

$changeFormTextContent = "Registrieren";

//schaut ob er login- oder register from anzeigen soll
if ($showForm == "login") {
    $displayLoginForm = "block";
} else {
    $displayRegisterForm = "block";
    $changeFormTextContent = "Login";
}

//prüft auf anzuzeigende Nachrichten
$registrationMessage = $_SESSION['registrationMessage'] ?? "";
$loginMessage = $_SESSION['loginMessage'] ?? "";

//falls Nachrichten vorhanden $messageVisibility = "flex"; s.u.
$messageVisibility = "none";

$registrationMessage == "" && $loginMessage == "" ? $messageVisibility = "none" : $messageVisibility = "flex";

unset($_SESSION["showForm"], $_SESSION['registrationMessage'], $_SESSION['loginMessage']);

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
            <form action="../config/login_config.php" method="post" id="loginForm" style="display: <?= $displayLoginForm ?>">
                <fieldset>
                    <legend>Benutzername</legend>
                    <input type="text" name="name" id="name" required placeholder="Benutzername">
                </fieldset>
                <fieldset>
                    <legend>Passwort</legend>
                    <input type="password" name="pwd" id="pwd" required placeholder="Passwort">
                </fieldset>
                <input type="submit" value="Login" name="submit" id="submitLogin">
                <div id="logMessage" style="display: <?= $messageVisibility ?>;"><?= $loginMessage ?></div>
            </form>
            <form action="../config/register_config.php" method="post" id="registerForm" style="display: <?= $displayRegisterForm ?>">
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
                <input type="submit" value="Registrieren" name="submit" id="submitRegister">
                <div id="regMessage" style="display: <?= $messageVisibility ?>;"><?= $registrationMessage ?></div>
            </form>
            <h5 id="changeForm">Registrieren</h5>
        </div>
    </main>
</body>
<?php require_once '../inc/footer.php' ?>
<script src="./login.js"></script>

</html>