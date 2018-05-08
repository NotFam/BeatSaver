<?php
$requirelogin = true;
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require("config.php");
$data = $database->select("beats", [
	"id",
], [
	"id" => $_GET["id"]
]);
if(!empty($data[0]["id"])){
$vote = $database->select("votes", "id", [
	"userid" => $_SESSION["userdb"][0]["id"],
	"beatid" => $data[0]["id"]
]);
var_dump($vote);
if(empty($vote[0])){
$database->update("beats", [ "upvotes[+]" => 1],["id" => $data[0]["id"]]);
$database->insert("votes", [
        "userid" => $_SESSION["userdb"][0]["id"],
        "beatid" => $data[0]["id"]
]);
}
header("Location: details.php?id=" . $data[0]["id"]);
die();
}else{
die("Not Found in Database");
}
