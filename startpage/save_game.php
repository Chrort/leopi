<?php

//inkludiert SQL-Relevante files
require_once '../config/connect.php';
require '../queries/user_queries.php';
require '../queries/games_queries.php';

session_start();

$loggedIn = $_SESSION['loggedIn'] ?? false;

//wenn der Nutzer nicht angemeldet ist wird der Prozess übersprungen
if (!$loggedIn) {
    header("Location: ./startpage.php");
}

//sortiert die Daten für das INSERT-Statement, welches im oben inkludierten game_queries.php file ausgeführt wird
$username = $_SESSION["username"];
$userId = getIdByName($conn, $username);
$fileName = $_GET['name'] ?? "invalid";
$score = $_GET['score'] ?? 0;

insertGameData($conn, $userId, $fileName, $score);

//leitet den Nutzer zurück zur Startseit nach vollendung
header("Location: ./startpage.php");
