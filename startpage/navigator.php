<?php

//navigiert anhand des query-paths weiter zum richtigem trainings-file

$fileName = $_GET["fileName"];
$type = $_GET["type"];

switch ($type) {
    case "learn":
        header("Location: ./learn/learn.php?fileName=$fileName");
        break;
    case "train":
        header("Location: ./train/train.php?fileName=$fileName");
        break;
    case "game":
        if ($fileName == "invasion.json") header("Location: ./games/invasion/invasion.php?fileName=$fileName");
        else header("Location: ./startpage.php?could_not_file&missed=$fileName");
        break;
    default:
        header("Location: ./startpage.php?could_not_file");
}
