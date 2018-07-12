<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
session_start();
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
$i=1;
	$req = $bdd->query('SELECT pseudo, avatarimageurl FROM members ORDER BY nm DESC limit 500');
while($resultat = $req->fetch()) {
	
	        ?>
	        <li><a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>">
	<div class="cfkk" style="display: flex;">
	    <div class='randomavatar' style='width: 80%; height: 60px; display: flex;'>
	        <div id="randomimage">
                <span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"></span>
            </div>
	        <span style="line-height: 60px; margin-left: 10px;"><?php echo $resultat['pseudo']; ?></span>	
        </div>
        <div class="classement"><div <?php  if($i<=10){?> style="color: gold;" <?php }?> > <?php echo $i; ?></div></div>
    </div>
            </a></li>
<?php
$i++;
}
?>
</section>
<div class="flexs"></div>
</div>
<footer>
	<span><span>&#169;</span>2018 QuizBowl</span>
</footer>
</div>
<script type="text/javascript">
	function moreClass(n) {
		$.post(
			"a.php",
			{
				moreclass : document.getElementById('suchen').children.length;
			},
			function(data){
$("#suchen").append(data);
			},

			'text'
		);
	}
var k = 0;
$(document).scroll(function() {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
		k++;
		moreClass(k);
	}
});
</script>
</body>
</html>