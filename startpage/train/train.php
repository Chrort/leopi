<?php

session_start();

require '../../inc/json.php';

$fileName = $_GET["fileName"];

//schneidet String für die Funktion <getJsonFileContent> zurecht
$firstSplit = explode("_", $fileName);
$name = $firstSplit[0];
$number = explode(".", $firstSplit[1])[0];

$jsonData = completeJsonData(getJsonFileContent("../../json/" . $name, $number));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="level" id="level" content="<?= $jsonData["level"] ?>">
    <meta name="mode" id="mode" content="<?= $jsonData["mode"] ?>">
    <meta name="fileName" id="fileName" content="<?= $fileName ?>">
    <link rel="stylesheet" href="../../css/train.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
    <title>Leoπ - <?= $jsonData["name"] ?></title>
</head>
<?php require_once '../../inc/header.php' ?>

<body>
    <main>
        <div id="container">
            <div id="info">
                <p id="questionInfo">Frage: 1/10</p>
                <p id="timer"></p>
                <p id="scoreInfo">Punkte: 0</p>
            </div>
            <div id="task">
                <div id="fraction_1">
                    <div class="int" id="int_1">34</div>
                    <hr>
                    <div class="int" id="int_2">4</div>
                </div>
                <div id="mode"><?= $jsonData["mode"] ?></div>
                <div id="fraction_2">
                    <div class="int" id="int_3">5</div>
                    <hr>
                    <div class="int" id="int_4">6</div>
                </div>
                <div id="equal">=</div>
                <div id="fraction_3">
                    <input type="number" name="input_1" id="input_1" min="0" max="99" class="input_int">
                    <hr id="hr_3">
                    <input type="number" name="input_2" id="input_2" min="0" max="99" class="input_int">
                </div>
            </div>
            <div id="submit">
                <button id="btn">Prüfe</button>
            </div>
        </div>
    </main>
</body>
<?php require_once '../../inc/footer.php' ?>
<script src="./train.js"></script>

</html>