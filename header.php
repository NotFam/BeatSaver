<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1024">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Hacker Secret API https://beatsaver.com/api.php?mode=top&off=0 | https://beatsaver.com/api.php?mode=star&off=0 | https://beatsaver.com/api.php?mode=new&off=0 -->
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<title><?php echo $pagetitle; ?></title>
  </head>
  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">Beat Saver</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="topdl.php">Top Downloads</a></li>
	    <li><a href="topstar.php">Top Rated</a></li>
            <li><a href="browse.php">Newest</a></li>
	    <li><a href="https://github.com/xyonico/BeatSaberSongInjector/releases">Song Injector</a></li>
	    <li><a href="https://discord.gg/f759rpu">Mod Discord</a></li>
            <?php if(!empty($_SESSION["userdb"][0]["id"])){?><li><a href="upload.php">Upload a BeatTrack</a></li><?php } ?>
            <?php if(empty($_SESSION["userdb"][0]["id"])){?><li><a href="login.php">Login / Register</a></li><?php } ?>
            <?php if(!empty($_SESSION["userdb"][0]["id"])){?><li><a href="profile.php"><?php echo $_SESSION["userdb"][0]["username"];?></a></li><?php } ?>
	   <?php if(!empty($_SESSION["userdb"][0]["id"])){?><li><a href="logout.php">Logout</a></li><?php } ?>
          </ul>
        </div>
      </div>
    </nav>
