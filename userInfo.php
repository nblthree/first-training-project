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


if (isset($_POST['pseudo']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);

    if (strlen($pseudo) != 0 && strlen($pseudo)<=30 && !preg_match('/[\'^£$%*()}{?><>,|=_+-]/', $pseudo))
    {
$reponse = $bdd->query('SELECT * FROM members');
$more_than_one_pseudo = 0;
while ($donnees = $reponse->fetch())
{
if (strcmp($donnees['pseudo'], $pseudo) == 0) {
	$more_than_one_pseudo++;}
}
$reponse->closeCursor();
if ($more_than_one_pseudo == 0) {
	$req = $bdd->prepare('UPDATE members SET pseudo = :pseudo WHERE id = :id');
            $req->execute(array(
	'pseudo' => $pseudo,
	'id' => $_SESSION['id']
	));
            $_SESSION['pseudo'] = $pseudo;
            echo $pseudo;
                                 }
    }
}

if (isset($_POST['pass']) && strlen($_POST['pass'])>=10) {
	$pass = htmlspecialchars($_POST['pass']);
    $req = $bdd->prepare('SELECT pass FROM members WHERE id = :id');
$req->execute(array(
    'id' => $_SESSION['id']));

$resultat = $req->fetch();
	if (password_verify($pass, $resultat['pass'])) {
if (isset($_POST['passconfirme']))
{

$passconfirme = htmlspecialchars($_POST['passconfirme']);
function verify_password($passconfirme)
        {
         $syntaxe='#^[\sa-zA-Z0-9._-]{10,}$#';
         if(preg_match($syntaxe, $passconfirme))
            return true;
         else
            return false;
        }                     
    if (verify_password($passconfirme)) {
   	
$timeTarget = 0.05;
$cost = 8;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);


$passhash = password_hash("$passconfirme", PASSWORD_BCRYPT, ['cost' => $cost]);
$req = $bdd->prepare('UPDATE members SET pass = :pass WHERE id = :id');
            $req->execute(array(
	'pass' => $passhash,
	'id' => $_SESSION['id']
	));
                                                              
                                }
}
}
}

if (isset($_POST['studying_level'])) {
    $studying_level = htmlspecialchars($_POST['studying_level']);

    $req = $bdd->prepare('UPDATE members SET studying_level = :studying_level WHERE id = :id');
            $req->execute(array(
    'studying_level' => $studying_level,
    'id' => $_SESSION['id']
    ));
           $_SESSION['studying_level'] = $studying_level;
           echo $studying_level;
}

if (isset($_POST['profession'])) {
    $profession = htmlspecialchars($_POST['profession']);

    $req = $bdd->prepare('UPDATE members SET profession = :profession WHERE id = :id');
            $req->execute(array(
    'profession' => $profession,
    'id' => $_SESSION['id']
    ));
            $_SESSION['profession'] = $profession;
            echo $profession;
}

if (isset($_POST['textarea']) && strlen($_POST['textarea']) <= 250) {
    $textarea = htmlspecialchars($_POST['textarea']);

    $req = $bdd->prepare('UPDATE members SET bio = :bio WHERE id = :id');
            $req->execute(array(
    'bio' => $textarea,
    'id' => $_SESSION['id']
    ));
            $_SESSION['bio'] = $textarea;

    $req = $bdd->prepare('SELECT pseudo FROM members WHERE id = :id');
            $req->execute(array(
    'id' => $_SESSION['id']));
$resultat = $req->fetch();
echo $resultat['pseudo'];
}

if( isset($_POST['newpass'])){
  $newpass = htmlspecialchars($_POST['newpass']);
    $req = $bdd->prepare('SELECT pass FROM members WHERE id = :id');
    $req->execute(array(
    'id' => $_SESSION['id']));
    $resultat = $req->fetch();                      
if (password_verify($newpass, $resultat['pass']))
{
    echo "ok";
              }
else {
    echo "sorry";
              }
}



?>