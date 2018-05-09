<?php
require("config.php");
header('Content-Type: application/json');
$offset = (int) @$_GET["off"];

if(empty($_GET['mode'])){$_GET['mode'] = 'top';}

if(@$_GET['mode'] == 'top'){
$bt = qcache($database, "topdlapi".$offset, "beats", [
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
$bt = qcache($database, "newapi".$offset, "beats", [
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
$bt = qcache($database, "starapi".$offset, "beats", [
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


if(@$_GET['mode'] == 'hashinfo'){
if(empty($_GET["hash"])){die("NO HASH PROVIDED");}
if(strlen($_GET["hash"]) != 32){die("NO HASH PROVIDED");}
$hash = strtolower($_GET["hash"]);
$bt2 = qcache($database, "diffmapapi-".$hash, "diffmap",[
	"beatid",
], [
        'LIMIT' => "1",
	"hash" => $hash
]);
if(empty($bt2[0]["beatid"])){die(json_encode(array()));}

$bt = qcache($database, "diffmapapiinfo-".$bt2[0]["beatid"], "beats", [
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
	'id' => $bt2[0]["beatid"]
]);
foreach($bt as $key => $row){
$bt[$key]["difficultyLevels"] = json_decode($bt[$key]["difficultyLevels"]);
}
echo json_encode($bt, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PRETTY_PRINT);
}

