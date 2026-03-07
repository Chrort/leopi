<?php

session_start();

//inkludiert SQL-relevante files
require_once '../config/connect.php';
require '../queries/user_queries.php';
require '../queries/games_queries.php';

$loggedIn = $_SESSION['loggedIn'] ?? false;

//leitet nicht angemeldete Nutzer zurück zur Startseite
if (!$loggedIn) {
    header("Location: ../index.php");
}

//holt sich erst die Nutzer-Id anhand des Namens und dann die relevanten Tabellenspalten des Nutzers
$username = $_SESSION['username'];
$id = getIdByName($conn, $username);
$userGameData = getDataByPlayer($conn, $id);

$average = 0;
//falls registrierte gespielte Spiele vorhanden sind wird der Druchschnitt berechnet (sonst 0)
if (count($userGameData) != 0) $average = round(totalScore($userGameData) / count($userGameData), 2);

function totalScore(array $userGameData): int
{
    $score = 0;
    //addiert alle score Spalten zusammen
    for ($i = 0; $i < count($userGameData); $i++) {
        $score += $userGameData[$i]['score'];
    }
    //gibt Summe der Punktzahlen zurück
    return $score;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>Leoπ - Profile</title>
</head>
<?php require_once '../inc/header.php' ?>

<body>
    <main>
        <h1 id="username"><?= htmlspecialchars($username) ?></h1>
        <div id="info">
            <p>Gespielte Spiele: <?= htmlspecialchars(count($userGameData)) ?></p>
            <p>Gesamtpunktzahl: <?= htmlspecialchars(totalScore($userGameData)) ?></p>
            <p>Durchschnittspunktzahl: <?= htmlspecialchars($average) ?></p>
        </div>
    </main>
</body>
<?php require_once '../inc/footer.php' ?>

</html>