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
