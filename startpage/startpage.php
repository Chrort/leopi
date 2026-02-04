<?php

session_start();

$loggedIn = $_SESSION['loggedIn'] ?? false;
$username = $_SESSION['username'] ?? "";

$welcomeText;

//überpruft ob Nutzer eingeloggt ist; ob er Wilkommenstext anzeigen soll
$loggedIn ? $welcomeText = "Hallo " . $username . " 👋" : $welcomeText = "Logge dich ein um Fortschritt zu speichern";

$courseData = [
    ["id" => "introduction", "title" => "Einleitung"],
    ["id" => "multiplication", "title" => "Multiplikation"],
    ["id" => "division", "title" => "Division"],
    ["id" => "addition", "title" => "Addition"],
    ["id" => "subtraction", "title" => "Subtraktion"]
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
        <h1 id="hello"><?= htmlspecialchars($welcomeText) ?></h1>
        <section id="courses">
            <?php for ($i = 0; $i < count($courseData); $i++): //erstellt Kurspanele mithilfe Daten $courseData Array 
            ?>
                <div id="<?= $courseData[$i]["id"] ?>" class="course">
                    <div class="info">
                        <div class="title"><?= $courseData[$i]["title"] ?></div>
                        <div class="intro">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, alias? Ad sapiente laudantium commodi quos qui eum? Aspernatur quis reprehenderit quas. Eos repellendus earum nobis qui nostrum odio eveniet vitae.</div>
                    </div>
                    <div class="learn">
                        <?php for ($j = 0; $j < countFiles("../json/", $courseData[$i]["id"]); $j++): ?>
                            <div id="<?= $courseData[$i]["id"] . "_" . $j + 1 ?>" class="playButton">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                                    <path d="m400-400 240-160-240-160v320ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z" />
                                </svg>
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