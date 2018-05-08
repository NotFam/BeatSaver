<?php
$requirelogin = true;
require("config.php");
$pagetitle = "BeatSaver - Upload Beat Track";

//$url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
//$string= preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $string);
//echo $string;
if(!empty($_POST["beattitle"])){
echo "<pre>";
$zip = zip_open($_FILES["fileupload"]["tmp_name"]);

if ($zip) {
//Search 1 -- Look for info.json
    while ($zip_entry = zip_read($zip)) {
	echo zip_entry_name($zip_entry) . PHP_EOL;
        if(strpos(zip_entry_name($zip_entry), "info.json") > 3){
        if (zip_entry_open($zip, $zip_entry, "r")) {
            $json = json_decode(zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)), TRUE);
            zip_entry_close($zip_entry);
        }
	}
    }
}
zip_close($zip);
//decode json
if(empty($json["songName"])){die("Missing Song Name, Note: Songname must be longer then three letters and be in a subfolder like SongName/info.json");}
//if(empty($json["songSubName"])){die("Missing SongSub Name");}
if(empty($json["authorName"])){die("Missing Author Name in the info.js");}
if(empty($json["beatsPerMinute"])){die("Missing BPM in the info.js");}
if(empty($json["coverImagePath"])){die("Missing Cover Image in the zip or info.js");}
if(empty($json["difficultyLevels"])){die("Missing Difficulty Levels in the info.js");}

$zip2 = zip_open($_FILES["fileupload"]["tmp_name"]);
if ($zip2) {
//Search 2 -- Look for coverart // TODO CHECK IMAGE SIZE
    while ($zip2_entry = zip_read($zip2)) {
        if(strpos(zip_entry_name($zip2_entry), $json["coverImagePath"]) !== false){
        if (zip_entry_open($zip2, $zip2_entry, "r")) {
            $imgdata = zip_entry_read($zip2_entry, zip_entry_filesize($zip2_entry));
            zip_entry_close($zip2_entry);
        }
        }
    }
}
zip_close($zip2);
if(empty($imgdata)){die("Failed to Extract Image Data");}
echo "</pre>";

$beattitle = htmlentities(substr($_POST["beattitle"], 0, 160), ENT_QUOTES | ENT_HTML5,'ISO-8859-1', true);
$beatdesc = htmlentities(substr($_POST["beatdesc"], 0, 4096), ENT_QUOTES | ENT_HTML5,'ISO-8859-1', true);

function gg_filter($text){
return htmlentities(substr($text, 0, 160), ENT_QUOTES | ENT_HTML5,'ISO-8859-1', true);
}

if(strlen($beattitle) < 4){die("Too Start of a Title, Must be longer then 4 letters");}
if(strlen($beatdesc) < 6){die("Too short of a Desc, Needs to be longer then 6 letters");}

// everything is good, database, then img then zip!

$path_parts = pathinfo($json["coverImagePath"]);
$imageFileType  = $path_parts['extension'];
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    die("Sorry, only JPG, JPEG, PNG & GIF files are allowed for album art");
}

$database->insert("beats", [
	"beatname" => "$beattitle",
	"beattext" => nl2br("$beatdesc"),
        "uploadtime" => time(),
	"ownerid" => $_SESSION["userdb"][0]["id"],
        "songName" => gg_filter($json["songName"]),
        "songSubName" => gg_filter($json["songSubName"]),
        "authorName" => gg_filter($json["authorName"]),
        "beatsPerMinute" => $json["beatsPerMinute"],
        "difficultyLevels" => json_encode($json["difficultyLevels"]),
	"img"	=> $imageFileType
]);
$uid = $database->id();
$target_file = "files/" . $uid . ".zip";
if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
	file_put_contents("img/$uid.".$imageFileType, $imgdata);
	header("Location: details.php?id=" . $uid);
	die();
    } else {
        die("Sorry, there was an error uploading your file.");
    }

}



require("header.php");
?>
<style>
body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 530px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
   <div class="container">

      <form class="form-signin" method="post" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Upload Beat Track</h2>
        <label for="inputEmail" class="sr-only">Beat Track Name</label>
  <div class="form-group">
    <label for="InputFile">Beat Track Name</label>
        <input type="username" name="beattitle" name="username" id="inputEmail" class="form-control" placeholder="160 Letters Max" required autofocus>
</div>
  <div class="form-group">
    <label for="InputFile">File input</label>
    <input type="file" id="InputFile" name="fileupload">
    <p class="help-block">Must meet the following upload rules<br><ul>
<li>Must be a ZIP file with the songs subfolder in the root (EG: SongName/info.json)</li>
<li>Must be under 15MB</li>
<li>Must contain vaild metadata and album art</li>
<li>Make sure you have permission to use any content involved in your beatmap. This includes songs, videos, hit sounds, graphics, and any other content that isn't your own creation.</li>
<li>Do not plagiarise or attempt to steal the work of others. Do not also upload or use other people's work without their explicit permission (including, but not limited to, skins and guest difficulties).</li>
</ul>
</p>
  </div>
<div class="form-group">
<label for="TextFile">Beat Description</label>
<textarea name="beatdesc" id="TextFile" class="form-control" rows="3"></textarea>
<p class="help-block">
Plain Text Only,
</p>
</div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>
