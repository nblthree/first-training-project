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



function amies($inviter)
{
    $rer = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
    $rer->execute(array(
        'id' => $inviter));
    $r = $rer->fetch();
    $array = [$inviter, $r['pseudo'], $r['avatarimageurl']];

    $req4 = $bdd->prepare('SELECT iduser2, iduser1 FROM amis WHERE (iduser1 = :iduser1 OR iduser2 = :iduser2) AND status = :status');
    $req4->execute(array(
        'iduser1' => $inviter,
        'iduser2' => $inviter,
        'status' => 1));
    while ($resultat = $req4->fetch()) {
        if($inviter == $resultat['iduser1']){
            $amie = $resultat['iduser2'];
        }else{
            $amie = $resultat['iduser1'];
        }if($amie != $_SESSION['id']){
            array_push($array, $amie);
        }
    }

    $array2 = [$_SESSION['id'], $_SESSION['pseudo'], $_SESSION['avatarimageurl']];

    $req4 = $bdd->prepare('SELECT iduser2, iduser1 FROM amis WHERE (iduser1 = :iduser1 OR iduser2 = :iduser2) AND status = :status');
    $req4->execute(array(
        'iduser1' => $_SESSION['id'],
        'iduser2' => $_SESSION['id'],
        'status' => 1));
    while ($resultat = $req4->fetch()) {
        if($_SESSION['id'] == $resultat['iduser1']){
            $amie = $resultat['iduser2'];
        }else{
            $amie = $resultat['iduser1'];
        }if($amie != $inviter){
            array_push($array2, $amie);
        }
    }
    return [$array, $array2];
}




if(isset($_POST['flist'])){
    $sender = htmlspecialchars($_POST['flist']);
    $req188 = $bdd->prepare('SELECT iduser2, iduser1 FROM amis WHERE status = :status AND iduser1 = :iduser1 OR iduser2 = :iduser2');
    $req188->execute(array(
        'status' => 1,
        'iduser1' => $sender,
        'iduser2'=> $sender));
    $array = [];
    while ($donnees188 = $req188->fetch()) {
        if ($donnees188['iduser1'] != $sender) {
            array_push($array, $donnees188['iduser1']);
        }else{
            array_push($array, $donnees188['iduser2']);
        }
    }
    echo json_encode($array);
}


if(isset($_POST['flist_plus_data'])){
    $sender = htmlspecialchars($_POST['flist_plus_data']);
    $req188 = $bdd->prepare('SELECT iduser2, iduser1 FROM amis WHERE status = :status AND iduser1 = :iduser1 OR iduser2 = :iduser2');
    $req188->execute(array(
        'status' => 1,
        'iduser1' => $sender,
        'iduser2'=> $sender));
    $array = [];
    while ($donnees188 = $req188->fetch()) {
        if ($donnees188['iduser1'] != $sender) {
            $amie = $donnees188['iduser1'];
        }else{
            $amie = $donnees188['iduser2'];
        }
        $reqf188 = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE chessinvitation = :chessinvitation AND id = :id');
        $reqf188->execute(array(
            'chessinvitation' => 0,
            'id' => $amie));
        $d = $reqf188->fetch();
        array_push($array, [$amie, $d['pseudo'], $d['avatarimageurl']]);
    }
    echo json_encode($array);
}

if(isset($_POST['to_zero'])){
    $req = $bdd->prepare('SELECT chessinvitation, pseudo FROM members WHERE id = :id');
    $req->execute(array(
        'id' => $sender));
    $donnees = $req->fetch();
    
    $reqt = $bdd->prepare('SELECT id FROM members WHERE chessinvitation = :chessinvitation AND chessinvitation != :chessinvitation2');
    $reqt->execute(array(
        'chessinvitation' => $donnees['chessinvitation'],
        'chessinvitation2' => 0));

    while($donneest = $reqt->fetch()){
        if($donneest['id'] != $sender){
            $gegener = $donneest['id'];
        }
        $req8888 = $bdd->prepare('UPDATE members SET chessinvitation = :chessinvitation WHERE id = :id');
        $req8888->execute(array(
            'chessinvitation' => 0,
            'id' => $donneest['id'],
        ));
    }  
}

if(isset($_POST['inviter']) AND isset($_POST['temps'])){
    $inviter = htmlspecialchars($_POST['inviter']);
    $temps = htmlspecialchars($_POST['temps']);
    
    $req8 = $bdd->prepare('UPDATE members SET chessinvitation = :chessinvitation, timeset = :timeset WHERE id = :id OR id = :id2');
    $req8->execute(array(
        'chessinvitation' => $_SESSION['id'],
        'timeset' => $temps,
        'id' => $_SESSION['id'],
        'id2' => $inviter
    ));
}


if (isset($_POST['whattime'])) {
	$req = $bdd->prepare('SELECT timeset FROM members WHERE id = :id');
    $req->execute(array(
        'id' => $_SESSION['id']));
    $donnees = $req->fetch();
    echo $donnees['timeset'];
}

if(isset($_POST['se'])){
    $requy8764 = $bdd->prepare('SELECT chessinvitation, id, pseudo FROM members WHERE id = :id OR chessinvitation = :chessinvitation');
    $requy8764->execute(array(
        'id' => $_SESSION['id'],
        'chessinvitation' => $_SESSION['id']));
    $calc=0;
    while ($donneestp = $requy8764->fetch()) {
       $calc++;
    }
    if($calc==2){
        $requy87 = $bdd->prepare('SELECT id, pseudo FROM members WHERE id != :id AND chessinvitation = :chessinvitation');
        $requy87->execute(array(
          'id' => $_SESSION['id'],
          'chessinvitation' => $_SESSION['id']));

        $donneest = $requy87->fetch();
            $_SESSION['gegener'] = $donneest['id'];
            $_SESSION['pgegener'] = $donneest['pseudo'];
            $_SESSION['color'] = "b";
    }else{
        $requy87 = $bdd->prepare('SELECT id, chessinvitation FROM members WHERE id = :id');
        $requy87->execute(array(
          'id' => $_SESSION['id']));

        $donneest = $requy87->fetch();
        $_SESSION['gegener'] = $donneest['chessinvitation'];
        $_SESSION['color'] = "w";
        $rev = $bdd->prepare('SELECT pseudo FROM members WHERE id = :id');
        $rev->execute(array(
            'id' => $_SESSION['gegener']));
        $dev = $rev->fetch();
        $_SESSION['pgegener'] = $dev['pseudo'];
    }
}


if (isset($_POST['connected'])) {
    $req = $bdd->prepare('SELECT chessinvitation FROM members WHERE id = :id');
    $req->execute(array(
        'id' => $_SESSION['id']));
    $donnees = $req->fetch();
    $reqt = $bdd->prepare('SELECT id FROM members WHERE chessinvitation = :chessinvitation AND chessinvitation != :chessinvitation2');
    $reqt->execute(array(
        'chessinvitation' => $donnees['chessinvitation'],
        'chessinvitation2' => 0));

    $ni =0;
    while($donneest = $reqt->fetch()){
        $ni++;
    }
    if($ni != 2){
        echo "not";
    }
}



if (isset($_POST["ann"])) {
	$invitation=htmlspecialchars($_POST["ann"]);
    $inviter=htmlspecialchars($_POST["inviter"]);
  	$req8888 = $bdd->prepare('UPDATE members SET chessinvitation = :chessinvitation WHERE id = :id OR id = :id2');
    $req8888->execute(array(
        'chessinvitation' => 0,
        'id' => $invitation,
        'id2' => $_SESSION['id']
    ));

    echo json_encode(amies($inviter));
}

if (isset($_POST["annll"])) {
  	$req8888 = $bdd->prepare('UPDATE members SET chessinvitation = :chessinvitation0 WHERE chessinvitation = :chessinvitation');
    $req8888->execute(array(
        'chessinvitation0' => 0,
        'chessinvitation' => $_SESSION['id']
    ));
    if(isset($_POST['inviter'])){
        $inviter = htmlspecialchars($_POST['inviter']);
        echo json_encode(amies($inviter));
    }
}




if (isset($_POST['non'])) {
    $inviteur = htmlspecialchars($_POST['inviteur']);
	$req = $bdd->prepare('SELECT chessinvitation FROM members WHERE id = :id');
    $req->execute(array(
        'id' => $_SESSION['id']));
    $donnees = $req->fetch();

    $req8888 = $bdd->prepare('UPDATE members SET chessinvitation  = :chessinvitation  WHERE id = :id OR id = :id2');
    $req8888->execute(array(
        'chessinvitation' => 0,
        'id' => $_SESSION['id'],
        'id2' => $donnees['chessinvitation']
    ));

    echo json_encode(amies($inviteur));
}


if (isset($_POST['who'])) {
	$req = $bdd->prepare('SELECT chessinvitation FROM members WHERE id = :id');
    $req->execute(array(
        'id' => $_SESSION['id']));
    $donnees = $req->fetch();
    if ($donnees['chessinvitation']==$_SESSION['id']) {
        echo "b";
    }
    else{
        echo "w";
    }
}




if (isset($_POST['lost'])) {
	$lost=htmlspecialchars($_POST['lost']);
	
    $requy87 = $bdd->prepare('SELECT chessinvitation FROM members WHERE id = :id');
    $requy87->execute(array(
        'id' => $_SESSION['id']));
    $donneest = $requy87->fetch(); 
    if($_SESSION['id'] != $donneest['chessinvitation']){
        $inviteur = $_SESSION['gegener'];
        $accepteur = $_SESSION['id'];
    }else{
        $inviteur = $_SESSION['id'];
        $accepteur = $_SESSION['gegener'];
    }

	if ($lost=="b") {
        $reqd = $bdd->prepare('INSERT INTO wins(gewinner, gegner) VALUES(:gewinner, :gegner)');
        $reqd->execute(array(
            'gewinner' => $accepteur,
            'gegner' => $inviteur,
        ));
        $requy99nm = $bdd->prepare('SELECT nm FROM members WHERE id = :id');
        $requy99nm->execute(array(
            'id' => $accepteur,
        ));
        $donneest99nm = $requy99nm->fetch();
        $ui = $donneest99nm['nm']+1;
        $req8888 = $bdd->prepare('UPDATE members SET nm = :nm WHERE id = :id');
        $req8888->execute(array(
            'nm' => $ui,     
            'id' => $accepteur,
        ));
        $req8888 = $bdd->prepare('UPDATE members SET chessinvitation = :chessinvitation WHERE chessinvitation = :chessinvitation2');
        $req8888->execute(array(
            'chessinvitation' =>  0,
            'chessinvitation2' => $inviteur
        ));
	}
    else if ($lost=="w") {
        $reqd = $bdd->prepare('INSERT INTO wins(gewinner, gegner) VALUES(:gewinner, :gegner)');
        $reqd->execute(array(
            'gewinner' => $inviteur,
            'gegner' => $accepteur,
        ));
        $requy99nm = $bdd->prepare('SELECT nm FROM members WHERE id = :id');
        $requy99nm->execute(array(
            'id' => $inviteur
        ));
        $donneest99nm = $requy99nm->fetch();
        $ui = $donneest99nm['nm']+1;
        $req8888 = $bdd->prepare('UPDATE members SET nm = :nm WHERE id = :id');
        $req8888->execute(array(
            'nm' => $ui,     
            'id' => $inviteur
        ));
        $req8888 = $bdd->prepare('UPDATE members SET chessinvitation = :chessinvitation WHERE chessinvitation = :chessinvitation2');
        $req8888->execute(array(
            'chessinvitation' =>  0,        	
            'chessinvitation2' => $inviteur
        ));
	}

}




if (isset($_POST['matchend'])) {
	$requy99 = $bdd->prepare('SELECT gewinner FROM wins WHERE (gewinner = :gewinner OR gegner = :gegner) AND UNIX_TIMESTAMP(winnerdate) >= (UNIX_TIMESTAMP() - 10) ORDER BY winid DESC LIMIT 1');
$requy99->execute(array(
    'gewinner' => $_SESSION['id'],
    'gegner' => $_SESSION['id'],
    ));
$donneest99 = $requy99->fetch();
if ($donneest99) {
    $requy = $bdd->prepare('SELECT pseudo FROM members WHERE id = :id');
$requy->execute(array(
    'id' => $donneest99['gewinner'],
    ));
$donneest = $requy->fetch();
	echo "The winner is ".$donneest['pseudo'];
}
}




if(isset($_POST['yes_play'])){
    $inviteur = $_SESSION['gegener'];
    $req8888 = $bdd->prepare('UPDATE members SET chessinvitation = :chessinvitation WHERE id = :id OR id = :id2');
    $req8888->execute(array(
        'chessinvitation' => $inviteur,
        'id' =>  $inviteur,            
        'id2' => $_SESSION['id']
    ));
}






?>
