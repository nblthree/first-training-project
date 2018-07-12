<?php
header("Content-Type: text/plain"); 
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
  if( isset($_POST['pseu'])){

  $pseu = htmlspecialchars($_POST['pseu']);
	$req = $bdd->query('SELECT pseudo FROM members');
	$i = 0;
	while ($resultat = $req->fetch()) {
if (strcmp($resultat['pseudo'], $pseu) == 0) {
$i = $i + 1;
                               }
                                       }  

$req = $bdd->query('SELECT pseudo FROM verifcation');
  while ($resultat = $req->fetch()) {
if (strcmp($resultat['pseudo'], $pseu) == 0) {
$i = $i + 1;
                               }
                                       }  



if ($i == 1) {
    echo "$i";
              }
else {
    echo "$i";
              }      
}
                      
?> 