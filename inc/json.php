<?php

function completeJsonData(array $jsonData): array
{
    $completeJsonData = $jsonData;
    if (!array_key_exists("name", $completeJsonData)) $completeJsonData["name"] = "unnamened";
    if (!array_key_exists("file_name", $completeJsonData)) $completeJsonData["file_name"] = "missing";
    if (!array_key_exists("type", $completeJsonData)) $completeJsonData["type"] = "undefined";
    if (!array_key_exists("intro", $completeJsonData)) $completeJsonData["intro"] = "";
    if (!array_key_exists("pages", $completeJsonData)) $completeJsonData["pages"] = [];
    return $completeJsonData;
}

function getJsonFileContent(string $filePath, int $number): array
{
    $completeFilePath = $filePath . "_" . $number . ".json";
    $json = file_get_contents($completeFilePath);
    $data = json_decode($json, true);
    return $data;
}
