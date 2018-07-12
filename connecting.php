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
if(isset($_POST['pmail']) AND isset($_POST['pass'])){
$pmail = trim(htmlspecialchars($_POST['pmail']));
$pass = htmlspecialchars($_POST['pass']);

$req = $bdd->prepare('SELECT id, pseudo, pass, avatarimageurl, studying_level, profession, bio, birthdate, country, large FROM members WHERE BINARY pseudo = :pseudo OR email = :email');
$req->execute(array(
    'pseudo' => $pmail,
    'email' => $pmail));

$resultat = $req->fetch();

if (!$resultat)
{
    header("Location:/");
}
else if(password_verify($pass, $resultat['pass']))
{
    session_start();
    $_SESSION['id'] = $resultat['id'];
    $_SESSION['pseudo'] = $resultat['pseudo'];
    $_SESSION['avatarimageurl'] = $resultat['avatarimageurl'];
    $_SESSION['studying_level'] = $resultat['studying_level'];
    $_SESSION['profession'] = $resultat['profession'];
    $_SESSION['bio'] = $resultat['bio'];
    $_SESSION['birthdate'] = $resultat['birthdate'];
    $_SESSION['country'] = $resultat['country'];
    $_SESSION['large'] = $resultat['large'];
    $reqis = $bdd->prepare('UPDATE members SET online = NOW() WHERE id = :id');
            $reqis->execute(array(           
    'id' => $_SESSION['id']
    ));
   
    header("Location:index");
}
else
{
 header("Location:/");
}
}else{
    header("Location:profil");
}