<?php
@session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
if (isset($_REQUEST['pseudo'])){
$pseudo = htmlspecialchars($_REQUEST['pseudo']);

$req = $bdd->prepare('SELECT large, id FROM members WHERE pseudo = :pseudo');
$req->execute(array(
    'pseudo' => $pseudo));
$resultat = $req->fetch();
?>
 <?php if ($_SESSION['id'] == $resultat['id']) { ?><label id='labe' for=""><?php } ?>
<div id="large" class='<?php echo $resultat['large']; ?>' style="width: 100%; height: 300px; background-image: url(profilesimages/<?php echo $resultat['large'] ?>); background-size: cover; background-position: center;"></div>
 <?php if ($_SESSION['id'] == $resultat['id']) { ?></label><?php } ?>
<form style="display: none;" id="imageformlarge" target="uploadFrame" action="uploadavatarimage.php" enctype="multipart/form-data" method="post">
			<input name="largeimagefile" value="" id="largeimagefile" type="file" style="display: none;" accept=".jpg, .png, .png-large, .jpg-large" >
		</form>
		<iframe style="display: none;" id="uploadFrame" name="uploadFrame"></iframe>
<?php
}
?>
<header>
	<div id="mainheader" class="<?php echo $_SESSION['pseudo'] ?>,<?php echo $_SESSION['id'] ?>">
	<span id="slidmenu">
		
	</span>
		<div id="menu">
			<nav>
				<ul>
					<li id="play"><a role="button">Play</a>
            <div id="ns">
					    <ul style="width: 100%;">
                <li style="width: 100% !important;"><a class='sousMenu' role="button" id="chess">Chess</a></li>
					    </ul>
            </div>
					</li>
					<li><a href="http://192.168.1.113" >Home</a></li>
					<li class="dis_none"><a href="http://192.168.1.113/classement.php">Classment</a></li>
					<li><a href="#" >FeedBack</a></li>
				</ul>
			</nav>
		</div>
		<div id="searchzone">
			<form id="searchform" action="suche.php" method="get">
        <div class="sr_flex">
			    <label for="searchinput"></label>
				  <input type="text" placeholder="Search User" name="searchinput" id="searchinput" autocomplete="off" spellcheck="false">
				  <span class="searchbutton"><button id="searchbutton" type="submit" name="submit"></button></span>
				</div>
				<div id="searchlist">
					<div id="someresult">
					<ul id="uluser">
						
					</ul>
					<script type="text/javascript">
				$("#large").css("height", $("#large").width()/3);


$('#searchinput').keyup(function() {

								$.post(
  "usersearch.php",
    {
        us : $('#searchinput').val()
    },
                function(data){
                  if ($('#searchinput').val().length != 0) {
                    $('#searchlist').css("display", "block");
                  }
                  else {
                    $('#searchlist').css("display", "none");
                  }
                	$('#uluser').html("");
                	$('#uluser').append(data);
            },

            'text'
         );
							});
</script>
					</div>
				</div>
			</form>
		</div>
		<div id="avatardiv">
			<div id='popoutavatar'>
				<a href="#" id="newData" style="width: 52px;height: 52px; display: block; border-radius: 35%;"><span id="avataricon"    style="background-image: url(profilesimages/mini/<?php echo $_SESSION['avatarimageurl']?>);"></span></a>
				<div id="arrowup" style="display: none;"></div>
				<div id="profilemenu" style="display: none;">
					<ul>
						<li><a href="<?php echo $_SESSION['pseudo']; ?>"><span class="fa1"></span>Profile</a></li>
						<li><a href="<?php echo $_SESSION['pseudo']; ?>/friends"><span class="fa2"></span>Friends</a></li>
						<li><a href="#" id="messages"><span class="fa3"></span>Messages</a></li>
						<li><a id="notifierMoi" href="<?php echo $_SESSION['pseudo']; ?>/notification"><span class="fa4"></span>Notifications</a></li>
						<li><a href="loginout.php">Log out</a></li>
					</ul>
				</div>	
			</div>
		</div>
		<div id="switch">
		<span class="son"></span>
			<label class="switch">
               <input type="checkbox">
               <span class="slider round"><div id="before"></div></span>
            </label>
        <span class="moon"></span>    
		</div>
	</div>
	
</header>

<script type="text/javascript">


$(document).ready(function(){
  function formatTime(time) {
    var hours = Math.floor(time / 3600);
    var mins  = Math.floor((time % 3600) / 60);
    var secs  = Math.floor(time % 60);
  
    if (secs < 10) {
        secs = "0" + secs;
    }
  
    if (hours) {
        if (mins < 10) {
            mins = "0" + mins;
        }
    
        return hours + ":" + mins + ":" + secs; // hh:mm:ss
    } else {
        return mins + ":" + secs; // mm:ss
    }
}
function pause(){
  $(".audioPause").on('click', function(){
    var src = this.id;
    $(this).attr('class', 'audioPlay');
    play();
    document.getElementById('audio,'+src).pause();
  });
}
  
  function play(){
  $(".audioPlay").on('click', function(){
    var src = this.id;
    $(this).attr('class', 'audioPause');
    pause();
    var th = this;
    var audio = document.getElementById('audio,'+src);
    var pb = document.getElementById('PB'+src);
    var er = document.getElementById('PTr'+src);
    var coe = $(er).width()/Number($(this).attr('data'));
    var pt = document.getElementById('PT'+src);
    audio.play();
    $(audio).on('timeupdate', function(){
      pb.style.width = coe*audio.currentTime+"px";
      pt.innerHTML = formatTime(audio.currentTime);
    });
    $(audio).on('ended', function(){
      audio.currentTime=0;
      pb.style.width = 0+"px";
      pt.innerHTML = formatTime(0);
      $(th).attr('class', 'audioPlay');
    });
  });
}
function getMousePosition(event) {
    return {
        x: event.pageX,
        y: event.pageY
    };
}
function getPosition(element){
    var top = 0, left = 0;
    
    do {
        top  += element.offsetTop;
        left += element.offsetLeft;
    } while (element = element.offsetParent);
    
    return { x: left, y: top };
}
function clickProgress(Player, progressBar, track, event, time) {
    var parent = getPosition(progressBar);    // La position absolue de la progressBar
    var target = getMousePosition(event); // L'endroit de la progressBar où on a cliqué
    var player = Player;
  
    var x = target.x - parent.x; 
    var wrapperWidth = track.offsetWidth;
    progressBar.style.width = x+"px";
    var percent = Math.ceil((x / wrapperWidth) * 100);    
    var duration = player.duration;
    
    player.currentTime = (duration * percent) / 100;
    time.innerHTML = formatTime(player.currentTime);
}
var websocket_server = new WebSocket("ws://192.168.1.113:8080/");
      websocket_server.onopen = function(e) {
        $.post("chesswork.php", {to_zero : <?php echo $_SESSION['id']; ?>}, function(data){
          websocket_server.send(
            JSON.stringify({
              'type':'socket',
              'sender': <?php echo $_SESSION['id']; ?>,
            })
          );
        },'text');
        $.post("chesswork.php", {flist : <?php echo $_SESSION['id']; ?>}, function(data){
          websocket_server.send(
            JSON.stringify({
              'type':'addPlayer',
              'sender': <?php echo $_SESSION['id']; ?>,
              'pSender': "<?php echo $_SESSION['pseudo']; ?>",
              'avSender': "<?php echo $_SESSION['avatarimageurl']?>",
              'data': data
            })
          );
        },'json');
        $.post("chesswork.php", {flist_plus_data : <?php echo $_SESSION['id']; ?>}, function(data){
          websocket_server.send(
            JSON.stringify({
              'type':'connected',
              'sender': <?php echo $_SESSION['id']; ?>,
              'pSender': "<?php echo $_SESSION['pseudo']; ?>",
              'avSender': "<?php echo $_SESSION['avatarimageurl']?>",
              'data': data
            })
          );
        },'json');
      };
      websocket_server.onerror = function(e) {
        // Errorhandling
      }
      var df = [];
      $.post("chesswork.php", {flist : <?php echo $_SESSION['id']; ?>}, function(data){
          df = data;
        },'json');
      setInterval(function(){
        $.post("chesswork.php", {flist : <?php echo $_SESSION['id']; ?>}, function(data){
          df = data;
        },'json');
      }, 60000);
      window.onbeforeunload = function(e) {
          websocket_server.send(
            JSON.stringify({
              'type':'closeC',
              'sender': <?php echo $_SESSION['id']; ?>,
              'data': df
            })
          );
      }

      websocket_server.onmessage = function(e)
      {
        var json = JSON.parse(e.data);
        switch(json.type) {
          case 'notifier':
          $("#newData").css("background-color", "#b2b2ec");
          $("#notifierMoi").css({"background-color": "#232333", "color": "#b2b2ec"});
            break;
          case 'like':
          var exi = document.getElementById("NL"+json.unique);
          if(typeof exi != 'undefined'){
            exi.innerHTML = (Number(exi.innerHTML)+1);
          }
            break;
          case 'dislike':
          var exi = document.getElementById("NL"+json.unique);
          if(typeof exi != 'undefined'){
            exi.innerHTML = (Number(exi.innerHTML)-1);
          }
            break;
          case 'alert':
              if(document.getElementById('connected,'+json.al)){
                if(document.getElementById('friends_selection')){
                  if(document.getElementById('friends_selection').className=='C_phone'){
                    var tg = document.getElementById('friends_selection').children;
                    for (var i = 0; i < tg.length; i++) {
                      tg[i].id += "second";
                    }
                  }
                }
                document.getElementById('connected,'+json.al).remove();
                  if(document.getElementById('friends_selection')){
                  if(document.getElementById('friends_selection').className=='C_phone'){
                    document.getElementById('friends_selection').innerHTML = document.getElementById('conectf').innerHTML;
                  }
                }

                
                if($("#conectf").children().length == 0){
                  $("#conectf").css("display", "none");
                }
              }
              if(document.getElementById('ches,'+json.al)){
            document.getElementById('ches,'+json.al).remove();
          }
            break;
          case 'connected':
              if($("#conectf").length == 1){
                if (typeof json.dispo !== 'undefined') {
                  $("#conectf").append(json.dispo);
                if(json.dispo.length == 0){
                  $("#conectf").css("display", "none");
                }
              }
              if(typeof json.newDispo !== 'undefined'){
                if(document.getElementById('friends_selection')){
                  if(document.getElementById('friends_selection').className=='C_phone'){
                    document.getElementById('friends_selection').innerHTML = "";
                  }
                }
                $("#conectf").css("display", "block");
                $("#conectf").append(json.newDispo);
                  if(document.getElementById('friends_selection')){
                  if(document.getElementById('friends_selection').className=='C_phone'){
                    document.getElementById('friends_selection').innerHTML = document.getElementById('conectf').innerHTML;
                  }
                }

              }
}
            break;
          case'addPlayer':
          if($("#op6").css("display")=="block"){
if(document.getElementById('ches,'+json.sender)){
            document.getElementById('ches,'+json.sender).remove();
          }
$("#disponible").append("<div class='cf1' id='ches,"+json.sender+"' style='background-color: #2b2626; color: #fff; display: flex;'><div id='randomavatar' style='width: 90%; height: 52px; display: flex;'><div id='randomimage'><a href='profile.php?pseudo="+json.p+"'><span id='avataricon' style='background-image: url(profilesimages/"+json.av+");'></span></a></div><span style='line-height: 52px; margin-left: 10px;'>"+json.p+"</span></div><button  id='"+json.sender+"' class='inv'>Invite</button><button style='display: none;'  id='"+json.sender+"' class='can'>Cancel</button></div>");
einladung();
}
            break;
          case 'invitation':
            if(json.logOut == 'no'){
              $('#op7').css("display","block");
              $('#data50').html("");
              $('#data50').append(json.pseudo+" invite you to play a Chess match of "+json.temps+" Minutes");
              $("#ok2").attr('class', 'lord,'+json.sender);
              $("#non2").attr('class', 'lord,'+json.sender);
              $.post("chesswork.php",{flist : <?php echo $_SESSION['id']; ?>},function(data){
                websocket_server.send(
                  JSON.stringify({
                    'type':'takeOf',
                    'sender': <?php echo $_SESSION['id']; ?>,
                    'data': data
                  })
                );
              },'json');
              $.post("chesswork.php",{flist : json.sender},function(data){
                websocket_server.send(
                  JSON.stringify({
                    'type':'takeOf',
                    'sender': json.sender,
                    'data': data
                  })
                );
              },'json');
          }else{
            $(".loader").remove();
            $("#"+json.inviter+".can").css("display","block");
            $("#"+json.inviter+".can").click();
            $("#ches,"+json.inviter).remove();
          }

            break;
          case 'takeOf':
          if(document.getElementById('ches,'+json.idn) && $("#close2").attr("class").split(",")[1] != json.idn){
            document.getElementById('ches,'+json.idn).remove();
          }
            break;
          case 'invitationAN':
          if(json.an=='ok'){
              localStorage.removeItem("shift");
              localStorage.removeItem("fen");
              localStorage.removeItem("history");
              localStorage.removeItem("time");
              $.post("chesswork.php",{se : "a"},function(data){
                window.location.assign("game.php");
              },'text');
            }else{
            $(".loader").remove();
            $("#"+json.sender+".can").css("display","none");
            $(".inv").css("display","block");
            $("#close2").attr("class", "clo,");
            }

            break;
          case 'annuller':
          $('#op7').css("display","none");
          $('#data50').html("");
            break;
          case 'chat':
          if($('#sendmessage').css("display")=="block" && ($("#navi").attr("class").split(",")[1]==json.id || json.id==<?php echo $_SESSION['id']; ?>)){
            $('#sendmessage').append(json.msg);
            twemoji.parse(document.body);
            var nnn = document.getElementById("sendmessage").scrollHeight;
            $("#sendmessage").animate({scrollTop:nnn}, 'fast');
            if(<?php echo $_SESSION['id']; ?>!=json.id){
            $.post(
  "chatwork.php",
    {
        recu : json.id
    },
                function(data){ 
            },

            'text'
         );
          }
          }else{
            twemoji.parse(document.body);
            $("#newData").css("background-color", "#b2b2ec");
            $("#messages").css({"background-color": "#232333", "color": "#b2b2ec"});
            $.post(
  "chatwork.php",
    {
        messageread : "Bahamuth"
    },
                function(data){
            },

            'text'
         );
          }
            break;
          case 'chatAudio':
          if($('#sendmessage').css("display")=="block" && ($("#navi").attr("class").split(",")[1]==json.id || json.id==<?php echo $_SESSION['id']; ?>)){
            if(json.id==<?php echo $_SESSION['id']; ?>){var stl = 'aS';}else{var stl = 'aR';}
var audi = "<audio controls='true' id='audio,"+json.msg+"' src="+json.msg+"></audio>";
$('#sendmessage').append(audi);
var aud = document.getElementById("audio,"+json.msg);
aud.load();
var ini=false;
$(aud).on('loadeddata', function(){
    aud.removeAttribute("controls");
  });
$(aud).on('loadedmetadata', function(){
  if(ini) return;
  ini = true;
  if(aud.duration === Infinity){
      aud.currentTime = 0;
      aud.playbackRate = 16;
      aud.volume =1;
      aud.play();
      var ny=0;
      aud.ontimeupdate = function(){
          ny=aud.currentTime;
        }

      }else{
       var ny=aud.duration;
  var reader = "<div class='audioPlayer "+stl+"'><div id="+json.msg+" data='"+ny+"' class='audioPlay'></div><div id='PT"+json.msg+"' class='progressTime'>0:00</div><div id='PTr"+json.msg+"' class='progressTrack'><div id='PB"+json.msg+"' class='progressBar'></div></div><div class='audioTotalTime'>"+formatTime(ny)+"</div></div>";
aud.removeAttribute("controls");
            $('#sendmessage').append(reader);
            var nnn = document.getElementById("sendmessage").scrollHeight;
            $("#sendmessage").animate({scrollTop:nnn}, 'fast');
            if(<?php echo $_SESSION['id']; ?>!=json.id){
            $.post(
  "chatwork.php",
    {
        recu : json.id
    },
                function(data){ 
            },

            'text'
         );
          }
        play();  
$('.progressBar').on('click', function(event){
  clickProgress(document.getElementById("audio,"+this.id.replace("PB", "")), document.getElementById(this.id), document.getElementById(this.id.replace("PB", "PTr")), event, document.getElementById(this.id.replace("PB", "PT")));
});

$('.progressTrack').on('click', function(event){
  if(this.id[1]=='T'){
    clickProgress(document.getElementById("audio,"+this.id.replace("PTr", "")), document.getElementById(this.id.replace("PTr", "PB")), document.getElementById(this.id), event, document.getElementById(this.id.replace("PTr", "PT")));
  }
});
      }
      var i =0
$(aud).on('ended', function(){
  if(i==0){
    i=1;
  aud.currentTime =0;
  aud.playbackRate = 1;
  aud.volume =1;
  var reader = "<div class='audioPlayer "+stl+"'><div id="+json.msg+" data='"+ny+"' class='audioPlay'></div><div id='PT"+json.msg+"' class='progressTime'>0:00</div><div id='PTr"+json.msg+"' class='progressTrack'><div id='PB"+json.msg+"' class='progressBar'></div></div><div class='audioTotalTime'>"+formatTime(ny)+"</div></div>";
aud.removeAttribute("controls");
            $('#sendmessage').append(reader);
            var nnn = document.getElementById("sendmessage").scrollHeight;
            $("#sendmessage").animate({scrollTop:nnn}, 'fast');
            if(<?php echo $_SESSION['id']; ?>!=json.id){
            $.post(
  "chatwork.php",
    {
        recu : json.id
    },
                function(data){ 
            },

            'text'
         );
          }
        play();  
$('.progressBar').on('click', function(event){
  clickProgress(document.getElementById("audio,"+this.id.replace("PB", "")), document.getElementById(this.id), document.getElementById(this.id.replace("PB", "PTr")), event, document.getElementById(this.id.replace("PB", "PT")));
});

$('.progressTrack').on('click', function(event){
  if(this.id[1]=='T'){
    clickProgress(document.getElementById("audio,"+this.id.replace("PTr", "")), document.getElementById(this.id.replace("PTr", "PB")), document.getElementById(this.id), event, document.getElementById(this.id.replace("PTr", "PT")));
  }
});
}
});
});
          }else{
            $("#newData").css("background-color", "#b2b2ec");
            $("#messages").css({"background-color": "#232333", "color": "#b2b2ec"});
            $.post(
  "chatwork.php",
    {
        messageread : "Bahamuth"
    },
                function(data){
            },

            'text'
         );
          }

            break;
          case 'chatImg':
if($('#sendmessage').css("display")=="block" && ($("#navi").attr("class").split(",")[1]==json.id || json.id==<?php echo $_SESSION['id']; ?>)){
            if(json.id==<?php echo $_SESSION['id']; ?>){var stl = 'aS';}else{var stl = 'aR';}

            var img = new Image();
            img.src = json.msg;
            img.className= "chatImage "+stl;
            img.id= "img,"+json.msg;
            img.onload = function(){
              if(img.width>300){img.height = img.height*300/img.width; img.width=300;}
              if(img.height>$('#sendmessage').height()){img.height = $('#sendmessage').height(); img.width = img.width*$('#sendmessage').height()/img.height;}
              $('#sendmessage').append(img);
              var nnn = document.getElementById("sendmessage").scrollHeight;
            $("#sendmessage").animate({scrollTop:nnn}, 'fast');
            }
            if(<?php echo $_SESSION['id']; ?>!=json.id){
            $.post(
  "chatwork.php",
    {
        recu : json.id
    },
                function(data){ 
            },

            'text'
         );
          }

          }else{
            $("#newData").css("background-color", "#b2b2ec");
            $("#messages").css({"background-color": "#232333", "color": "#b2b2ec"});
            $.post(
  "chatwork.php",
    {
        messageread : "Bahamuth"
    },
                function(data){
            },

            'text'
         );
          }
            break;
          case 'connectedfriendschess':
                  $('#disponible').html("");
                  $('#disponible').append(json.amie);
                  einladung();
            break;
        }
      }

      $.post(
  "chatwork.php",
    {
        news : "Bahamuth"
    },
                function(data){
                  if(data > 0){
    $("#newData").css("background-color", "#b2b2ec");
    $("#messages").css({"background-color": "#232333", "color": "#b2b2ec"});
                  }
            },

            'text'
         );
      function einladung(){  
                  $(".inv").on('click', function() {
     var id = $(this).attr('id'); 
     var time = $("#timechoose").val();
     $.post("chesswork.php", {inviter: id, temps: time}, function(data){
      websocket_server.send(
        JSON.stringify({
          'type':'invitation',
          'sender': <?php echo $_SESSION['id']; ?>,
          'pseudo': "<?php echo $_SESSION['pseudo']; ?>",
          'inviter': id,
          'temps': time
        })
      );
     },'text');
     $('#close2').attr("class", "clo,"+id);
     $(".inv").css("display","none");
     if($(".loader")){
      $(".loader").remove();
     }
    $('#'+id).parent().append("<div class='loader'></div>");
 setTimeout(function(){
if($(".inv").css("display")!="block"){
	$(".loader").remove();
    $("#"+id+".can").css("display","block");
}
 }, 6000);
 $.post(
  "chesswork.php",
    {
        invitation : id,
        time : time
    },
                function(data){

            },

            'text'
         );

});


$(".can").on('click', function() {
  var id = $(this).attr('id');
  $("#"+id+".can").css("display","none");
  $.post(
    "chesswork.php",
    {
        ann : id,
        inviter: $('#close2').attr('class').split(",")[1]
    },
    function(data){
      websocket_server.send(
        JSON.stringify({
          'type':'annuller',
          'data': data
        })
      );
    },
    
    'json'
  );

  $.post(
    "chesswork.php",
    {
        annll : "order6"
    },
    function(data){

    },

    'text'
  );
  $(".inv").css("display","block");
});
}

$('#chess').on('click', function() {
  $('#op6').css("display","block");
  $.post("chesswork.php", {flist_plus_data: <?php echo $_SESSION['id']; ?> }, function(data){
    websocket_server.send(
      JSON.stringify({
        'type':'connectedfriendschess',
        'sender': <?php echo $_SESSION['id']; ?>,
        'data': data
      })
    );
  }, 'json');
});


$(document.body).on('click', '#close2', function() {
  $('#op6').css("display","none");
  $.post(
    "chesswork.php",
    {
        annll : "order6",
        inviter: $('#close2').attr('class').split(",")[1]

    },
    function(data){
      websocket_server.send(
        JSON.stringify({
          'type':'annuller',
          'data': data
        })
      );
    },
    'json'
  );
});

$('#ok2').on('click', function() {
  websocket_server.send(
    JSON.stringify({
      'type':'invitationAN',
      'sender': <?php echo $_SESSION['id']; ?>,
      'inviteur': $(this).attr('class').split(",")[1],
      'inAN': 'ok'
    })
  );
});

$('#non2').on('click', function() {
  $('#op7').css("display","none");
  $.post(
    "chesswork.php",
    {
        non : "Order4",
        inviteur : $(this).attr('class').split(",")[1]
    },
    function(data){
      websocket_server.send(
        JSON.stringify({
          'type':'invitationAN',
          'inAN': 'no',
          'data': data
        })
      );
    },
    'json'
  );
});

$('#textsender').on('keyup', function(e) {
  if(e.which == 13 && $("#textsender").html().length>=1){
    e.preventDefault();
    var chat_msg = $("#textsender").html().split("<div><br></div>")[0];
    if(chat_msg.length>=1 && typeof chat_msg == 'string'){
      $.post( "uploadavatarimage.php", {chat_msg : chat_msg, user_id : userId}, function(data){
        websocket_server.send(
          JSON.stringify({
            'type':'chat',
            'user_id': userId,
            'chat_msg': chat_msg,
            'sender': <?php echo $_SESSION['id']; ?>,
            'psender': "<?php echo $_SESSION['avatarimageurl']; ?>",
            'file': 'undefined'
          })
        );
      },'text');
    }   
    $('#textsender').html("");
    $("#ImgAudioVideo").css('display', 'flex');
    $("#textsenderParent").css({'width': 'calc(100% - 150px)'});
    $("#wrightmessage").css('height', '');
    $("#sendmessage").css({'min-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)",'max-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)"});
    $('#textsenderParent').css({'overflow-y':'hidden'});
}else{
  if($('#textsender').innerHeight() < $("#wrightmessage").height() && $('#textsender').innerHeight()>=38){
    $('#textsenderParent').css({'overflow-y':'hidden'});
    iH = $("#wrightmessage").height();
    $("#wrightmessage").css('height',$('#textsender').innerHeight()+'px');
    $("#sendmessage").css({'min-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)",'max-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)"});
  }else if($('#textsender').innerHeight()<38){
    $('#textsenderParent').css({'overflow-y':'hidden'});
    $("#wrightmessage").css('height', '');
    $("#sendmessage").css({'min-height': $("#fenetre").height()-88,'max-height': $("#fenetre").height()-88});
  }
}
});
$('#sendFlech').on('click', function() {
  if($("#textsender").html().length>=1){
    var chat_msg = $("#textsender").html().toString();
    $.post( "uploadavatarimage.php", {chat_msg : chat_msg, user_id : userId}, function(data){
      websocket_server.send(
        JSON.stringify({
          'type':'chat',
          'user_id': userId,
          'chat_msg': chat_msg,
          'sender': <?php echo $_SESSION['id']; ?>,
          'psender': "<?php echo $_SESSION['avatarimageurl']; ?>",
          'file': 'undefined'
        })
      );
    },'text');
          
    $('#textsender').html("");
    $("#ImgAudioVideo").css('display', 'flex');
    $("#textsenderParent").css({'width': 'calc(100% - 150px)'});
    $("#wrightmessage").css('height',$('#textsender').innerHeight()+'px');
    $("#sendmessage").css({'min-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)",'max-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)"});
    $('#textsenderParent').css({'overflow-y':'hidden'});

}
});

$(document.body).on('click', '.tof', function() {
  var lettre = this.id.split(',')[1];
  var colo = "";
  if($(window).width() <= 483){colo = " colorChange";}
  $("#limit").prepend("<div class='cover"+colo+"'><div id='message_lien'><div style='display: flex;'><div style='width: calc(100% - 30px); height:40px; text-align: center; line-height: 40px;'>Select Friends</div><div id='commentEnd'></div></div><div style='height: 300px; overflow-y:scroll; overflow-x:hidden; word-wrap: break-word;' id='friends_selection'></div><div style='width:90%; height: 40px; justify-content: flex-end; margin: 0 auto;' id='p_b'><button style='height:30px; width: 60px; margin: auto 0;' class='' id='send_lien'>Send</button></div></div></div>");
    $("body").css('overflow-y', 'hidden');
    $('#commentEnd').on('click', function(){
   $(".cover").remove();
   $("body").css('overflow-y', 'scroll');
  });
    $.post( 
  "connectedfriends.php",
    {
        fm : 'fm'
    },
                function(data){                
document.getElementById('friends_selection').innerHTML = data;
var sendArray = [];
$('.bit').on('click', function(){
  var id = this.id.split(',')[1];
   if(sendArray.includes(id)){
    this.style.backgroundColor = '';
    this.style.color = '';
    var index = sendArray.indexOf(id);
    if (index > -1) {
    sendArray.splice(index, 1);
}
   }else{
    this.style.backgroundColor = 'bisque';
    this.style.color = 'black';
    sendArray.push(id);
   }
   var da = '';
   if(sendArray.length > 0){
   da = sendArray[0];
   for (var i = 1; i < sendArray.length; i++) {
    da = da + "," + sendArray[i];
   }
 }
 $('#send_lien').attr('class', da);
  });
            },

            'text'
         );


$('#send_lien').on('click', function(){
var data = $('#send_lien').attr('class');
if(data.length > 0){
  $.post( "uploadavatarimage.php", {user_id : data, lien_msg : lettre}, function(data){
    websocket_server.send(
      JSON.stringify({
        'type':'chat',
        'user_id': data,
        'chat_msg': lettre,
        'sender': <?php echo $_SESSION['id']; ?>,
        'psender': "<?php echo $_SESSION['avatarimageurl']; ?>",
        'file': 'lien'
      })
    );
  },'text');
}

   $(".cover").remove();
   $("body").css('overflow-y', 'scroll');
});

});

$('#sendImg').on('click', function() {
  $("#chatImg").click();
});
$("#chatImg").on('change', function(e){
   var img = e.target.files[0];
   if(img.size<=Math.pow(10, 7)){
var XHR = new XMLHttpRequest();
    var formData = new FormData();
    formData.append("img_message", img);
    formData.append("receiver", userId);

    XHR.addEventListener("error", function(event) {
      
    });

var ip = document.getElementById('up');
ip.style.width = 0;
    var maxW = $(ip).parent().width();
    var size = img.size;
    var coe = maxW/size;

    XHR.onloadstart = function (e) {
    $(ip).parent().css('display', 'block');
    }

    XHR.onloadend = function (e) {
    websocket_server.send(
            JSON.stringify({
              'type':'chat',
              'user_id': userId,
              'chat_msg': XHR.responseText,
              'sender': <?php echo $_SESSION['id']; ?>,
              'psender': "<?php echo $_SESSION['avatarimageurl']; ?>",
              'file': 'Img'
            })
          );
    ip.style.width=0;
    $(ip).parent().css('display', 'none');
    }

    XHR.upload.onprogress = function(e){
      ip.style.width = e.loaded * coe + "px";
    }

    XHR.open("POST", "uploadavatarimage.php");

    XHR.send(formData);

 }
});

$('#sendText').on('click', function() {
  $("#chatText").click();
});
$("#chatText").on('change', function(e){
   var file = e.target.files[0];
   if(file.size<=Math.pow(10, 7)){
   var XHR = new XMLHttpRequest();
    var formData = new FormData();
    formData.append("textfile_message", file);
    formData.append("receiver", userId);

    XHR.addEventListener("error", function(event) {
      
    });

var ip = document.getElementById('up');
ip.style.width = 0;
    var maxW = $(ip).parent().width();
    var size = file.size;
    var coe = maxW/size;

    XHR.onloadstart = function (e) {
    $(ip).parent().css('display', 'block');
    }
    XHR.onloadend = function (e) {
    websocket_server.send(
            JSON.stringify({
              'type':'chat',
              'user_id': userId,
              'chat_msg': XHR.responseText,
              'sender': <?php echo $_SESSION['id']; ?>,
              'psender': "<?php echo $_SESSION['avatarimageurl']; ?>",
              'file': 'textFile'
            })
          );
    ip.style.width=0;
    $(ip).parent().css('display', 'none');
    }

    XHR.upload.onprogress = function(e){
      ip.style.width = e.loaded * coe + "px";
    }

    XHR.open("POST", "uploadavatarimage.php");

    XHR.send(formData);
 }
});

$("#saveVoices").on('mousedown', function(){
  audioChunks=[];
  navigator.mediaDevices.getUserMedia({audio:true})
    .then(stream => {
        rec = new MediaRecorder(stream);
        rec.start();
        rec.ondataavailable = e => {
            audioChunks.push(e.data);
            if (rec.state == "inactive"){
              var blob = new Blob(audioChunks, { 'type' : 'audio/ogg;' });
      audioChunks = [];
      var data = new FormData();
      data.append('file', blob);
      data.append('rec', userId);
      $.ajax({
        url :  "uploadavatarimage.php",
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function(datas) {
          websocket_server.send(
            JSON.stringify({
              'type':'chat',
              'user_id': userId,
              'chat_msg': datas,
              'sender': <?php echo $_SESSION['id']; ?>,
              'psender': "<?php echo $_SESSION['avatarimageurl']; ?>",
              'file': 'audio'
            })
          );
        },    
        error: function() {
        }
      });
    }

        }
        $("#saveVoices").on('mouseup', function(){
        if(rec.state != "inactive"){
            rec.stop();
            stream.getAudioTracks()[0].stop();
          } 
            });
    })
    .catch(e=>console.log(e));
});

$("#saveVoices").on('touchstart', function(){
  audioChunks=[];
  navigator.mediaDevices.getUserMedia({audio:true})
    .then(stream => {
        rec = new MediaRecorder(stream);
        rec.start();
        rec.ondataavailable = e => {
            audioChunks.push(e.data);
            if (rec.state == "inactive"){
              var blob = new Blob(audioChunks, { 'type' : 'audio/ogg;' });
      audioChunks = [];
      var data = new FormData();
      data.append('file', blob);
      data.append('rec', userId);
      $.ajax({
        url :  "uploadavatarimage.php",
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function(data) {
          websocket_server.send(
            JSON.stringify({
              'type':'chat',
              'user_id': userId,
              'chat_msg':'audio',
              'sender': <?php echo $_SESSION['id']; ?>,
              'psender': "<?php echo $_SESSION['avatarimageurl']; ?>",
              'file': 'audio'
            })
          );
        },    
        error: function() {
        }
      });
    }

        }
        $("#saveVoices").on('touchend', function(){
        if(rec.state != "inactive"){
            rec.stop();
            stream.getAudioTracks()[0].stop();
          } 
            });
    })
    .catch(e=>console.log(e));
});



$(document.body).on('click', '.likes2', function(el){
  var ido = this.id;
    var idn = ido.split(",");
    var ho = this.className.split(" ");
    if(ho.length==1){
      for (var i = 0; i < document.getElementsByClassName('likes2').length; i++) {
        if(document.getElementsByClassName('likes2')[i].id == ido){
          document.getElementsByClassName('likes2')[i].setAttribute("class", "likes2 dis2");
          document.getElementsByClassName('likes2')[i].nextSibling.textContent = Number(document.getElementsByClassName('likes2')[i].nextSibling.textContent) + 1; 
        } 
      }

      $.post(
  "profilwall.php",
    {
        uniquexp : idn[1],
        witch : idn[2],
        p_id : idn[3],
        co_master : idn[4]
    },
                function(data){
websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': idn[4],
            'user2': idn[4]
          })
        );
            },

            'text'
         );
      
    }
    else{
      for (var i = 0; i < document.getElementsByClassName('likes2').length; i++) {
        if(document.getElementsByClassName('likes2')[i].id == ido){
          document.getElementsByClassName('likes2')[i].setAttribute("class", "likes2");
          document.getElementsByClassName('likes2')[i].nextSibling.textContent = Number(document.getElementsByClassName('likes2')[i].nextSibling.textContent) - 1;
        } 
      }

            $.post(
  "profilwall.php",
    {
        uniquexp : idn[1],
        witch : idn[2],
        p_id : idn[3],
        co_master : idn[4]
    },
                function(data){

            },

            'text'
         );   
    }
});
$(document.body).on('click', '.sh', function(el){
  if(this.textContent == "More"){
    this.textContent = "Less";
    $(this).next().css({'height': '100%'});
  }else{
    this.textContent = "More";
    $(this).next().css({'height': '0px'});
  }
});
$(document.body).on('click', '.sha', function(){
  var id = this.id.split(',');
  var elz = this;
  var r = $(this).closest(".cadre");
  var r2 = $(this).closest(".cadre").find('.retw');
  if(r2.length>=1){
    var rt = $(r2).html();
  }

  if(this.className== 'sha'){
    $.post(
  "profilwall.php",
    {
        shau : id[1],
        shao : id[2],
    },
                function(data){
                  elz.className = 'sha shaed';
                  elz.nextSibling.innerHTML = Number(elz.nextSibling.innerHTML) + 1;
  if(r2.length>=1){
    $(r2).html('You retweeted');
    $(r2).attr('db', rt);
  }else{
    $(r).prepend("<div class='retw'>You retweeted</div>");
  }
            },

            'text'
         );
  }else{
    $.post(
  "profilwall.php",
    {
        shauoff : id[1],
        shaooff : id[2],
    },
                function(data){
                  elz.className = 'sha';
                  elz.nextSibling.innerHTML = Number(elz.nextSibling.innerHTML) - 1;
  if(typeof $(r2).attr('db') !== typeof undefined && $(r2).attr('db') !== false){
    $(r2).html($(r2).attr('db'));
  }else{
    $(r2).remove();
  }
            },

            'text'
         );
  }
});
$(document.body).on('click', '.komkom', function(el){
  if(el.target.className == 'komkom'){
  var min = 54;
  var max = 2;
  var cid= this;
  
var id = this.id.split(',');
var text= id[3];
var udon = (id[0][0]+id[0][1])+","+id[1]+","+id[2]+","+id[3]+","+id[4]+","+id[5]+","+id[6];

  var top2 = "<div id='top2'><div class='top2Sous'>"+id[2]+"</div><div id='commentEnd'></div></div>";
  var svg = "<svg id='sv' height:20; width:20;'><circle cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke: beige; stroke-dashoffset: "+max+"; stroke-dasharray: 53.2071;'></circle><circle id='pC'  cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke-dashoffset: "+min+"; stroke-dasharray: 53.2071;'></circle></svg>";
  var bt = "<div class='door'><div id='Np' style='font-size: 13px;'></div>"+svg+"</div>";
  var middle2 = "<div id='middle2'>"+text+"</div>";
  var bottom2 = "<div id='bottom2'><div id='com' placeholder='Type Here...' contenteditable='true'></div>"+bt+"<div class='asfal'><button id='shareC'>Share</button></div></div>";
  $("#limit").prepend("<div class='cover mobileComment'><div id='wolk'>"+top2+middle2+bottom2+"</div></div>");

$('#commentEnd').on('click', function(){
  $(".cover")[0].remove();
});
  var circle = document.getElementById('pC');
  var np = document.getElementById('Np');
  var sv = document.getElementById('sv');
  $('#com').on('keyup', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });
  $('#com').on('paste', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });



  $('#shareC').on('click', function(e){
    
    $.post(
  "profilwall.php",
    {
        uniquex: id[1],
        uni : id[4],
        tko : id[5], 
        comx: document.getElementById("com").textContent,
        witch: id[6]
    },
                function(data){
                  if(id[0] == 'nKre'){
                    $.post(
                      "profilwall.php",
                      {
                        id_k : id[1],
                        p_id : id[4],
                        witch : id[6]
                      },
                      function(data){
                        $("#ko2").html("");
                        document.getElementById(udon).nextSibling.textContent = Number(document.getElementById(udon).nextSibling.textContent) + 1;
                        $("#ko2").append(data);
                        websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': id[5],
            'user2': id[5]
          })
        );
                      },
                      'text'
                      );
                  }else{
                    cid.nextSibling.innerHTML = Number(cid.nextSibling.innerHTML) + 1; 
                  }
            },

            'text'
         );
    document.getElementById("com").textContent = "";
    circle.style.strokeDashoffset = min;
      np.innerHTML = "";
      $('#commentEnd').click();

  });
}
});

if(document.getElementById('scorsection') && !document.getElementById('dorm')){
$('#wall').on('click', '.kommentar', function(el){
  if(el.target.className == 'kommentar'){
  var min = 54;
  var max = 2;
  var elz = this;
var id = this.id.split(',');
var text="";
var nr = $(this).closest(".cadre").find('.chessBoardWall');
if(nr.length >= 1){
  text = "Chess Match.";
}else{
  text = $(this).closest(".cadre").find('.po_vi').children()[0].textContent;
}
  var top2 = "<div id='top2'><div class='top2Sous'>"+id[3]+"</div><div id='commentEnd'></div></div>";
  var svg = "<svg id='sv' height:20; width:20;'><circle cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke: beige; stroke-dashoffset: "+max+"; stroke-dasharray: 53.2071;'></circle><circle id='pC'  cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke-dashoffset: "+min+"; stroke-dasharray: 53.2071;'></circle></svg>";
  var bt = "<div class='door'><div id='Np' style='font-size: 13px;'></div>"+svg+"</div>";
  var middle2 = "<div id='middle2'>"+text+"</div>";
  var bottom2 = "<div id='bottom2'><div id='com' placeholder='Type Here...' contenteditable='true'></div>"+bt+"<div class='asfal'><button id='shareC'>Share</button></div></div>";
  $("#limit").prepend("<div class='cover mobileComment'><div id='wolk'>"+top2+middle2+bottom2+"</div></div>");
  $("body").css('overflow-y', 'hidden');
  $("header").css('position', 'absolute');
$('#commentEnd').on('click', function(){
  $(".cover").remove();
  $("body").css('overflow-y', 'scroll');
  $("header").css('position', '');
});
  var circle = document.getElementById('pC');
  var np = document.getElementById('Np');
  var sv = document.getElementById('sv');
  $('#com').on('keyup', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });
  $('#com').on('paste', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });



  $('#shareC').on('click', function(e){
    $.post(
  "profilwall.php",
    {
        tei : id[2],
        stei : id[4],
        unique: id[1],
        com: document.getElementById("com").textContent
    },
                function(data){
                  elz.nextSibling.innerHTML = Number(elz.nextSibling.innerHTML) + 1;
                  $('#commentEnd').click();
                 websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': id[2],
            'user2': id[4]
          })
        );
            },

            'text'
         );
    document.getElementById("com").textContent = "";
    circle.style.strokeDashoffset = min;
  });
}
});

  

$('#wall').on('click', '.cadre', function(e){
  if(e.target.className == 'cadre' || e.target.className == 'top' || e.target.className == 'bottom' || e.target.className == 'likeDislike'){
    var remember = $(this).clone();
    var remember2 = this;
  $("#limit").prepend("<div id='cover_out'></div><div class='cover' style='z-index: 9000;'><div id='cen' style='margin: 0 auto; width: "+document.getElementById('scorsection').offsetWidth+"px'></div></div>");
  $("body").css('overflow-y', 'hidden');
$('#cover_out').on('click', function(){
  $(".cover").remove();
  $('#cover_out').remove();
  $("body").css('overflow-y', 'scroll');
  $("header").css('position', '');
  $(remember2).after(remember);
  $(remember2).remove();
});
  var object2 = $(this).clone();
  $("#cen").append(object2);
  $("#cen").children()[0].id = "chosen";
$("#chosen").append("<div id='ko' style='width: 100%;'></div>");

var c = $("#chosen").find('.kommentar');
var n = $("#chosen").find('.chessBoardWall');
if(n.length<1){
  var n = $("#chosen").find('.po_vi');
  var z =0;
}else{
  $(n[0]).css({"margin-right": "5px", "margin-left": "5px"});
  var z=1;
}
    var id = c[0].id.split(',');

$.post('profilwall.php', {teig : id[2], uniqueg: id[1]}, function(data) {
    $("#ko").append(data);
}, 'text')
.fail(function(response) {
    $("#ko").html('');
    $("#ko").append("<button id='errorButton2' class='"+id[2]+","+id[1]+"'>An Error Has Occured Click Here To Refreach</button>");
});

/* border */

$('#chosen').on('click', '.likes', function(){
    var ido = this.id;
    var idn = ido.split(",");
    var ho = this.className.split(" ");
    if(ho.length==1){
      this.setAttribute("class", "likes dis");
      $.post(
  "profilwall.php",
    {
        iop : idn[2],
        siop : idn[4],
        unique : idn[1]
    },
                function(data){

            },

            'text'
         );
      websocket_server.send(
          JSON.stringify({
            'type':'like',
            'unique': idn[1]
          })
        );
      websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': idn[2],
            'user2': idn[4]
          })
        );
      
    }
    else{
      this.setAttribute("class", "likes");
            $.post(
  "profilwall.php",
    {
        ip : idn[2],
        sip : idn[4],
        unique : idn[1]
    },
                function(data){

            },

            'text'
         );
            websocket_server.send(
          JSON.stringify({
            'type':'dislike',
            'unique': idn[1]
          })
        );
      
    }
  });

  /* border */

  $('#chosen').on('click', '.kommentar', function(el){
  if(el.target.className == 'kommentar'){
  var min = 54;
  var max = 2;
  var elz = this;
var id = this.id.split(',');
var text="";
var n = $("#chosen").find('.chessBoardWall');
if(n.lenght>=1){
  text = "Chess Match.";
}else{
  text = $(".po_vi").children()[0].textContent;
}
  var top2 = "<div id='top2'><div class='top2Sous'>"+id[3]+"</div><div id='commentEnd'></div></div>";
  var svg = "<svg id='sv' height:20; width:20;'><circle cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke: beige; stroke-dashoffset: "+max+"; stroke-dasharray: 53.2071;'></circle><circle id='pC'  cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke-dashoffset: "+min+"; stroke-dasharray: 53.2071;'></circle></svg>";
  var bt = "<div class='door'><div id='Np' style='font-size: 13px;'></div>"+svg+"</div>";
  var middle2 = "<div id='middle2'>"+text+"</div>";
  var bottom2 = "<div id='bottom2'><div id='com' placeholder='Type Here...' contenteditable='true'></div>"+bt+"<div class='asfal'><button id='shareC'>Share</button></div></div>";
  $("#limit").append("<div id='toHell' class='cover mobileComment'><div id='wolk'>"+top2+middle2+bottom2+"</div></div>");

  $("body").css('overflow-y', 'hidden');
  $("header").css('position', 'absolute');
$('#commentEnd').on('click', function(){
  $("#toHell").remove();
  $("header").css('position', '');
});
  var circle = document.getElementById('pC');
  var np = document.getElementById('Np');
  var sv = document.getElementById('sv');
  $('#com').on('keyup', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });
  $('#com').on('paste', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });

  $('#shareC').on('click', function(e){
    $.post(
  "profilwall.php",
    {
        tei : id[2],
        stei : id[4],
        unique: id[1],
        com: document.getElementById("com").textContent
    },
                function(data){
                  websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': id[2],
            'user2': id[4]
          })
        );
$.post(
  "profilwall.php",
    {
        teig : id[2],
        uniqueg: id[1],
    },
                function(data){
                  $("#ko").html("");
                  $("#ko").prepend(data);
            },

            'text'
         );
            },

            'text'
         );
    document.getElementById("com").textContent = "";
          np.innerHTML = "";
          elz.nextSibling.innerHTML = Number(elz.nextSibling.innerHTML) + 1;
          $('#commentEnd').click();
  });
}
});
}
});

$('#wall').on('click', '.likes', function(){
    var ido = this.id;
    var idn = ido.split(",");
    var ho = this.className.split(" ");
    if(ho.length==1){
      this.setAttribute("class", "likes dis");
      $.post(
  "profilwall.php",
    {
        iop : idn[2],
        siop : idn[4],
        unique : idn[1]
    },
                function(data){

            },

            'text'
         );
      websocket_server.send(
          JSON.stringify({
            'type':'like',
            'unique': idn[1]
          })
        );
      websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': idn[2],
            'user2': idn[4]
          })
        );
      
    }
    else{
      this.setAttribute("class", "likes");
            $.post(
  "profilwall.php",
    {
        ip : idn[2],
        sip : idn[4],
        unique : idn[1]
    },
                function(data){

            },

            'text'
         );
            websocket_server.send(
          JSON.stringify({
            'type':'dislike',
            'unique': idn[1]
          })
        );
      
    }
  });
}

if(document.getElementById('dorm')){
  $('#wall').on('click', '.likes', function(){
    var ido = this.id;
    var idn = ido.split(",");
    var ho = this.className.split(" ");
    if(ho.length==1){
      this.setAttribute("class", "likes dis");
      $.post(
  "profilwall.php",
    {
        iop : idn[2],
        siop : idn[4],
        unique : idn[1]
    },
                function(data){

            },

            'text'
         );
      websocket_server.send(
          JSON.stringify({
            'type':'like',
            'unique': idn[1]
          })
        );
      websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': idn[2],
            'user2': idn[4]
          })
        );
      
    }
    else{
      this.setAttribute("class", "likes");
            $.post(
  "profilwall.php",
    {
        ip : idn[2],
        sip : idn[4],
        unique : idn[1]
    },
                function(data){

            },

            'text'
         );
            websocket_server.send(
          JSON.stringify({
            'type':'dislike',
            'unique': idn[1]
          })
        );
      
    }
  });

/* border */






$('#wall').on('click', '.kommentar', function(el){
  if(el.target.className == 'kommentar'){
  var min = 54;
  var max = 2;
  var elz = this;
var id = this.id.split(',');
var text="";

var nr = $(this).closest(".cadre").find('.chessBoardWall');
if(nr.length >= 1){
  text = "Chess Match.";
}else{
  text = $(this).closest(".cadre").find('.po_vi').children()[0].textContent;
}
  var top2 = "<div id='top2'><div class='top2Sous'>"+id[3]+"</div><div id='commentEnd'></div></div>";
  var svg = "<svg id='sv' height:20; width:20;'><circle cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke: beige; stroke-dashoffset: "+max+"; stroke-dasharray: 53.2071;'></circle><circle id='pC'  cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke-dashoffset: "+min+"; stroke-dasharray: 53.2071;'></circle></svg>";
  var bt = "<div class='door'><div id='Np' style='font-size: 13px;'></div>"+svg+"</div>";
  var middle2 = "<div id='middle2'>"+text+"</div>";
  var bottom2 = "<div id='bottom2'><div id='com' placeholder='Type Here...' contenteditable='true'></div>"+bt+"<div class='asfal'><button id='shareC'>Share</button></div></div>";
  $("#limit").prepend("<div class='cover mobileComment'><div id='wolk'>"+top2+middle2+bottom2+"</div></div>");
  $("body").css('overflow-y', 'hidden');
  $("header").css('position', 'absolute');
$('#commentEnd').on('click', function(){
  $(".cover").remove();
  $("body").css('overflow-y', 'scroll');
  $("header").css('position', '');
});
  var circle = document.getElementById('pC');
  var np = document.getElementById('Np');
  var sv = document.getElementById('sv');
  $('#com').on('keyup', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });
  $('#com').on('paste', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });



  $('#shareC').on('click', function(e){
    $.post(
  "profilwall.php",
    {
        tei : id[2],
        stei : id[4],
        unique: id[1],
        com: document.getElementById("com").textContent
    },
                function(data){
websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': id[2],
            'user2': id[4]
          })
        );
            },

            'text'
         );
    document.getElementById("com").textContent = "";
    circle.style.strokeDashoffset = min;
    elz.nextSibling.innerHTML = Number(elz.nextSibling.innerHTML) + 1;
    $('#commentEnd').click();
  });
}
});

  

$('#wall').on('click', '.cadre', function(e){
  if(e.target.className == 'cadre' || e.target.className == 'top' || e.target.className == 'bottom' || e.target.className == 'likeDislike'){
    var remember = $(this).clone();
    var remember2 = this;
  $("#limit").prepend("<div id='cover_out'></div><div class='cover' style='z-index: 9000;'><div id='cen' style='margin: 0 auto; width: "+document.getElementById('scorsection').offsetWidth+"px'></div></div>");
  $("body").css('overflow-y', 'hidden');
$('#cover_out').on('click', function(){
  $(".cover").remove();
  $('#cover_out').remove();
  $("body").css('overflow-y', 'scroll');
  $("header").css('position', '');
  $(remember2).after(remember);
  $(remember2).remove();
});
  var object2 = $(this).clone();
  $("#cen").append(object2);
  $("#cen").children()[0].id = "chosen";
$("#chosen").append("<div id='ko' style='width: 100%;'></div>");

var c = $("#chosen").find('.kommentar');
var n = $("#chosen").find('.chessBoardWall');
if(n.length<1){
  var n = $("#chosen").find('.po_vi');
  var z =0;
}else{
  $(n[0]).css({"margin-right": "5px", "margin-left": "5px"});
  var z=1;
}
    var id = c[0].id.split(',');

$.post('profilwall.php', {teig : id[2], uniqueg: id[1]}, function(data) {
    $("#ko").append(data);
}, 'text')
.fail(function(response) {
    $("#ko").html('');
    $("#ko").append("<button id='errorButton2' class='"+id[2]+","+id[1]+"'>An Error Has Occured Click Here To Refreach</button>");
});


/* border */

$('#chosen').on('click', '.likes', function(){
    var ido = this.id;
    var idn = ido.split(",");
    var ho = this.className.split(" ");
    if(ho.length==1){
      this.setAttribute("class", "likes dis");
      $.post(
  "profilwall.php",
    {
        iop : idn[2],
        siop : idn[4],
        unique : idn[1]
    },
                function(data){

            },

            'text'
         );
      websocket_server.send(
          JSON.stringify({
            'type':'like',
            'unique': idn[1]
          })
        );
      websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': idn[2],
            'user2': idn[4]
          })
        );
      
    }
    else{
      this.setAttribute("class", "likes");
            $.post(
  "profilwall.php",
    {
        ip : idn[2],
        sip : idn[4],
        unique : idn[1]
    },
                function(data){

            },

            'text'
         );
            websocket_server.send(
          JSON.stringify({
            'type':'dislike',
            'unique': idn[1]
          })
        );
      
    }
  });

  /* border */

  $('#chosen').on('click', '.kommentar', function(el){
  if(el.target.className == 'kommentar'){
  var min = 54;
  var max = 2;
  var elz = this;
var id = this.id.split(',');
var text="";
var n = $("#chosen").find('.chessBoardWall');
if(n.length>=1){
  text = "Chess Match.";
}else{
  text = $(".po_vi").children()[0].textContent;
}
  var top2 = "<div id='top2'><div class='top2Sous'>"+id[3]+"</div><div id='commentEnd'></div></div>";
  var svg = "<svg id='sv' height:20; width:20;'><circle cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke: beige; stroke-dashoffset: "+max+"; stroke-dasharray: 53.2071;'></circle><circle id='pC'  cx='50%' cy='50%' r='8' fill='none' stroke-width='2' style='stroke-dashoffset: "+min+"; stroke-dasharray: 53.2071;'></circle></svg>";
  var bt = "<div class='door'><div id='Np' style='font-size: 13px;'></div>"+svg+"</div>";
  var middle2 = "<div id='middle2'>"+text+"</div>";
  var bottom2 = "<div id='bottom2'><div id='com' placeholder='Type Here...' contenteditable='true'></div>"+bt+"<div class='asfal'><button id='shareC'>Share</button></div></div>";
  $("#limit").append("<div id='toHell' class='cover mobileComment'><div id='wolk'>"+top2+middle2+bottom2+"</div></div>");

  $("body").css('overflow-y', 'hidden');
  $("header").css('position', 'absolute');
$('#commentEnd').on('click', function(){
  $("#toHell").remove();
  $("header").css('position', '');
});
  var circle = document.getElementById('pC');
  var np = document.getElementById('Np');
  var sv = document.getElementById('sv');
  $('#com').on('keyup', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });
  $('#com').on('paste', function(e){
    var l = String(this.textContent).length;
    if(l <= 200 && l !=0 ){
      circle.style.strokeDashoffset = min - 0.26*l;
      np.innerHTML = "";
      if(l<=186 && l>160){
        sv.style.stroke = "#1dc240";
      }
      else if(l>186){
        sv.style.stroke = "#a73806";
      }else{
        sv.style.stroke = "#017df7";
      }
    }else if(l == 0){
      circle.style.strokeDashoffset = min;
      np.innerHTML = "";
    }else{
      circle.style.strokeDashoffset = max;
      np.innerHTML = 200-l;
      sv.style.stroke = "#541c03";
    }
  });

  $('#shareC').on('click', function(e){
    $.post(
  "profilwall.php",
    {
        tei : id[2],
        stei : id[4],
        unique: id[1],
        com: document.getElementById("com").textContent
    },
                function(data){
                  websocket_server.send(
          JSON.stringify({
            'type':'notifier',
            'user1': id[2],
            'user2': id[4]
          })
        );
$.post(
  "profilwall.php",
    {
        teig : id[2],
        uniqueg: id[1],
    },
                function(data){
                  $("#ko").html("");
                  $("#ko").prepend(data);
            },

            'text'
         );
            },

            'text'
         );
    document.getElementById("com").textContent = "";
          np.innerHTML = "";
          elz.nextSibling.innerHTML = Number(elz.nextSibling.innerHTML) + 1;
          $('#commentEnd').click();
  });
}
});
}
});
/* border */
}




});





</script>