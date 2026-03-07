<?php

session_start();

//fileName der später in der DB-Gespeichert wird für den Highscore
$fileName = $_GET["fileName"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Übergabe an das JS-File -->
    <meta name="fileName" id="fileName" content="<?= $fileName ?>">
    <link rel="stylesheet" href="../../../css/invasion.css">
    <link rel="stylesheet" href="../../../css/header.css">
    <link rel="stylesheet" href="../../../css/footer.css">
    <link rel="shortcut icon" href="../../../img/logo.png" type="image/x-icon">
    <title>Leoπ - Invasion</title>
</head>
<?php require_once '../../../inc/header.php' ?>

<body>
    <main>
        <div id="info">
            <div id="health"></div>
            <div id="points">0 Punkte</div>
        </div>
        <div id="endScreen">
            <h1>GAME OVER!</h1>
            <h3 id="score">Punkte: </h3>
            <div id="homeBtn">
                <a href="../../../startpage/startpage.php" id="homeLink">
                    <svg xmlns="http://www.w3.org/2000/svg" height="2rem" viewBox="0 -960 960 960" width="2rem" fill="#000000">
                        <path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320240v480H520v-240h-80v240H160Zm320-350Z" />
                    </svg>
                </a>
            </div>
        </div>
    </main>
</body>
<?php require_once '../../../inc/footer.php' ?>
<script src="./invasion.js"></script>

</html>