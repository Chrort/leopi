<?php

session_start();

require '../../inc/json.php';

$fileName = $_GET["fileName"];
$panel = $_GET["panel"] ?? 1;

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
    <!-- <meta>-tags beinhalten nicht sensible Daten für das Js-File -->
    <meta name="startingPanel" content="<?= $panel ?>">
    <meta name="maxPanel" content="<?= count($jsonData["pages"]) ?>">
    <link rel="stylesheet" href="../../css/learn.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
    <title>Leoπ - <?= $jsonData["name"] ?></title>
</head>
<!-- inkludiert die <header> Blaupause -->
<?php require_once '../../inc/header.php' ?>

<body>
    <main>
        <h1><?= $jsonData["name"] ?></h1>
        <!-- .navBtn dienen zur Navigation der Folien -->
        <div id="goLeft" class="navBtn" onclick="move(-1)">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960" width="1em" fill="#1f1f1f">
                <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z" />
            </svg>
        </div>
        <div id="goRight" class="navBtn" onclick="move(1)">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960" width="1em" fill="#1f1f1f">
                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
            </svg>
        </div>
        <section id="panels" style="width: calc(100% * <?= count($jsonData["pages"]) ?>);">
            <!-- für jede "page" in der $jsonData-Array wird ein neues <div>.panel erstellt und mit entsprechendem Text gefüllt -->
            <?php for ($i = 0; $i < count($jsonData["pages"]); $i++): ?>
                <div class="panel" id="panel_<?= $i ?>" style="width: calc(100% / <?= count($jsonData["pages"]) ?>)">
                    <?= $jsonData["pages"][$i] ?>
                </div>
            <?php endfor; ?>
        </section>
    </main>
</body>
<!-- inkludiert die <footer> Blaupause -->
<?php require_once '../../inc/footer.php' ?>
<script src="./learn.js"></script>

</html>