<?php

session_start();

require '../inc/json.php';
require_once '../config/connect.php';
require '../queries/user_queries.php';
require '../queries/games_queries.php';

$loggedIn = $_SESSION['loggedIn'] ?? false;
$username = $_SESSION['username'] ?? "";

$welcomeText;

//überpruft ob Nutzer eingeloggt ist; ob er Wilkommenstext anzeigen soll
$loggedIn ? $welcomeText = "Hallo " . $username . " 👋" : $welcomeText = "<a href='../login/login.php'>Logge dich ein um Fortschritt zu speichern</a>";

$courseData = [
    ["id" => "introduction", "title" => "Einleitung", "intro" => "Tauche ein in die Welt der Bruchrechnung! Lerne Grundlagen um mit perfekten Startbedingungen losrechnen zu können."],
    ["id" => "multiplication", "title" => "Multiplikation", "intro" => "Von den vier Grundrechenarten ist die Multiplikation das simpelste, da keine Erweiterung nötig ist zum verrechnen."],
    ["id" => "division", "title" => "Division", "intro" => "Division ist genauso wie Multiplikation nur, dass man vorher den Kehrwert bilden muss. Also quasi genauso zielgerichtet lösbar."],
    ["id" => "addition", "title" => "Addition", "intro" => "Bei der Addition wird es im Kopf ein bisschen schwieriger, da man erst die Brüche gleichnamig machen muss, also den Wert des Nenners anpassen muss durch erweitern."],
    ["id" => "subtraction", "title" => "Subtraktion", "intro" => "Sobald man Addition gemeistert hat gibt es keine weitere Hürde die im Weg steht um zu subtrahiern. Gleiches Prinzip - es wird nur weniger."],
    ["id" => "game", "title" => "Spiele", "intro" => "Beweise deine Rechenkünste spielerisch!"]
];

//zählt files mit entsprechendem Präfix
function countFiles(string $dir, string $prefix)
{
    $allFiles = scandir($dir);
    $files = 0;
    for ($i = 0; $i < count($allFiles); $i++) {
        //vergleicht Argumentpräfix mit gefundenen files
        if ($prefix == substr($allFiles[$i], 0, strlen($prefix))) $files++;
    }
    return $files;
}

function getHighscore(mysqli $conn, string $fileName, string $username, bool $loggedIn): string
{
    //brich ab wenn der Nutzer nicht eingeloggt ist
    if ($username == "" || $loggedIn == false) return "N/A";

    //holt sich player_id und dann die Daten vom Nutzer
    $playerId = getIdByName($conn, $username);
    $gameData = getDataByPlayer($conn, $playerId);

    $maxScore = -1;

    //iteriert durch die gameData-Array und speichert jeweils den höchsten score nach fileName
    for ($i = 0; $i < count($gameData); $i++) {
        if ($gameData[$i]['name'] == $fileName && $gameData[$i]['score'] > $maxScore) $maxScore = $gameData[$i]['score'];
    }
    if ($maxScore == -1) return "Kein Ergebnis"; //falls kein Eintrag gefunden wurde
    return $maxScore . " P";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/startpage.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Leoπ - Startpage</title>
</head>
<?php require_once '../inc/header.php' ?>

<body>
    <main>
        <h1 id="hello"><?= $welcomeText ?></h1>
        <section id="courses">
            <?php for ($i = 0; $i < count($courseData); $i++): //erstellt Kurspanele mithilfe Daten $courseData Array 
            ?>
                <div id="<?= $courseData[$i]["id"] ?>" class="course">
                    <div class="info">
                        <div class="title"><?= $courseData[$i]["title"] ?></div>
                        <hr>
                        <div class="intro"><?= $courseData[$i]["intro"] ?></div>
                    </div>
                    <div class="learn">
                        <?php
                        for ($j = 0; $j < countFiles("../json/", $courseData[$i]["id"]); $j++):
                            //liest die entsprechende JSON-Daten für jeden Kurs/Übung aus
                            $jsonData = getJsonFileContent("../json/" . $courseData[$i]["id"], $j + 1);

                            //vervollständigt ggf. fehlende array-keys
                            $jsonData = completeJsonData($jsonData);

                            //speichert den Rückgabewert von der getHighscore Funktion
                            $highscore = getHighscore($conn, $jsonData["file_name"], $username, $loggedIn);
                        ?>
                            <div id="<?= $courseData[$i]["id"] . "_" . $j + 1 ?>" class="playButton <?= $courseData[$i]["id"] ?>">
                                <a href="./navigator.php?type=<?= $jsonData["type"] ?>&fileName=<?= $jsonData["file_name"] ?>"></a>
                                <?php if ($jsonData["type"] == "learn"): ?> <!--zeigt das entsprechende Icon, je nach Kurstyp-->
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                                        <path d="M423.5-103.5Q400-127 400-160h160q0 33-23.5 56.5T480-80q-33 0-56.5-23.5ZM320-200v-80h320v80H320Zm10-120q-69-41-109.5-110T180-580q0-125 87.5-212.5T480-880q125 0 212.5 87.5T780-580q0 81-40.5 150T630-320H330Zm24-80h252q45-32 69.5-79T700-580q0-92-64-156t-156-64q-92 0-156 64t-64 156q0 54 24.5 101t69.5 79Zm126 0Z" />
                                    </svg>
                                <?php elseif ($jsonData["type"] == "train"): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="<?= 16 + 7 * $jsonData["level"] ?>px" viewBox="0 -960 960 960" width="<?= 16 + 7 * $jsonData["level"] ?>px" fill="#1f1f1f">
                                        <path d="m826-585-56-56 30-31-128-128-31 30-57-57 30-31q23-23 57-22.5t57 23.5l129 129q23 23 23 56.5T857-615l-31 30ZM346-104q-23 23-56.5 23T233-104L104-233q-23-23-23-56.5t23-56.5l30-30 57 57-31 30 129 129 30-31 57 57-30 30Zm397-336 57-57-303-303-57 57 303 303ZM463-160l57-58-302-302-58 57 303 303Zm-6-234 110-109-64-64-109 110 63 63Zm63 290q-23 23-57 23t-57-23L104-406q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l63 63 110-110-63-62q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l303 303q23 23 23 56.5T857-441l-57 57q-23 23-57 23t-57-23l-62-63-110 110 63 63q23 23 23 56.5T577-161l-57 57Z" />
                                    </svg>
                                <?php elseif ($jsonData["type"] == "game"): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="m380-300 280-180-280-180v360ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                <?php endif; ?>
                                <!-- kurzer Inhaltstext der Lektion / ggf. Höchstpunktzahl -->
                                <p class="introText">
                                    <?php
                                    echo htmlspecialchars($jsonData["intro"]) . "<br>";
                                    if ($jsonData["type"] == "train" || $jsonData["type"] == "game") echo "🏆 " . htmlspecialchars($highscore);
                                    ?>
                                </p>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </section>
    </main>
</body>
<?php require_once '../inc/footer.php' ?>
<script src="./startpage.js"></script>

</html>