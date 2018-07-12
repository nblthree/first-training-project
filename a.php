<?php
session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

if (isset($_POST['ok'])) {
	$p = htmlspecialchars($_POST['ok']);
	if ($_SESSION['id'] < $_POST['ok']) {	
$req = $bdd->prepare('UPDATE amis SET user2_to_user1 = :user2_to_user1 WHERE iduser1 = :iduser1 AND iduser2 = :iduser2');
$req->execute(array(
	'user2_to_user1' => 1,
	'iduser1' => $p,
	'iduser2' => $_SESSION['id']
	));
}
if ($_SESSION['id'] > $_POST['ok']) {
			$req = $bdd->prepare('UPDATE amis SET user1_to_user2 = :user1_to_user2 WHERE iduser2 = :iduser2 AND iduser1 = :iduser1');
            $req->execute(array(
	'user1_to_user2' => 1,
	'iduser1' => $_SESSION['id'],
	'iduser2' => $p
	));
        }
          echo "654";
}

if (isset($_POST['bien'])) {
	$pp = htmlspecialchars($_POST['bien']);
			$req = $bdd->prepare('UPDATE amis SET status = :status WHERE iduser1 = :iduser1 AND iduser2 = :iduser2');
            $req->execute(array(
	'status' => 0,
	'iduser1' => $_SESSION['id'],
	'iduser2' => $pp
	));

    $requy = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND friend = :friend');
    $requy->execute(array(
        'Id'=> $id,
        'Id_macher' => $_SESSION['id'],
        'friend' => 1));
    $requy = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND friend = :friend');
    $requy->execute(array(
        'Id_macher'=> $id,
        'Id' => $_SESSION['id'],
        'friend' => 1));
            echo "666";
}

if (isset($_POST['good'])) {
	$ppp=htmlspecialchars($_POST['good']);
			$req = $bdd->prepare('UPDATE amis SET status = :status WHERE iduser1 = :iduser1 AND iduser2 = :iduser2');
            $req->execute(array(
	'status' => 0,
	'iduser2' => $_SESSION['id'],
	'iduser1' => $ppp
	));

    $requy = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND friend = :friend');
    $requy->execute(array(
        'Id'=> $id,
        'Id_macher' => $_SESSION['id'],
        'friend' => 1));
    $requy = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND friend = :friend');
    $requy->execute(array(
        'Id_macher'=> $id,
        'Id' => $_SESSION['id'],
        'friend' => 1));
            echo "471";
}



if (isset($_POST['snj'])) {
	$pppp= htmlspecialchars($_POST['snj']);
       if ($_SESSION['id'] > $pppp) {
			$req = $bdd->prepare('UPDATE amis SET status = :status, user2_to_user1 = :user2_to_user1 WHERE iduser1 = :iduser1 AND iduser2 = :iduser2');
            $req->execute(array(
	'status' => 1,
	'user2_to_user1' => 0,
	'iduser1' => $_SESSION['id'],
	'iduser2' => $pppp
	));
        }      
       if ($_SESSION['id'] < $pppp) {
            $req = $bdd->prepare('UPDATE amis SET status = :status, user1_to_user2 = :user1_to_user2 WHERE iduser1 = :iduser1 AND iduser2 = :iduser2');
            $req->execute(array(
	'status' => 1,
	'user1_to_user2' => 0,
	'iduser2' => $_SESSION['id'],
	'iduser1' => $pppp
	));
        }

    $reqd = $bdd->prepare('INSERT INTO notification(Id, Id_macher, friend) VALUES(:Id, :Id_macher, :friend)');
    $reqd->execute(array(
        'Id'=> $pppp,
        'Id_macher' => $_SESSION['id'],
        'friend' => 1));

    $reqd = $bdd->prepare('INSERT INTO notification(Id, Id_macher, friend) VALUES(:Id, :Id_macher, :friend)');
    $reqd->execute(array(
        'Id_macher'=> $pppp,
        'Id' => $_SESSION['id'],
        'friend' => 1));

            echo "55";
}


if (isset($_POST['snjr'])) {
$oo=htmlspecialchars($_POST['snjr']);
	if ($_SESSION['id'] > $_POST['snjr']) {
			$req = $bdd->prepare('UPDATE amis SET user2_to_user1 = :user2_to_user1 WHERE iduser1 = :iduser1 AND iduser2 = :iduser2');
            $req->execute(array(
	'user2_to_user1' => 0,
	'iduser1' => $_SESSION['id'],
	'iduser2' => $oo
	));
}
    if ($_SESSION['id'] < $_POST['snjr']) {
    		$req = $bdd->prepare('UPDATE amis SET user1_to_user2 = :user1_to_user2 WHERE iduser1 = :iduser1 AND iduser2 = :iduser2');
            $req->execute(array(
	'user1_to_user2' => 0,
	'iduser1' => $oo,
	'iduser2' => $_SESSION['id']
	));
}  
            echo "555";

}




if (isset($_POST['unfriend'])) {
	$id= htmlspecialchars($_POST['unfriend']);
			$req = $bdd->prepare('UPDATE amis SET status = :status WHERE (iduser1 = :iduser11 AND iduser2 = :iduser21) OR (iduser1 = :iduser12 AND iduser2 = :iduser22)');
            $req->execute(array(
	'status' => 0,
	'iduser11' => $_SESSION['id'],
	'iduser21' => $id,
	'iduser12' => $id,
	'iduser22' => $_SESSION['id']
	));

    $requy = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND friend = :friend');
    $requy->execute(array(
        'Id'=> $id,
        'Id_macher' => $_SESSION['id'],
        'friend' => 1));
    $requy = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND friend = :friend');
    $requy->execute(array(
        'Id_macher'=> $id,
        'Id' => $_SESSION['id'],
        'friend' => 1));

            echo "4971";
}

if (isset($_POST['friendOrNot'])) {
	$id= htmlspecialchars($_POST['friendOrNot']);
	$req288 = $bdd->prepare('SELECT iduser1, iduser2 FROM amis WHERE status = :status AND ((iduser1 = :iduser11 AND iduser2 = :iduser21) OR (iduser1 = :iduser12 AND iduser2 = :iduser22))');
$req288->execute(array(
    'status' => 1,
    'iduser11' => $_SESSION['id'],
    'iduser21' => $id,
    'iduser12' => $id,
    'iduser22' => $_SESSION['id']));
$resultat = $req288->fetch();
if($resultat){
	echo "1";
}else{
	$req = $bdd->prepare('SELECT iduser1, iduser2 FROM amis WHERE status = :status AND user1_to_user2 = :user1_to_user2 AND ((iduser1 = :iduser11 AND iduser2 = :iduser21) OR (iduser1 = :iduser12 AND iduser2 = :iduser22))');
$req->execute(array(
    'status' => 0,
    'user1_to_user2' => 1,
    'iduser11' => $_SESSION['id'],
    'iduser21' => $id,
    'iduser12' => $id,
    'iduser22' => $_SESSION['id']));
$resultat2 = $req->fetch();
if($resultat2){
	if($_SESSION['id'] < $id){
	    echo "accept";
    }else{
    	echo "cancel";
    }
}else{
	$req = $bdd->prepare('SELECT iduser1, iduser2 FROM amis WHERE status = :status AND user2_to_user1 = :user2_to_user1 AND ((iduser1 = :iduser11 AND iduser2 = :iduser21) OR (iduser1 = :iduser12 AND iduser2 = :iduser22))');
$req->execute(array(
    'status' => 0,
    'user2_to_user1' => 1,
    'iduser11' => $_SESSION['id'],
    'iduser21' => $id,
    'iduser12' => $id,
    'iduser22' => $_SESSION['id']));
$resultat3 = $req->fetch();
   if ($resultat3) {
   	if($_SESSION['id'] < $id){
	    echo "cancel";
    }else{
    	echo "accept";
    }
   }else{
   	echo "0";
   }
}
}
}

if(isset($_POST['cancel'])){
	$cancel = htmlspecialchars($_POST['cancel']);
	if ($_SESSION['id'] < $cancel) {	
$req = $bdd->prepare('UPDATE amis SET user2_to_user1 = :user2_to_user1 WHERE iduser1 = :iduser1 AND iduser2 = :iduser2');
$req->execute(array(
	'user2_to_user1' => 0,
	'iduser1' => $cancel,
	'iduser2' => $_SESSION['id']
	));
}
if ($_SESSION['id'] > $cancel) {
			$req = $bdd->prepare('UPDATE amis SET user1_to_user2 = :user1_to_user2 WHERE iduser2 = :iduser2 AND iduser1 = :iduser1');
            $req->execute(array(
	'user1_to_user2' => 0,
	'iduser1' => $_SESSION['id'],
	'iduser2' => $cancel
	));
        }
        echo "777";
}


if(isset($_POST['invi'])){
$req1 = $bdd->prepare('SELECT iduser2 FROM amis WHERE iduser1 = :iduser1 AND status = :status AND user2_to_user1 = :user2_to_user1');
$req1->execute(array(
    'iduser1' => $_SESSION['id'],
    'status' => 0,
    'user2_to_user1' => 1));
while ($resultat1 = $req1->fetch()) {
	$req = $bdd->prepare('SELECT avatarimageurl, pseudo FROM members WHERE id = :id');
$req->execute(array(
    'id' => $resultat1['iduser2']));
$resultat0 = $req->fetch();
	?>

		<div class="fq" id='friendquest<?php echo $resultat1['iduser2']; ?>'>
		<div class='fqChild'>
	      <div id="randomimage">
			<a href="profile.php?pseudo=<?php echo $resultat0['pseudo']; ?>" id="haha"><span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat0['avatarimageurl']?>);"></span></a>
		  </div>
<p style="margin: auto 10px;"><?php echo $resultat0['pseudo']; ?></p>
		  </div>
		  <div class="flei">
			<button class="accepte" id="<?php echo $resultat1['iduser2']; ?>">Accepte</button>
			<button class="refuse" id="<?php echo $resultat1['iduser2']; ?>">Refuse</button>
		  </div>
		</div>

	<?php
}
$req1 = $bdd->prepare('SELECT iduser1 FROM amis WHERE iduser2 = :iduser1 AND status = :status AND user1_to_user2 = :user2_to_user1');
$req1->execute(array(
    'iduser1' => $_SESSION['id'],
    'status' => 0,
    'user2_to_user1' => 1));
while ($resultat1 = $req1->fetch()) {
	$req = $bdd->prepare('SELECT avatarimageurl, pseudo FROM members WHERE id = :id');
$req->execute(array(
    'id' => $resultat1['iduser1']));
$resultat0 = $req->fetch();
	?>

		<div class="fq" id='friendquest<?php echo $resultat1['iduser1']; ?>'>
		<div class='fqChild'>
	      <div id="randomimage">
			<a href="profile.php?pseudo=<?php echo $resultat0['pseudo']; ?>" id="haha"><span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat0['avatarimageurl']?>);"></span></a>
		  </div>
		  <p style="margin: auto 10px;"><?php echo $resultat0['pseudo']; ?></p>
		  </div>
		  <div class="flei">
			<button class="accepte" id="<?php echo $resultat1['iduser1']; ?>">Accepte</button>
			<button class="refuse" id="<?php echo $resultat1['iduser1']; ?>">Refuse</button>
		  </div>
		</div>
	<?php
}
}










if(isset($_POST['moreclass'])){
	$n = htmlspecialchars($_POST['moreclass']) / 500;
	if($n > 0 AND is_int($n)){
		for ($i=0; $i <= $n; $i++) { 
			$e = $i;
		}
		$e = 500 * $e + 500;
		$req = $bdd->query("SELECT pseudo, avatarimageurl FROM members ORDER BY nm DESC limit ".$e);
		$i = 1;
		$e = $e - 500;
		while($resultat = $req->fetch()){
			if($i > $e){
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
		}
	}
}
?>