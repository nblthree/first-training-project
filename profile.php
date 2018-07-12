<?php
session_start();
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

  if(!isset($_REQUEST['page']) OR empty($_REQUEST['page'])){
  $pseudo = htmlspecialchars($_REQUEST['pseudo']);
  $req = $bdd->prepare('SELECT id FROM members WHERE BINARY pseudo = :pseudo');
    $req->execute(array(
    'pseudo' => $pseudo));
    $resultat = $req->fetch();
    if($resultat){
      $url = implode('',array_slice(explode('/', $_SERVER['HTTP_REFERER']),1,2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="http://<?php echo $url; ?>/" >
	<link rel="manifest" href="manifest.json">
    <link rel="stylesheet" type="text/css" href="styleall.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<title>QuizBowl</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="formulairjs.js"></script>
	<script src="flot/excanvas.min.js"></script>
    <script src="flot/jquery.flot.js"></script>
    <script src="//twemoji.maxcdn.com/2/twemoji.min.js?2.4"></script>
</head>
<body>
<?php include('header.php'); ?>

<div id="limit">
<div id="li2">

<?php include('messages.php'); ?>
<?php include('start_chess.php'); ?>
<?php include('usersection.php'); ?>
<?php 
if($resultat['id'] == $_SESSION['id']){
include('editprofile.php');
}
?>
<section id="scorsection">
<div id="dorm"><button id="d">Days</button><button id="m">Months</button></div>
<div id="flotcanvas">
    </div>
    <div id="wall">
      
    </div>
</section>
<div id="flexs"><div id="randomrequest1" ></div><?php include('patreon.php'); ?><div id="conectf"></div></div>
</div>
<footer>
	<span><span>&#169;</span>2018 QuizBowl</span>
</footer>
</div>


<script type="text/javascript">
jQuery(function(){
setTimeout(function(){
      jQuery('#d').click();
}, 2000);
    });
$('#d').on('click', function() {
	$("#flotcanvas").html("");
	$.post(
  "graph.php",
    {
        user : <?php echo $resultat['id']; ?>
    },
                function(datas){
                	var i=1;
                	var d = new Date();
    var n = d.getDate();
     var data = [];
            datas.forEach(function(element) {

if (n >= i) {  
var arr1 = [[i,element]];
 data = data.concat(arr1);
 }
 if (n < i) {
 	var arr1 = [[i,]];
 data = data.concat(arr1);
 }
i++;
});              
            var options = {
        series: {
                   lines: { show: true, fill: true, fillColor: "rgba(0, 0, 0, 0.8)"},
                   points: { show: true, fill: true, fillColor: "rgba(0, 0, 0, 0.8)"},
                   color: ['blue'],
                   
               }
    };
 
    $.plot($("#flotcanvas"), 
                [
                    {
                    data:data,points:{symbol: "circle"}
                    }
                ],
                options);
            },

            'json'
         );
	
});




  
  

  function wallele(number, idprofile){
    $.post(
  "profilwall.php",
    {
        n : number,
        id : idprofile
    },
                function(datam){
                  var allCadres = document.getElementsByClassName('cadre');
                  var cadreArray = [];
                  for (var i = 0; i < allCadres.length; i++) {
                   cadreArray[i] = allCadres[i].id.split(',')[1];
                  }    
                  if(datam.length !=0 && !cadreArray.includes(datam[1])){
                    $("#wall").append(datam[0]);
                    $('video').bind('contextmenu',function() { return false; });
                    $('video').attr("controlsList", "nodownload");
                    videoPlayer();
                    videoEmbed.invoke();
                  }
            },

            'json'
         );
  }
  
function ti(n, k){
  var y = 200 * (n - k) + 100;
  setTimeout(function(){
wallele(n, <?php echo $resultat['id']; ?>);
  }, y)
}

  var n=0;
while(n < 10){
  ti(n);
  n++;
}

$(document).scroll(function() {
  var scrollHeight = $(document).height();
  var scrollPosition = $(window).height() + $(window).scrollTop();
    if (((scrollHeight - scrollPosition) / scrollHeight < 0.1 && (scrollHeight - scrollPosition) / scrollHeight > 0.08) || (scrollHeight - scrollPosition) / scrollHeight === 0) {
      var i = $("#wall").children().length + 1;
      var k = i;
while(i <= ($("#wall").children().length + 10)){
  ti(i, k);
  i++;
}
    }
});
$('#m').on('click', function() {
	$("#flotcanvas").html("");
	$.post(
  "graph.php",
    {
        userm : <?php echo $resultat['id']; ?>
    },
                function(datas){ 
                	var i=1;
    var d = new Date();
    var n = d.getMonth() +1;
     var data = [];
            	
            datas.forEach(function(element) {
if (n >= i) {  
var arr1 = [[i,element]];
 data = data.concat(arr1);
 }
 if (n < i) {
 	var arr1 = [[i,]];
 data = data.concat(arr1);
 }
i++;
});                	 
            var options = {
        series: {
                   lines: { show: true, fill: true, fillColor: "rgba(0, 0, 0, 0.8)"},
                   points: { show: true, fill: true, fillColor: "rgba(0, 0, 0, 0.8)"},
                   color: ['blue'],
                   
               }
    };
 
    $.plot($("#flotcanvas"), 
                [
                    {
                    data:data,points:{symbol: "circle"}
                    }
                ],
                options);
            },

            'json'
         );


});
   
</script>
</body>
</html>
<?php
}else{
  echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
}else if(isset($_REQUEST['page']) AND $_REQUEST['page']=='notification'){
  require_once('notification.php');
}else if(isset($_REQUEST['page']) AND $_REQUEST['page']=='friends'){
  require_once('friends.php');
}
}else{
  echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
}else{
  echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
?>