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
if(isset($_POST['morefriend'])){
	$i=5;
$req1 = $bdd->prepare('SELECT iduser1, iduser2 FROM amis WHERE (iduser2 = :iduser2 OR iduser1 = :iduser1) AND status = :status AND user1_to_user2 = :user1_to_user2 AND user2_to_user1 = :user2_to_user1 ORDER BY RAND() LIMIT 5');
$req1->execute(array(
    'iduser2' => $_SESSION['id'],
    'iduser1' => $_SESSION['id'],
    'status' => 0,
    'user1_to_user2' => 0,
    'user2_to_user1' => 0));


while ($resultat1 = $req1->fetch()) {
	if($resultat1['iduser1']==$_SESSION['id']){
		$id= $resultat1['iduser2'];
	}
	else{
		$id= $resultat1['iduser1'];
	}
$req = $bdd->prepare('SELECT avatarimageurl, pseudo FROM members WHERE id = :id');
$req->execute(array(
    'id' => $id));
$resultat0 = $req->fetch();
	?>
	<div class="rf">
	<div class="hazardFriend" id='randomavatar<?php echo $id; ?>' style='width: 80%; height: 52px; display: flex;'>
	<div id="randomimage">
			<a href="profile.php?pseudo=<?php echo $resultat0['pseudo']; ?>"><span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat0['avatarimageurl']?>);"></span></a>
		</div>
		<span style="line-height: 54px; margin-left: 10px; width: 150px; overflow: hidden;"><?php echo $resultat0['pseudo']; ?></span>
			
			</div>
			<button class="ad" id="<?php echo $id; ?>">Add</button>
	</div>		

			<?php

}
}

if(isset($_POST['muchmorefriend'])){
$data = explode(",", htmlspecialchars($_POST['muchmorefriend']));
for ($i=0; $i < sizeof($data); $i++) { 
	$data[$i] = intval($data[$i]); 
}
$req1 = $bdd->prepare('SELECT iduser1, iduser2 FROM amis WHERE (iduser1 = :iduser1 OR iduser2 = :iduser2) AND status = :status AND user1_to_user2 = :user1_to_user2 AND user2_to_user1 = :user2_to_user1 ORDER BY RAND() LIMIT 1');
$req1->execute(array(
    'iduser1' => $_SESSION['id'],
    'iduser2' => $_SESSION['id'],
    'status' => 0,
    'user1_to_user2' => 0,
    'user2_to_user1' => 0));


while ($resultat1 = $req1->fetch()) {
	if($resultat1['iduser1']==$_SESSION['id']){
		$id= intval($resultat1['iduser2']);
	}
	else{
		$id= intval($resultat1['iduser1']);
	}
	if(isset($id) AND !in_array($id, $data)){
$req = $bdd->prepare('SELECT avatarimageurl, pseudo FROM members WHERE id = :id');
$req->execute(array(
    'id' => $id));
$resultat0 = $req->fetch();
	?>
	<div class="rf">
	<div class="hazardFriend" id='randomavatar<?php echo $id; ?>' style='width: 80%; height: 52px; display: flex;'>
	<div id="randomimage">
			<a href="profile.php?pseudo=<?php echo $resultat0['pseudo']; ?>"><span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat0['avatarimageurl']?>);"></span></a>
		</div>
		<span style="line-height: 54px; margin-left: 10px; width: 150px; overflow: hidden;"><?php echo $resultat0['pseudo']; ?></span>
			
			</div>
			<button class="ad" id="<?php echo $id; ?>">Add</button>
	</div>		

			<?php
}
}
}
?>