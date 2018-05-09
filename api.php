<?php
require("config.php");
header('Content-Type: application/json');
$offset = (int) @$_GET["off"];

if(empty($_GET['mode'])){$_GET['mode'] = 'top';}

if(@$_GET['mode'] == 'top'){
$bt = $database->select("beats", [
        "id",
        "beatname",
        "ownerid",
        "downloads",
        "upvotes",
        "beattext",
        "uploadtime",
        "songName",
        "songSubName",
        "authorName",
        "beatsPerMinute",
        "difficultyLevels",
        "img"
], [
        'LIMIT' => [$offset, 15],
        "ORDER" => ["downloads" => "DESC",]
]);
foreach($bt as $key => $row){
$bt[$key]["difficultyLevels"] = json_decode($bt[$key]["difficultyLevels"]);
}
echo json_encode($bt, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PRETTY_PRINT);
}

if(@$_GET['mode'] == 'new'){
$bt = $database->select("beats", [
        "id",
        "beatname",
        "ownerid",
        "downloads",
        "upvotes",
        "beattext",
        "uploadtime",
        "songName",
        "songSubName",
        "authorName",
        "beatsPerMinute",
        "difficultyLevels",
        "img"
], [
        'LIMIT' => [$offset, 15],
        "ORDER" => ["id" => "DESC",]
]);
foreach($bt as $key => $row){
$bt[$key]["difficultyLevels"] = json_decode($bt[$key]["difficultyLevels"]);
}

echo json_encode($bt, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PRETTY_PRINT);
}

if(@$_GET['mode'] == 'star'){
$bt = $database->select("beats", [
        "id",
        "beatname",
        "ownerid",
        "downloads",
        "upvotes",
        "beattext",
        "uploadtime",
        "songName",
        "songSubName",
        "authorName",
        "beatsPerMinute",
        "difficultyLevels",
        "img"
], [
        'LIMIT' => [$offset, 15],
        "ORDER" => ["upvotes" => "DESC",]
]);
foreach($bt as $key => $row){
$bt[$key]["difficultyLevels"] = json_decode($bt[$key]["difficultyLevels"]);
}
echo json_encode($bt, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PRETTY_PRINT);
}

