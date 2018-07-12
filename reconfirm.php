<?php
/*
Change 192.168.1.113 on line 63 & 69 to the domaine name or the IPv4 address or to localhost
Change line 53 & 54 by putting your email and password
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


if(isset($_POST['pseudo'])){
	$p = htmlspecialchars($_POST['pseudo']);

	$req = $bdd->prepare('SELECT code, email FROM verifcation WHERE pseudo = :pseudo');
$req->execute(array(
    'pseudo' => $p));
$resultat2 = $req->fetch();

if($resultat2){

$email = $resultat2['email'];
$code = $resultat2['code'];
$pseudo = $p;
                          
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

    $mail->setFrom('boardcoporation@gmail.com', 'Board Life');
    $mail->addAddress($email, $pseudo);    
    $mail->isHTML(true);

    $bodyContent = "<h1 style='text-align:center;'>Welcome, $pseudo</h1>";
    $bodyContent .= "<p>Click in the following link to confirm your inscription http://192.168.1.113/confirmation.php?token=$code&ps=$pseudo</p>";
    $mail->Subject = 'Confirmation Email From Board';
    $mail->Body    = $bodyContent;

                          

    $mail->AltBody = 'Go to the following link to confirm your inscription http://192.168.1.113/confirmation.php?token=$code&ps=$pseudo';

    $mail->send();

} catch (Exception $e) {
    
}




}else{
	
}
}else{
	
}



?>
