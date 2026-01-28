<?php

session_start();

$loggedIn = $_SESSION['loggedIn'] ?? false;
$username = $_SESSION['username'] ?? "";

$welcomeText;

$loggedIn ? $welcomeText = "Hallo " . $username . " 👋" : $welcomeText = "Logge dich ein um Fortschritt zu speichern";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/startpage.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Leoπ - Startpage</title>
</head>
<?php require_once '../inc/header.php' ?>

<body>
    <main>
        <h1><?= htmlspecialchars($welcomeText) ?></h1>
        <section id="courses">
            <div id="introduction" class="course">
                <div class="info">
                    <div class="title">Einleitung</div>
                    <div class="intro">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, alias? Ad sapiente laudantium commodi quos qui eum? Aspernatur quis reprehenderit quas. Eos repellendus earum nobis qui nostrum odio eveniet vitae.</div>
                </div>
                <div class="learn">

                </div>
            </div>
        </section>
    </main>
</body>
<?php require_once '../inc/footer.php' ?>

</html>