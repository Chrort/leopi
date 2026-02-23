<?php

function completeJsonData(array $jsonData): array
{
    //vervollstädigt fehlende array-keys um Fehler beim Lesen woanders zu vermeiden
    $completeJsonData = $jsonData;
    if (!array_key_exists("name", $completeJsonData)) $completeJsonData["name"] = "unnamened";
    if (!array_key_exists("file_name", $completeJsonData)) $completeJsonData["file_name"] = "missing";
    if (!array_key_exists("type", $completeJsonData)) $completeJsonData["type"] = "undefined";
    if (!array_key_exists("mode", $completeJsonData)) $completeJsonData["mode"] = "undefined";
    if (!array_key_exists("level", $completeJsonData)) $completeJsonData["level"] = 1;
    if (!array_key_exists("intro", $completeJsonData)) $completeJsonData["intro"] = "";
    if (!array_key_exists("pages", $completeJsonData)) $completeJsonData["pages"] = [];
    return $completeJsonData;
}

function getJsonFileContent(string $filePath, int $number): array
{
    //gibt den Inhalt des JSON Files vom entsprechendem Pfad zurück
    $completeFilePath = $filePath . "_" . $number . ".json";
    $json = file_get_contents($completeFilePath);
    $data = json_decode($json, true);
    return $data;
}
