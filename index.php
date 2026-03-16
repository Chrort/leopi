<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <title>Leoπ - Welcome</title>
</head>
<?php require_once './inc/header.php' ?>

<body>
    <main>
        <h1 id="link"><a href="./startpage/startpage.php">Starte jetzt!</a></h1>
        <section id="learn">
            <img src="./img/learn.jpg" alt="learn">
            <h2>← Lerne die Grundlagen!</h2>
        </section>
        <hr>
        <section id="train">
            <h2>Meistere deine Rechenkünste! →</h2>
            <img src="./img/train.jpg" alt="train">
        </section>
        <hr>
        <section id="play">
            <img src="./img/play.jpg" alt="play">
            <h2>← Teste dein Wissen spielerisch!</h2>
        </section>
    </main>
</body>
<?php require_once './inc/footer.php' ?>

</html>