<?php
@session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
if (isset($_GET['pseudo']) AND !empty($_GET['pseudo'])){
	$pseudo = htmlspecialchars($_GET['pseudo']);
  $req = $bdd->prepare('SELECT id FROM members WHERE pseudo = :pseudo');
    $req->execute(array(
    'pseudo' => $pseudo));
    $resultat = $req->fetch();
    if($resultat){
      $url = implode('',array_slice(explode('/', $_SERVER['HTTP_REFERER']),1,2));
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="http://<?php echo $url; ?>/">
	<link rel="manifest" href="manifest.json">
    <link rel="stylesheet" type="text/css" href="styleall.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<title>QuizBowl</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="formulairjs.js"></script>
  <script src="//twemoji.maxcdn.com/2/twemoji.min.js?2.4"></script>
</head>
<body>
<?php include('header.php'); ?>
<div id="limit" style="height: auto;">
<div id="li2">
<?php include('messages.php'); ?>
<?php include('start_chess.php'); ?>
<?php include('usersection.php'); ?>
<?php 
if($resultat['id'] == $_SESSION['id']){
include('editprofile.php'); 
}
?>

<section id="friendsection">

</section>
<div id="flexs"><div id="randomrequest1" ></div><?php include('patreon.php'); ?><div id="conectf"></div></div>
</div>
<footer>
	<span><span>&#169;</span>2018 QuizBowl</span>
</footer>
</div>
<script type="text/javascript">
	$.post(
  "connectedfriends.php",
    {
        allFriends : <?php echo $resultat['id']; ?>,
        width : $(window).width(),
    },
                function(data){              
$("#friendsection").append(data);
<?php 
if($resultat['id'] == $_SESSION['id']){
	?>
$(".eleminer").on("click", function(){
	var id = this.id.split(",")[1];
	$.post(
  "a.php",
    {
        unfriend : id
    },
                function(data){                            
if(Number(data)==4971){
	document.getElementById('block,'+id) .remove();
}
            },

            'text'
         );
});
<?php
}
?>
            },

            'text'
         );
</script>
</body>
</html>
<?php
}else{
  echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
}else{
  echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
}else{
  echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
?>