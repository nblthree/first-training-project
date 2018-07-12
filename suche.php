<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="manifest" href="manifest.json">
    <link rel="stylesheet" type="text/css" href="styleall.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<title>QuizBowl</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="formulairjs.js"></script>
	<script src="//twemoji.maxcdn.com/2/twemoji.min.js?2.4"></script>
<body>
<?php include('header.php'); ?>
<div id="limit">
<div id="li2">

<?php include('messages.php'); ?>
<?php include('start_chess.php'); ?>
<div class="flexs"></div>
<section id="suchen">
<?php
if (isset($_GET['searchinput'])){

	$us = htmlspecialchars($_GET['searchinput']);
	$req = $bdd->query('SELECT pseudo, avatarimageurl FROM members');

$r = 0;
while ($resultat = $req->fetch()) {
	

if (stripos($resultat['pseudo'], $us) === 0) { // Si la valeur commence par les mêmes caractères que la recherche
	
	        ?>
	        <li><a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>"><div class="cfkk" style="display: flex;">
	<div class='randomavatar' style='width: 100%; height: 60px; display: flex;'>
	    <div id="randomimage">
<span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"></span></div>
	<span style="line-height: 60px; margin-left: 10px;"><?php echo $resultat['pseudo']; ?></span>	
    </div>
</div></a></li>
	        <?php
	$r++;
	    }




}
if ($r == 0) {
	?>
	<li><div id="cfkk" style="display: flex;">
	<span style="line-height: 54px; margin: auto; font-weight: 600; color: #000;">No results for <?php echo $us ?></span>	
    </div></li>
<?php
}
}
?>
</section>
<div class="flexs"></div>
</div>
<footer>
	<span><span>&#169;</span>2018 QuizBowl</span>
</footer>
</div>
</body>
</html>
<?php
}else{
	echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
?>