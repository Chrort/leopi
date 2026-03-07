<?php

//speichert id/file-name/score in einem neuen Tabelleneintrag
function insertGameData(mysqli $conn, int $playerId, string $name, int $score)
{
    $stmt = $conn->prepare("INSERT INTO games (player_id, name, score) VALUES (?,?,?)");
    $stmt->bind_param("isi", $playerId, $name, $score);
    $stmt->execute();
}

//gibt anhand der Nutzer-Id die restlichen Daten zum Benutzer zurück
function getDataByPlayer(mysqli $conn, int $playerId): array
{
    $stmt = $conn->prepare("SELECT * FROM games WHERE player_id = ?");
    $stmt->bind_param("i", $playerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}
