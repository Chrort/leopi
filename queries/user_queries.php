<?php

//gibt alle usernames als num-array zurück
function getUsernames(mysqli $conn): array
{
    $stmt = $conn->prepare("SELECT name FROM users");
    $stmt->execute();
    $result = $stmt->get_result();

    $users = $result->fetch_all(MYSQLI_NUM);

    return $users;
}

//erstellt neuen nutzer in user-table
function addUser(mysqli $conn, string $name, string $pwd)
{
    $stmt = $conn->prepare("INSERT INTO users (name, pwd) VALUES (?,?)");
    $stmt->bind_param("ss", $name, $pwd);
    $stmt->execute();
}

//fragt pwd nach benutzername ab
function getPwdByName(mysqli $conn, string $name): ?string
{
    $stmt = $conn->prepare("SELECT pwd FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['pwd'] ?? null;
}

//gibt die Benutzer-Id anhand des Names zurück aus dem user-table
function getIdByName(mysqli $conn, string $name)
{
    $stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['id'];
}
