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
if (isset($_GET['post_id']) AND !empty($_GET['post_id'])){
	$post = htmlspecialchars($_GET['post_id']);
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<section id="scorsection">
  <div id='wall'>
    
  </div>
</section>
<div id="flexs"><div id="randomrequest1" ></div><?php include('patreon.php'); ?><div id="conectf"></div></div>
</div>
<footer>
	<span><span>&#169;</span>2018 QuizBowl</span>
</footer>
</div>
<script type="text/javascript">
	$.post(
  "profilwall.php",
    {
        post_id : <?php echo $post; ?>
    },
                function(datam){ 
if(datam.length !=0 && datam[0]!='chess'){
$("#wall").append(datam);
$('video').bind('contextmenu',function() { return false; });
$('video').attr("controlsList", "nodownload");
videoPlayer();
videoEmbed.invoke();
                  }
                  else if(datam.length !=0 && datam[0]=='chess'){
                    var mu = datam[1];
                    var kn = datam[2];
                    var data=[];
                    var ori_partageur = datam[4];
                    var ori_pseu = datam[3];
                    var unique = datam[5];
                    datam = datam.slice(6);
                    data = datam.slice(8);

                  if(data[0]=="noir"){
var bw="b";
var wb="w";
                  }
                  else{
var bw="w";
var wb="b";                 
                  }
                  var pieces = "img/chesspieces/wikipedia/";

  var space = 1;
  var arr= ['A','B','C','D','E','F','G','H'];
  var info="";
  var lit=data[0]+',';
  var i=4;
  while(data.length > i){
    if(data.length==(i+1)){
      info = lit+data[i];
    }
    else{
      info = lit+data[i]+",";
    }    
    lit=info;
    i++;
  }

  var k=Math.floor((Math.random() * 10000) + 1);
  var g="fff";


                  if(bw=="w"){
var top="<div class='bla'><div class='petitimage' style='background-image: url(profilesimages/mini/"+datam[3]+")'></div><p>Black: "+datam[2]+"</p></div> <div class='whai'><div class='petitimage' style='background-image: url(profilesimages/mini/"+datam[1]+")'></div><p>White: "+datam[0]+"</p></div>";
}
else{
var top="<div class='bla'><div class='petitimage' style='background-image: url(profilesimages/mini/"+datam[1]+")'></div><p>Black: "+datam[0]+"</p></div> <div class='whai'><div class='petitimage' style='background-image: url(profilesimages/mini/"+datam[3]+")'></div><p>White: "+datam[2]+"</p></div>";
}

var tm = "<div class='m_top' style='padding-bottom: 5px;'><div class='sharer'><div class='petitimage' style='background-image: url(profilesimages/mini/"+datam[5][4]+")'></div><p style='margin-left: 10px;'>"+ori_pseu+"</p></div></div>"
 
var s = "<div class='numberliebe'><span class='"+datam[5][3]+"' id='numberSha,"+unique+","+ori_partageur+","+ori_pseu+","+datam[5][0]+","+datam[5][1]+"'></span><p>"+mu+"</p></div>";
var tf = "<div class='numberliebe'><span class='tof' id='numberTof,"+unique+","+ori_partageur+","+ori_pseu+","+datam[5][0]+","+datam[5][1]+"'></span></div>";

var likedislike="<div class='likeDislike'><div class='numberliebe'><span class='"+datam[7]+"' id='numberLikes,"+unique+","+ori_partageur+","+ori_pseu+","+datam[5][0]+","+datam[5][1]+"'></span><p id='NL"+unique+"'>"+datam[6]+"</p></div><div class='numberliebe'><span class='kommentar' id='numberKommentar,"+unique+","+ori_partageur+","+ori_pseu+","+datam[5][0]+","+datam[5][1]+"'></span><p>"+kn+"</p></div>"+s+tf+"</div>";
var bottom = "<div class='bottom'>"+likedislike+"<p>"+datam[11]+"</p></div>";
var bro = "<div id='prBChess' lek='"+k+"' alltime='"+((data.length-4)/2+1)+"' ><div currentTime='"+0+"' class='pB' id='pB"+k+"'></div><div class='point'></div></div>"
  $("#wall").append("<div class='cadre' style='width: 100%; padding: 0px; box-sizing: border-box;'>"+datam[5][2]+tm+"<div class='top'>"+top+"</div><div id='board"+k+"' class='chessBoardWall'></div><div class='chessVideoControle'><button nc='1' which='bh' class='begin' id='"+k+"' data='"+info+"'></button>"+bro+"</div>"+bottom+"<div id='ko' style='width: 100%;'></div></div>");
  
for (var r=1; r<=8; r++) {
  
  var col = "";
  for (var c=0; c<8; c++) {

    col += "<td class='carres"+k+"' id='"+arr[c]+r+g+k+"'></td>";
}
  $("#board"+k).prepend("<tr>"+col+"</tr>");


if (r==2) {
for (var c=0; c<8; c++) { 
$("#"+arr[c]+r+g+k).append("<img id="+arr[c]+r+','+k+"  class="+bw+"  src='img/chesspieces/wikipedia/"+bw+"P.png'>");
}
  }


if (r==7) {
for (var c=0; c<8; c++) { 
$("#"+arr[c]+r+g+k).append("<img id="+arr[c]+r+','+k+" class="+wb+"  src='img/chesspieces/wikipedia/"+wb+"P.png'>");
}
  }

if (r==1) {
for (var c=0; c<8; c++) {
  if (c==0) {pi=(bw+"R");}if (c==1) {pi=(bw+"N");}if (c==2) {pi=(bw+"B");}if (c==3) {if(bw=="w"){pi=(bw+"Q");}else{pi=(bw+"K");}}if (c==4) {if(bw=="w"){pi=(bw+"K");}else{pi=(bw+"Q");}}if (c==5) {pi=(bw+"B");}if (c==6) {pi=(bw+"N");}if (c==7) {pi=(bw+"R");}
$("#"+arr[c]+r+g+k).append("<img id="+arr[c]+r+','+k+" class="+bw+"  src='img/chesspieces/wikipedia/"+pi+".png'>");
}
  }


if (r==8) {
for (var c=0; c<8; c++) {
  if (c==0) {pi=(wb+"R");}if (c==1) {pi=(wb+"N");}if (c==2) {pi=(wb+"B");}if (c==3) {if(bw=="w"){pi=(wb+"Q");}else{pi=(wb+"K");}}if (c==4) {if(bw=="w"){pi=(wb+"K");}else{pi=(wb+"Q");}}if (c==5) {pi=(wb+"B");}if (c==6) {pi=(wb+"N");}if (c==7) {pi=(wb+"R");}
$("#"+arr[c]+r+g+k).append("<img id="+arr[c]+r+','+k+" class="+wb+"  src='img/chesspieces/wikipedia/"+pi+".png'>");
}
  }
}

}




var c = $(".cadre").find('.kommentar');
var id = c[0].id.split(',');
    $.post(
  "profilwall.php",
    {
        teig : id[2],
        uniqueg: id[1]
    },
                function(data){
                  $("#ko").append(data);
            },

            'text'
         );
            },

            'json'
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
?>