<?php

session_start();

require_once '../config/connect.php';
require '../queries/user_queries.php';
require '../queries/games_queries.php';

$loggedIn = $_SESSION['loggedIn'] ?? false;

if (!$loggedIn) {
    header("Location: ../index.php");
}

$username = $_SESSION['username'];
$id = getIdByName($conn, $username);
$userGameData = getDataByPlayer($conn, $id);

function totalScore(array $userGameData): int
{
    $score = 0;
    for ($i = 0; $i < count($userGameData); $i++) {
        $score += $userGameData[$i]['score'];
    }
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
            <p>Gespielte Spiele: <?= count($userGameData) ?></p>
            <p>Gesamtpunktzahl: <?= totalScore($userGameData) ?></p>
            <p>Durchschnittspunktzalh: <?= round(totalScore($userGameData) / count($userGameData), 3) ?></p>
        </div>
    </main>
</body>
<?php require_once '../inc/footer.php' ?>

</html>