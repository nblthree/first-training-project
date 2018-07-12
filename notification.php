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
if (isset($_REQUEST['pseudo']) AND !empty($_REQUEST['pseudo'])){
	$pseudo = htmlspecialchars($_REQUEST['pseudo']);
	$req = $bdd->prepare('SELECT id FROM members WHERE BINARY pseudo = :pseudo');
    $req->execute(array(
    'pseudo' => $pseudo));
    $resultat = $req->fetch();
    if($resultat AND $resultat['id']==$_SESSION['id']){
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
<div id="limit">
<div id="li2">
<?php include('messages.php'); ?>
<?php include('start_chess.php'); ?>
<section id="notificationsection">
  <div id="friendsquest"></div>
  <div id="otherN"></div>
</section>

<div id="flexs"><div id="randomrequest1" ></div><?php include('patreon.php'); ?><div id="conectf"></div></div>
</div>
<footer>
	<span><span>&#169;</span>2018 QuizBowl</span>
</footer>
</div>
<script type="text/javascript">
	$.post(
  "a.php",
    {
        invi : <?php echo $_SESSION['id']; ?>
    },
                function(data){ 
$("#friendsquest").append(data);
$('.accepte').on('click', function() {
    var id = $(this).attr('id');
    $.post(
  "a.php",
    {
        snj : id
    },
                function(data){ 
                  if (Number(data) == 55) {
            $("#friendquest"+id).remove();
                 }
            },

            'text'
         );
});
    $('.refuse').on('click', function() {
    var id = $(this).attr('id');   
    $.post(
  "a.php",
    {
        snjr : id
    },
                function(data){ 
                  if (Number(data) == 555) {
            $("#friendquest"+id).remove();  
                 }
            },

            'text'
         );
});
            },

            'text'
         );


$.post(
  "profilwall.php",
    {
        notf : "data"
    },
                function(data){ 
$("#otherN").append(data);
$.post(
  "profilwall.php",
    {
        notificationEa : "Baga"
    },
                function(data){

            },

            'text'
         );

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