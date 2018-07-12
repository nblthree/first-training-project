<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
  unset($_SESSION['gegener']);
?>
<!DOCTYPE html>
<html lang="en">
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
<?php include('start_chess.php'); ?>
<div id="userdata">
  <div class="largeuser" style="background-image: url(profilesimages/<?php echo $_SESSION['large']; ?>);"></div>
  <div class="avatarpetit" style="background-image: url(profilesimages/mini/<?php echo $_SESSION['avatarimageurl']; ?>);"></div>
  <div class="somedata"><div id="profi" class="nombrechose"><p>Shares</p><p id="nombredepartage"></p></div><div id='ami' class="nombrechose"><p>Friends</p><p id="nombredamis"></p></div></div>
</div>
<section id="scorsection">
<div id='poster'><div id='p_wrip' forgottenData='' class='cp_wri' contenteditable="true" placeholder='Type something...'></div><div id='p_c'><div id="pl">
  <div id='p_img'></div><div id='p_v'></div>
</div><div id="p_b">
  <button id="p_s">Post</button>

  <form style="display: none;" id="postLord" enctype="multipart/form-data">
    <input name="p_file_img" value="" id="p_file_img" type="file" style="display: none;" accept=".jpg, .png, jpeg, .gif" >
    <input name="p_file_vid" value="" id="p_file_vid" type="file" style="display: none;" accept="Video/*" >
  </form>

</div></div></div>
    <div id="wall">
      
    </div>
</section>
<div id="flexs"><div id="randomrequest1" ></div><?php include('patreon.php'); ?><div id="conectf"></div></div>
</div>
<footer>
	<span><span>&#169;</span> 2018 QuizBowl</span>
</footer>
</div>

<script type="text/javascript">
$(".nombrechose").on("click", function(){
  var id = this.id;
  if(id=="ami"){
window.location.assign("<?php echo $_SESSION['pseudo']; ?>/friends");
  }
  else{
window.location.assign("<?php echo $_SESSION['pseudo']; ?>");
  }
});

$.post(
  "allwall.php",
    {
        fn : "Bahamuth"
    },
                function(data){
$("#nombredamis").html(data[0]);
$("#nombredepartage").html(data[1]);
            },

            'json'
         );

  function wallele(number){

    $.post(
  "allwall.php",
    {
        n : number
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
wallele(n);
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







</script>
</body>
</html>
<?php 
}else{
  ?>
  <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <title>Connection</title>
</head>
<body>
<div id="op">
<div id="connection">
  <div id="c1"><h3>Connection</h3></div>
  <div id="c2"><p>Welcome in QuizBowl</p><a href="#">What is it?</a></div>
  <form action="connecting.php" method="post">
    <div id="c3"><input type="text" name="pmail" id="pmail" placeholder="E-mail or Username" maxlength="120"></div>
    <div id="c6"><input type="password" name="pass" id="mp" placeholder="Password" maxlength="100"></div>
    <div id="c4"><input type="submit" value="Log in" id="Next"></div>
  </form>
  <div id="c5"><p>Doesn't have an account yet? <a href="signup.php">Creat one.</a></p></div>
</div>



<footer>
  <span><span>&#169;</span> 2018 QuizBowl</span>
</footer>
</div>
</body>
</html>
  <?php
}
?>