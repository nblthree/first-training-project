<?php
@session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}



if(isset($_POST['allFriends']) && isset($_POST['width'])){
$p = htmlspecialchars($_POST['allFriends']);
$w = htmlspecialchars($_POST['width']);
if($w >= 800){
$req3 = $bdd->prepare('SELECT iduser1, iduser2 FROM amis WHERE (iduser2 = :iduser2 OR iduser1 = :iduser1) AND status = :status');
$req3->execute(array(
    'iduser2' => $p,
    'iduser1' => $p,
    'status' => 1));
while ($resultat3 = $req3->fetch()) {
	if($resultat3['iduser1']==$p){
		$id =$resultat3['iduser2'];
	}else{
		$id =$resultat3['iduser1'];
	}
	$req = $bdd->prepare('SELECT avatarimageurl, pseudo, large, bio FROM members WHERE id = :id');
$req->execute(array(
    'id' => $id));
$resultat = $req->fetch();
?>

    <div class="newavatar" id="block,<?php echo $id;?>">
    <a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>"><div class="backlarge" style="background-image: url(profilesimages/<?php echo $resultat['large'];?>);"></div></a>
		<div class="mainimage" style="background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"><a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>"></a></div>
		<div class="friendPseudo"><p><?php echo $resultat['pseudo'];?></p><?php if($p==$_SESSION['id']){ ?><button class="eleminer" id="un,<?php echo $id;?>">Unfriend</button><?php } ?></div>
		<div class="friendBio"><p><?php echo $resultat['bio'];?></p></div>
	</div>	
<?php
}
}else{
	$req3 = $bdd->prepare('SELECT iduser1, iduser2 FROM amis WHERE (iduser2 = :iduser2 OR iduser1 = :iduser1) AND status = :status');
$req3->execute(array(
    'iduser2' => $p,
    'iduser1' => $p,
    'status' => 1));
while ($resultat3 = $req3->fetch()) {
	if($resultat3['iduser1']==$p){
		$id =$resultat3['iduser2'];
	}else{
		$id =$resultat3['iduser1'];
	}
	$req = $bdd->prepare('SELECT avatarimageurl, pseudo FROM members WHERE id = :id');
$req->execute(array(
    'id' => $id));
$resultat = $req->fetch();
?>

    <div class="newavatar" id="block,<?php echo $id;?>" style="width: 100%; height: 60px; display: flex;">
		<div class="mainimage" style="min-width: 60px; min-height: 60px; bottom: 0; left: 0; margin: auto 0; background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"><a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>"></a></div>
		<div class="friendPseudo" style="margin: auto 10px; left: 0; top: 0; width: 90%;"><p><?php echo $resultat['pseudo'];?></p><?php if($p==$_SESSION['id']){ ?><button style="max-width: 80px;" class="eleminer" id="un,<?php echo $id;?>">Unfriend</button><?php } ?></div>
	</div>	
<?php
}
}
}



if(isset($_POST['fm'])){

	$req3 = $bdd->prepare('SELECT iduser1, iduser2 FROM amis WHERE (iduser2 = :iduser2 OR iduser1 = :iduser1) AND status = :status');
$req3->execute(array(
    'iduser2' => $_SESSION['id'],
    'iduser1' => $_SESSION['id'],
    'status' => 1));
while ($resultat3 = $req3->fetch()) {
	if($resultat3['iduser1'] == $_SESSION['id']){
		$id = $resultat3['iduser2'];
	}else{
		$id = $resultat3['iduser1'];
	}
	$req = $bdd->prepare('SELECT avatarimageurl, pseudo FROM members WHERE id = :id');
$req->execute(array(
    'id' => $id));
$resultat = $req->fetch();
?>

    <div class="newavatar bit" id="block,<?php echo $id;?>" style="width: 100%; height: 60px; display: flex;">
		<div class="mainimage" style="min-width: 60px; min-height: 60px; bottom: 0; left: 0; margin: auto 0; background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"><a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>"></a></div>
		<div class="friendPseudo" style="margin: auto 10px; left: 0; top: 0; width: 90%;"><p><?php echo $resultat['pseudo'];?></p></div>
	</div>	
<?php
}

}
?>

