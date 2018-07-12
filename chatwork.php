<?php
@session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8mb4', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}



if(isset($_POST['lastmes'])){
$re = $bdd->prepare('SELECT message, sender, sendate, receiverre, type FROM chat WHERE receiver = :receiver ORDER BY mid DESC LIMIT 40');
$re->execute(array(
    'receiver' => $_SESSION['id'],
	));
$i=0;
while ($resulta = $re->fetch()) {
  if($i!=$resulta["sender"]){
	$rea = $bdd->prepare('SELECT id, pseudo, avatarimageurl FROM members WHERE id = :id');
$rea->execute(array(
    'id' => $resulta['sender']
	));
$resultat = $rea->fetch();
if (strlen($resultat['pseudo']) != 0) {
  $y = strtotime("now") - strtotime($resulta['sendate']);
        $monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if($y < 60){
            $r= $y."s";
        }
        else if($y < 3600){
            $r= floor($y/60)."m";
        }
        else if ($y < 86400){
            $r = floor($y/3600)."h";
        }
        else if ($y < 172800){
            $r = "Yesterday";
        }
        else {
            list($year, $month, $day) = array_values(date_parse($resulta['sendate']));
            if(date("Y") == $year){
                if($day == 1){
                    $r = $day."st"." ".$monthNames[$month-1];
                }else if($day == 2){
                    $r = $day."nd"." ".$monthNames[$month-1];
                }else if($day == 3){
                    $r = $day."rd"." ".$monthNames[$month-1];
                }else{
                    $r = $day."th"." ".$monthNames[$month-1];
                }
            }else{
                if($day == 1){
                    $r = $day."st"." ".$monthNames[$month-1]." ".$year;
                }else if($day == 2){
                    $r = $day."nd"." ".$monthNames[$month-1]." ".$year;
                }else if($day == 3){
                    $r = $day."rd"." ".$monthNames[$month-1]." ".$year;
                }else{
                    $r = $day."th"." ".$monthNames[$month-1]." ".$year;
                }
            }
        }
        if($resulta['receiverre']==0){
          $color = "#3e4f65";
        }else{
          $color = "";
        }
?>
<div class="lm" id="ll,<?php echo $resultat['id']; ?>" style="background-color:<?php echo $color;?>;">
      <div style=" height: 52px; width: 52px;">
           <a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>" style="height: 52px; width: 52px;">
               <div id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"></div>
           </a>           
     </div>

<div style="padding: 0px;">
     <h2 id="pseu_next_image" style="font-size: 14px; max-height: 20px; margin: 0; text-align: center;display: inline-block; font-size: 14px;position: relative;left: 25px; overflow: hidden; white-space: nowrap;"><?php echo $resultat['pseudo'];?></h2>

  <div style="overflow-wrap: break-word; width: 440px; max-height: 30px; overflow: hidden; position: relative;top: 0px left:25px; font-size: 14px; line-height: 15px;">
  <?php if($resulta['type']==0 OR $resulta['type']==1){ ?>
  <p style="max-width: 80%;position: relative; left:25px;"><?php echo $resulta['message']; ?></p>
  <?php }else if($resulta['type']==4){ ?>
  <p style="max-width: 80%;position: relative; left:25px;">Audio</p>
  <?php }else if($resulta['type']==3){ ?>
  <p style="max-width: 80%;position: relative; left:25px;">Image</p>
  <?php }else{ ?>
  <p style="max-width: 80%;position: relative; left:25px;">File</p>
  <?php } ?>
  </div></div>

  <span class="sendate"><?php echo $r; ?></span>

</div>
<?php
}
}
$i=$resulta['sender'];
}
$req8888 = $bdd->prepare('UPDATE members SET messageread = :messageread WHERE id = :id');
            $req8888->execute(array(
  'messageread' => 1,
  'id' => $_SESSION['id'],
  ));
}

if (isset($_POST['messageread'])) {
  $req8888 = $bdd->prepare('UPDATE members SET messageread = :messageread WHERE id = :id');
            $req8888->execute(array(
  'messageread' => 1,
  'id' => $_SESSION['id'],
  ));
}

if(isset($_POST['listfriend'])){
  $req4 = $bdd->prepare('SELECT iduser2 FROM amis WHERE iduser1 = :iduser1 AND status = :status ORDER BY idu ASC');
$req4->execute(array(
    'iduser1' => $_SESSION['id'],
    'status' => 1));
$c = 0;
while ($resultat4 = $req4->fetch()) {
  $req = $bdd->prepare('SELECT id, avatarimageurl, pseudo FROM members WHERE id = :id');
$req->execute(array(
    'id' => $resultat4['iduser2']));
$resultat = $req->fetch();

?>

    <div class="usersm">
    <a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>"><div id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"></div></a>
    <h2 id="mm,<?php echo $resultat['id']; ?>" class="user" ><?php echo $resultat['pseudo'];?></h2>
  </div>

<?php
}
$req4->closeCursor();
$req3 = $bdd->prepare('SELECT iduser1 FROM amis WHERE iduser2 = :iduser2 AND status = :status ORDER BY idu ASC');
$req3->execute(array(
    'iduser2' => $_SESSION['id'],
    'status' => 1));

while ($resultat3 = $req3->fetch()) {
  $req = $bdd->prepare('SELECT id, avatarimageurl, pseudo FROM members WHERE id = :id');
$req->execute(array(
    'id' => $resultat3['iduser1']));
$resultat = $req->fetch();
?>

    <div class="usersm">
    <a href="profile.php?pseudo=<?php echo $resultat['pseudo']; ?>"><div id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $resultat['avatarimageurl'];?>);"></div></a>
    <h2 id="mm,<?php echo $resultat['id']; ?>" class="user" ><?php echo $resultat['pseudo'];?></h2>
  </div>
  
<?php
}
$req3->closeCursor();
}



if(isset($_POST['q']) AND strlen($_POST['q']) > 0){
$id = htmlspecialchars($_POST['q']); 
$reqss = $bdd->prepare('SELECT mid FROM chat WHERE (sender = :sender1 AND receiver = :receiver1) OR (sender = :sender2 AND receiver = :receiver2) ORDER BY mid DESC LIMIT 20');
$reqss->execute(array(
    'sender1' => $_SESSION['id'],
    'receiver1' => $id,
    'sender2' => $id,
    'receiver2' => $_SESSION['id']
  ));
$yu = 0;
while($resultatss = $reqss->fetch())
{
$yu = $resultatss['mid'];
}
if ($yu >0) {
$reqss = $bdd->prepare('SELECT message, sendate, sender, type FROM chat WHERE ((sender = :sender1 AND receiver = :receiver1) OR (sender = :sender2 AND receiver = :receiver2)) AND mid >= :mid ORDER BY mid ASC LIMIT 20');
$reqss->execute(array(
    'sender1' => $_SESSION['id'],
    'receiver1' => $id,
    'sender2' => $id,
    'receiver2' => $_SESSION['id'],
    'mid' => $yu
  ));

while($resultatss = $reqss->fetch())
{
  if ($resultatss['type']==0 OR $resultatss['type']==1){
?>
  <div class="showm">
    <?php

$ro = $bdd->prepare('SELECT avatarimageurl FROM members WHERE id = :id');
$ro->execute(array(
    'id' => $resultatss['sender']
  ));
$ris = $ro->fetch();
if ($resultatss['sender'] == $_SESSION['id']) {

  ?> <div class="s1" style="margin-left: 45%;"> 
      <div id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $ris['avatarimageurl'];?>);"></div><?php echo $resultatss['message']; ?> 
     </div> 
<?php
}
else {

  ?> <div class="s2" style="margin-right: 45%;"> 
      <div id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $ris['avatarimageurl'];?>);"></div><?php echo $resultatss['message']; ?> 
     </div> 
<?php
}
?>
  </div>
<?php
}else if($resultatss['type']==4){
  if($resultatss['sender'] == $_SESSION['id']){
  ?>
  <audio controls='true' class='aS au' id="audio,<?php echo $resultatss['message']; ?>" src="<?php echo $resultatss['message']; ?>"></audio>
  <?php
}else{
  ?>
  <audio controls='true' class='aR au' id="audio,<?php echo $resultatss['message']; ?>" src="<?php echo $resultatss['message']; ?>"></audio>
  <?php
}
}else if($resultatss['type']==3){
  if($resultatss['sender'] == $_SESSION['id']){
  ?>
  <img class='aS chatPhoto' src="<?php echo $resultatss['message']; ?>">
  <?php
}else{
  ?>
  <img class='aR chatPhoto' src="<?php echo $resultatss['message']; ?>">
  <?php
}
}else{
  ?>
  <div class="showm">
    <?php

$ro = $bdd->prepare('SELECT avatarimageurl FROM members WHERE id = :id');
$ro->execute(array(
    'id' => $resultatss['sender']
  ));
$ris = $ro->fetch();
if ($resultatss['sender'] == $_SESSION['id']) {

  ?> <div class="s1" style="margin-left: 45%;"> 
      <div id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $ris['avatarimageurl'];?>);"></div><a target="_blank" style="color: blue;" href="<?php echo $resultatss['message']; ?>">File</a></div> 
<?php
}
else {

  ?> <div class="s2" style="margin-right: 45%;"> 
      <div id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $ris['avatarimageurl'];?>);"></div><a target="_blank" style="color: blue;" href="<?php echo $resultatss['message']; ?>">File</a></div> 
<?php
}
?>
  </div>
<?php
}
}
$reqss->closeCursor();
}
$req8888 = $bdd->prepare('UPDATE chat SET receiverre = :receiverre WHERE sender = :sender AND receiver = :receiver');
            $req8888->execute(array(
  'receiverre' => 1,
  'sender'=> $id,
  'receiver' => $_SESSION['id'],
  ));
}




if(isset($_POST['recu'])  AND strlen($_POST['recu']) > 0){
$id = htmlspecialchars($_POST['recu']); 

$req8888 = $bdd->prepare('UPDATE chat SET receiverre = :receiverre WHERE sender = :sender AND receiver = :receiver');
            $req8888->execute(array(
  'receiverre' => 1,
  'sender'=> $id,
  'receiver' => $_SESSION['id'],
  ));

}

if (isset($_POST['news'])) {
 $rea = $bdd->prepare('SELECT messageread FROM members WHERE id = :id');
$rea->execute(array(
    'id' => $_SESSION['id']
  ));
$re = $rea->fetch();
if($re['messageread']==0){
$req = $bdd->prepare('SELECT mid FROM chat WHERE receiver = :receiver AND receiverre = :receiverre');
$req->execute(array(
    'receiver' => $_SESSION['id'],
    'receiverre' => 0));
$resultat = $req->fetch();
if($resultat){
  echo 5;
}else{
  echo 0;
}
}else{
  echo 0;
}
}

if (isset($_POST['Okoi'])) {
  $imageId = htmlspecialchars($_POST['Okoi']);
  $ro = $bdd->prepare('SELECT avatarimageurl FROM members WHERE id = :id');
$ro->execute(array(
    'id' => $imageId
  ));
$ris = $ro->fetch();
echo $ris['avatarimageurl'];
}




?>
