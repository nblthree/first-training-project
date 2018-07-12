<?php 
session_start();

if (isset($_SESSION['id'])) {
           
// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('login', '');
setcookie('pass_hache', '');
echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
else{
	echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
if (isset($_POST['id'])) {
if (isset($_SESSION['id'])) {
            
// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('login', '');
setcookie('pass_hache', '');
echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
else{
	echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
}
?> 