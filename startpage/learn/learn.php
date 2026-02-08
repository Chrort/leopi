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
    <link rel="stylesheet" href="../../css/learn.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
    <title>Leoπ - <?= $jsonData["name"] ?></title>
</head>
<?php require_once '../../inc/header.php' ?>

<body>
    <main>
        <?php var_dump($jsonData) ?>
    </main>
</body>
<?php require_once '../../inc/footer.php' ?>

</html>