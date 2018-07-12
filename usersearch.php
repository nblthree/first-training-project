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
if (isset($_POST['us']) AND strlen($_POST['us']) != 0) {
	$us = htmlspecialchars($_POST['us']);
	$req = $bdd->query('SELECT pseudo, avatarimageurl FROM members');

$r = 0;
$limit = 0;
while ($resultat = $req->fetch()) {
	

if (stripos($resultat['pseudo'], $us) === 0 && $limit<12) { // Si la valeur commence par les mêmes caractères que la recherche
	$limit++;
	        ?>
	        <li><a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>"><div class="cfkk" style="display: flex;">
	<div class='randomavatar' >
	    <div id="randomimage">
<span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"></span></div>
	<span style="line-height: 60px; margin-left: 10px; font-weight: 600; color: #fff;"><?php echo $resultat['pseudo']; ?></span>	
    </div>
</div></a></li>
	        <?php
	$r++;
	    }




}
if ($r == 0) {
	?>
	<li><div id="cfkk" style="display: flex;">
	<span style="line-height: 60px; margin-left: 10px; color: #fff;">No results</span>	
    </div></li>
<?php
}
}
?>