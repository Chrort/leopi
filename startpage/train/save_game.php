<?php

require_once '../../config/connect.php';
require '../../queries/user_queries.php';
require '../../queries/games_queries.php';

session_start();

$loggedIn = $_SESSION['loggedIn'] ?? false;

if (!$loggedIn) {
    header("Location: ../startpage.php");
}

$username = $_SESSION["username"];
$userId = getIdByName($conn, $username);
$fileName = $_GET['name'] ?? "invalid";
$score = $_GET['score'] ?? 0;

insertGameData($conn, $userId, $fileName, $score);

header("Location: ../startpage.php");
