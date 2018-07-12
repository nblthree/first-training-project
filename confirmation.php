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


if (isset($_GET['token']) AND isset($_GET['ps'])) {
	$token = htmlspecialchars($_GET['token']);
	$ps = htmlspecialchars($_GET['ps']);
	
$req = $bdd->prepare('SELECT pseudo, email, pass, birthdate, country FROM verifcation WHERE pseudo = :pseudo AND code = :code');
$req->execute(array(
    'pseudo' => $ps,
    'code' => $token));
$resultat2 = $req->fetch();
if($resultat2){

$avatar_defaut = "avatar_defaut.jpg";
$pseudo = $resultat2['pseudo'];
$email = $resultat2['email'];
$passhash = $resultat2['pass'];
$birthdate = $resultat2['birthdate'];
$country = $resultat2['country'];


	$req = $bdd->prepare('INSERT INTO members(pseudo, email, pass, birthdate, signup_date, country, avatarimageurl) VALUES(:pseudo, :email, :pass, :birthdate, NOW(), :country, :avatarimageurl)');
$req->execute(array(
	'pseudo' => $pseudo,
	'email' => $email,
	'pass' => $passhash,
	'birthdate' => $birthdate,
	'country' => $country,
    'avatarimageurl' => $avatar_defaut,
	));
$req = $bdd->prepare('SELECT id, avatarimageurl, bio, studying_level, profession, birthdate, country, large FROM members WHERE pseudo = :pseudo AND pass = :pass');
$req->execute(array(
    'pseudo' => $pseudo,
    'pass' => $passhash));

$resultat = $req->fetch();
    session_start();
    $_SESSION['id'] = $resultat['id'];
    $_SESSION['pseudo'] = $pseudo;
    $_SESSION['avatarimageurl'] = $resultat['avatarimageurl'];
    $_SESSION['bio'] = $resultat['bio'];
    $_SESSION['studying_level'] = $resultat['studying_level'];
    $_SESSION['profession'] = $resultat['profession'];
    $_SESSION['birthdate'] = $resultat['birthdate'];
    $_SESSION['country'] = $resultat['country'];
    $_SESSION['large'] = $resultat['large'];
$reponse = $bdd->query('SELECT id FROM members');
while ($donnees = $reponse->fetch()) {
    if($donnees['id'] != $_SESSION['id']){
        $req = $bdd->prepare('INSERT INTO amis(iduser1, iduser2) VALUES(:iduser1, :iduser2)');
$req->execute(array(
    'iduser1' => $_SESSION['id'],
    'iduser2' => $donnees['id']
    ));
}
}
$reponse->closeCursor();

$req = $bdd->prepare('DELETE from FROM verifcation WHERE pseudo = :pseudo AND code = :code');
$req->execute(array(
    'pseudo' => $ps,
    'code' => $token));

header("Location:profile.php?pseudo=".urlencode($_SESSION['pseudo']));


}else{
	header('This link is not working anymore', true, 404);
   include('error.html');
   exit();
}



}else{
    header('This link is not working anymore', true, 404);
   include('error.html');
   exit();
}












?>