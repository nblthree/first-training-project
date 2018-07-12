<?php

/*
Change 192.168.1.113 on line 196 & 202 to the domaine name or the IPv4 address or to localhost
Change line 186 & 187 by putting your email and password
*/


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}



if (isset($_POST['pseudo']) AND isset($_POST['email']) AND isset($_POST['pass']) AND isset($_POST['passconfirme']) AND isset($_POST['year']) AND isset($_POST['month']) AND isset($_POST['day']) AND isset($_POST['country']))
{
$email = htmlspecialchars($_POST['email']);
$pass = htmlspecialchars($_POST['pass']);
$pseudo = htmlspecialchars($_POST['pseudo']);
$passconfirme = htmlspecialchars($_POST['passconfirme']);

$year = htmlspecialchars($_POST['year']);
$month = htmlspecialchars($_POST['month']);
$day = htmlspecialchars($_POST['day']);

$birthdate = "$year-$month-$day";
$country = htmlspecialchars($_POST['country']);

$ip1 = "";
$ip2 = "";
$ip3 = "";
$ip4 = "";
$ip5 = "";

     
if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pseudo) || preg_match('/\s/', $pseudo))
{
    $ip1 = "Invalide Username";
}else if(strlen($pseudo)>30){
        $ip1 = "Username too long";
    } 
     function verify_email($email, $bdd)
        {
         $syntaxe='#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#';
         if(preg_match($syntaxe, $email)){
            $reol = $bdd->prepare('SELECT id FROM members WHERE email = :email');
            $reol->execute(array(
                  'email' => $email));
            $singer = $reol->fetch();
            if($singer){
              return false;
            }else{
              $reol2 = $bdd->prepare('SELECT id FROM verifcation WHERE email = :email');
                $reol2->execute(array(
                      'email' => $email));
                $singer2 = $reol2->fetch();
                if($singer2){
                  return false;
                }else{
                  return true;
                }
            }
         }
         else{
            return false;
          }
        }
   if (!verify_email($email, $bdd)) {
     $ip2 = "Invalide Email";
     $mailv = false;                
                              }else{
                                $mailv = true;
                              }


      function verify_password($pass)
        {
         $syntaxe='#^[\sa-zA-Z0-9._-]{10,}$#';

         $syntaxe1='#[A-Z]+#';
         $syntaxe2='#[a-z]+#';
         $syntaxe3='#[0-9]+#';

         if(preg_match($syntaxe, $pass) AND preg_match($syntaxe1, $pass) AND preg_match($syntaxe2, $pass) AND preg_match($syntaxe3, $pass))
            return true;
         else
            return false;
        }                     
    if (verify_password($pass) || strlen($pass)<10) {

          if ( $passconfirme != $pass) {    	
     $ip4 = "The Passwords are not Identical";
     $ps = false;
            }else{
                    $timeTarget = 0.05;
$cost = 8;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);


$passhash = password_hash("$pass", PASSWORD_BCRYPT, ['cost' => $cost]);
$ps = true;
                }                                                          
                                }else{
                                  $ip3 = "Invalide Password";
                                  $ps = false;
                                }


$reponse = $bdd->query('SELECT * FROM members');
$more_than_one_pseudo = 0;
while ($donnees = $reponse->fetch())
{
if (strcmp($donnees['pseudo'], $pseudo) == 0 OR strlen($pseudo) == 0) {
	$more_than_one_pseudo++;}
}
$reponse->closeCursor();
$reponse = $bdd->query('SELECT * FROM verifcation');
while ($donnees = $reponse->fetch())
{
if (strcmp($donnees['pseudo'], $pseudo) == 0 OR strlen($pseudo) == 0) {
	$more_than_one_pseudo++;}
}
$reponse->closeCursor(); 
if ($more_than_one_pseudo != 0) {
	$ip1 = "Used Username";
}

if ($mailv AND $ps AND $more_than_one_pseudo == 0) 
{

$code = random_str(150);

$req = $bdd->prepare('INSERT INTO verifcation(pseudo, email, pass, birthdate, country, code) VALUES(:pseudo, :email, :pass, :birthdate, :country, :code)');
$req->execute(array(
	'pseudo' => $pseudo,
	'email' => $email,
	'pass' => $passhash,
	'birthdate' => $birthdate,
	'country' => $country,
  'code' => $code,
	));

$mail = new PHPMailer(true);                              
try {
    
    $mail->SMTPDebug = 2;                                 
    $mail->isSMTP();

    $mail->SMTPOptions = array(
    	'ssl' => array(
    		'verify_peer' => false,
    		'verify_peer_name' => false,
    		'allow_self_signed' => true
    	)
    );

    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'address';                
    $mail->Password = 'password';                          
    $mail->SMTPSecure = 'tls';                            
    $mail->Port = 587;                                    

    $mail->setFrom('boardcoporation@gmail.com', 'Board Cells');
    $mail->addAddress($email, $pseudo);    
    $mail->isHTML(true);

    $bodyContent = "<h1 style='text-align:center;'>Welcome, $pseudo</h1>";
    $bodyContent .= "<p>Click in the following link to confirm your inscription http://192.168.1.113/confirmation.php?token=$code&ps=$pseudo</p>";
    $mail->Subject = 'Confirmation Email From Board';
    $mail->Body    = $bodyContent;

                          

    $mail->AltBody = 'Go to the following link to confirm your inscription http://192.168.1.113/confirmation.php?token=$code&ps=$pseudo';

    $mail->send();

  echo $pseudo.",pseudo";

} catch (Exception $e) {
	$ip5 = "An Error had Occured. Please Retry.";
    
}
} 
else{
  echo $ip1.",".$ip2.",".$ip3.",".$ip4.",".$ip5;
}

 }



?>
