<?php
$requirelogin = true;
require("config.php");
$offset = (int) $_GET["off"];
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
        "ownerid" => $_SESSION["userdb"][0]["id"],
	"id" => $_GET['id']
]);

if(!empty($bt[0]["id"])){
$database->delete("beats", [ "id" => $_GET['id'] ]);
$database->delete("votes", [ "beatid" => $_GET['id'] ]);
$database->delete("diffmap", [ "beatid" => $_GET['id'] ]);
unlink("files/".$bt[0]["id"].".zip");
unlink("img/".$bt[0]["id"].'.'.$bt[0]["img"]);
}
header("Location: profile.php");
