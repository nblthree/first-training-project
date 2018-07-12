<?php 
session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=qyizbowl;charset=utf8', 'root', '0000');
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$req = $bdd->prepare('SELECT chessinvitation FROM members WHERE id = :id');
$req->execute(array(
  'id' => $_SESSION['id']));
$donnees = $req->fetch();

$reqt = $bdd->prepare('SELECT id FROM members WHERE chessinvitation = :chessinvitation AND chessinvitation != :chessinvitation2');
$reqt->execute(array(
  'chessinvitation' => $donnees['chessinvitation'],
  'chessinvitation2' => 0));

$ni =0;
while($donneest = $reqt->fetch()){
  $ni++;
}

if($ni == 2 AND isset($_SESSION['gegener']) AND $_SESSION['gegener']>0 ){

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" type="text/css" href="stylegame.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<title>QuizBowl</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="chessmove/chess.js"></script>
	<script src="chessboard/js/chessboard-0.3.0.min.js"></script>
</head>
<body oncontextmenu="return false;">
<div id="limit">
<div id="appenddivs">
</div>
<div class="mtop"></div>

<div class="chatbox"> 
  <div id="chat"></div>
  <textarea id="text" placeholder="Type here..."></textarea>
  <div style="width: 90%; margin-left: 5%; display: flex; justify-content: flex-end;"><button style="width: 100%;" id="envoyer">Send</button></div>
</div>

<div id="op4" style="display: none;">
	<div id="diegewinner">
		<div id="thewiner"></div>
		<div id="middContent" class="midd">Do you wish to play another match</div>
		<div class="butflex">
			<button class="one_duo" id="replay">Yes</button>
			<button class="one_duo" id="comeback">No</button>

			<button class="one_duo_none" id="yes_play">Accept</button>
			<button class="one_duo_none" id="no_play">Refuse</button>
		</div>
	</div>
</div>

<div id="chesst">
	<div id="board" class="board"></div>
	<div id="chrono">
      <div class="timePlayerBW"><div class="nameBW">Black</div><div id="b" class="timeBW"></div></div>
      <div class="timePlayerBW"><div class="nameBW">White</div><div id="w" class="timeBW"></div></div>
      <div id="mouves">Move: 0</div>
    </div>
    <div id="newpiece"></div>
    <div id="buttons">
      <button id="GiveUp">GiveUp</button>
    </div>
</div>

<div class="mus">
  <div id="notationAlgebrique"></div>
  <div id="music">
    <iframe width="100%" height="100%" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/256661155&color=%232c281b&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
  </div>
</div>


<script type="text/javascript">
  var nigh = localStorage.getItem("nightmode");
  if(nigh == 1){
    $('HEAD').append("<link id='nightStyle' rel='stylesheet' type='text/css' href='nightgame.css'>")
  }
</script>


<script type="text/javascript">
var em=0;
$.post(
  "chesswork.php",
    {
        whattime : "Bahamuth"
    },
                function(data){
                	if (data < 10) {
                		$('#b').html("0"+data+":00");
                		$('#w').html("0"+data+":00");
                	}else{
                		$('#w').html(data+":00");
                		$('#b').html(data+":00");
                	}
                	em = data;
            },

            'text'
         );




var bw="<?php echo $_SESSION['color'] ?>";
var websocket_server = new WebSocket("ws://"+window.location.hostname+":8080/");
if(localStorage.getItem("fen")!=null){
	var board, game = new Chess(localStorage.getItem("fen"));
}else{
	var board, game = new Chess();
}

var onDragStart = function (source, piece, position, orientation) {
    if (game.in_checkmate() === true || game.in_draw() === true ||
        piece.search(bw=="w" ? ( /^b/ ) : ( /^w/ ) ) !== -1) {
        return false;
    }
};
var value = 'q';

function promotion(){
	var ar = ['B', 'N', 'Q', 'R'];
	for (let i = 0; i < 4; i++) {
	  $("#newpiece").append("<div class='promotion "+ (i==2 ? 'p_select':'') +"' id="+ar[i]+" style='background-image: url(chessboard/img/chesspieces/wikipedia/<?php echo $_SESSION['color']; ?>"+ar[i]+".png)'></div>");
	}

}
promotion();
$(".promotion").on('click', function(){
	value = (this.id).toLowerCase();
	for (let i = 0; i < 4; i++) {
		($(".promotion")[i]).setAttribute("class", "promotion");
	}
	this.className = "promotion p_select";
});
var onDrop = function (source, target) {

    var move = game.move({
        from: source,
        to: target,
        promotion: value
    });
    if(source != target && move!=null){
    	websocket_server.send(
            JSON.stringify({
              'type':'chessMove',
              'move': [source, target, value],
              'user': <?php echo $_SESSION['id']; ?>,
              'gegener': <?php echo $_SESSION['gegener']; ?>
            })
        );
        getTime(true);
        historywriter();
        localStorage.setItem("time", document.getElementById("b").textContent+"/"+document.getElementById("w").textContent);
    }
    removeGreySquares();
    if (move === null) {
        return 'snapback';
    }

};

var onSnapEnd = function () {
    board.position(game.fen());
};

var onMouseoverSquare = function(square, piece) {
    var moves = game.moves({
        square: square,
        verbose: true
    });


    if (moves.length === 0) return;

    greySquare(square);

    for (var i = 0; i < moves.length; i++) {
        greySquare(moves[i].to);
    }
};

var onMouseoutSquare = function(square, piece) {
    removeGreySquares();
};

var removeGreySquares = function() {
    $('#board .square-55d63').css('background', '');
};

var greySquare = function(square) {
    var squareEl = $('#board .square-' + square);

    var background = '#a9a9a9';
    if (squareEl.hasClass('black-3c85d') === true) {
        background = '#696969';
    }

    squareEl.css('background', background);
};

var cfg = {
    draggable: true,
    position: 'start',
    onDragStart: onDragStart,
    onDrop: onDrop,
    onMouseoutSquare: onMouseoutSquare,
    onMouseoverSquare: onMouseoverSquare,
    onSnapEnd: onSnapEnd,
    orientation: bw=="b" ? "black" : "white"
};
function render(){
	board = ChessBoard('board', cfg);
	if(localStorage.getItem("fen")!=null){
		board.position(game.fen());
	}
}
if(localStorage.getItem("fen")!=null){
	getTime(false);
	document.getElementById('notationAlgebrique').innerHTML = localStorage.getItem("history");
	$("#mouves").html("Move: "+Math.round((document.getElementById('notationAlgebrique').getElementsByTagName('span').length)/2));
	let v = (localStorage.getItem("time")).split("/");
	document.getElementById("b").textContent = v[0];
	document.getElementById("w").textContent = v[1];
}
if($(window).width()/2+200 >= $(window).height()){
  $("#chesst").css({'width': $(window).width()*0.3+"px" });
}
render();
$(window).on('load', function(){
  render();
});
window.addEventListener('resize', function(){
  if($(window).width()/2 >= $(window).height()){
  $("#chesst").css({'width': $(window).width()*0.3+"px" });
}
	render();
  
});
var running, checkPieces=[0, 0];



function tm(time, turn){
setTimeout(function(){
var tmk = formatTime( time - (Date.now() / 1000) );
if(turn == 'b'){
document.getElementById('b').innerHTML = tmk;
}else{
document.getElementById('w').innerHTML = tmk;
}
if(running == turn && (Number(tmk.split(':')[0]) + Number(tmk.split(':')[1])) > 0 ){
  tm(time, turn);
}
if((Number(tmk.split(':')[0]) + Number(tmk.split(':')[1])) <= 0){
    $.post(
  "chesswork.php",
    {
        lost : game.turn()
    },
        function(datam){

    },

        'text'
    );
    websocket_server.send(
    	JSON.stringify({
    		'type': 'chessEnd',
    		'lost': (game.turn()=='black' ? ( "<?php echo $_SESSION['color']; ?>" == 'b' ? "<?php echo $_SESSION['pgegener']; ?>" : "<?php echo $_SESSION['pseudo']; ?>" ) : ( "<?php echo $_SESSION['color']; ?>" == 'w' ? "<?php echo $_SESSION['pgegener']; ?>" : "<?php echo $_SESSION['pseudo']; ?>" ) ),
    		'sender': <?php echo $_SESSION['id']; ?>,
    		'gegener': <?php echo $_SESSION['gegener']; ?>
    	})
    );
}
                    
}, 800);
}




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

function getTime(e){
	var shift = localStorage.getItem("shift"); 

            if(shift == null){
            	localStorage.setItem("shift", (Date.now() / 1000) );
            }else if(e){
            	localStorage.setItem("shift", shift+"-"+(Date.now() / 1000) );
            }

            var tar = localStorage.getItem("shift").split('-');
            var tp = 0;
            if(game.turn() == 'b'){
            	for (let i = 1; i < tar.length; i+=2) {
            		tp = tp + ( Number(tar[i+1]) - Number(tar[i]) );
            	}
            	tp += Number(tar[0]);
            }else{
            	for (let i = 2; i < tar.length; i+=2) {
            		tp = tp + ( Number(tar[i+1]) - Number(tar[i]) );
            	}
            	tp += Number(tar[1])
            }

            running = game.turn();
            tm(em*60+tp, game.turn());
}

function historywriter(){
	localStorage.setItem("fen", game.fen());

        if(checkPieces[0]!=0){
        	$(".square-"+checkPieces[0]).css({"background" : ""});
            $(".square-"+checkPieces[1]).css({"background" : ""});
            checkPieces = [0, 0];
        }
        var history = game.history();
        var historyRegister = $("#notationAlgebrique");

        historyRegister.append('<span class=pAN>' + history[history.length-1] + '</span>'+ ((document.getElementById('notationAlgebrique').getElementsByTagName('span').length)%2==0 ? '<br>': '') )
        historyRegister.scrollTop(historyRegister.scrollHeight);

        localStorage.setItem("history", document.getElementById('notationAlgebrique').innerHTML);
        $("#mouves").html("Move: "+Math.round((document.getElementById('notationAlgebrique').getElementsByTagName('span').length)/2));
}


      websocket_server.onopen = function(e) {
setTimeout(function(){
        websocket_server.send(
          JSON.stringify({
            'type':'chessSocket',
            'user': <?php echo $_SESSION['id']; ?>
          })
        );
        $.post("chatwork.php",{connected : "a"},function(data){ if(data=="not"){window.location.replace("http://"+window.location.hostname+"/");} },'text');
}, 500);
      };
      websocket_server.onerror = function(e) {
        // Errorhandling
      }
     

$('#envoyer').on('click', function() {
  if($("#text").val().length>0){
    var chat_msg = $("#text").val();
          websocket_server.send(
            JSON.stringify({
              'type':'chessChat',
              'chat_msg':chat_msg,
              'gegener': <?php echo $_SESSION['gegener']; ?>,
              'sender': <?php echo $_SESSION['id']; ?>
            })
          );
    $('#text').val("");
}
});
$('#text').on('keypress', function(e) {
  if(e.which == 13 && $("#text").val().length>0){
    e.preventDefault();
    var chat_msg = $("#text").val();
          websocket_server.send(
            JSON.stringify({
              'type':'chessChat',
              'chat_msg':chat_msg,
              'gegener': <?php echo $_SESSION['gegener']; ?>,
              'sender': <?php echo $_SESSION['id']; ?>
            })
          );
    $('#text').val("");
}
});
$("#GiveUp").on('click', function(){
  $.post("chesswork.php",{lost : "<?php echo $_SESSION['color']; ?>"},function(data){},'text');
  websocket_server.send(
    JSON.stringify({
      'type': 'chessEnd',
      'lost': "<?php echo $_SESSION['pseudo']; ?>",
      'sender': <?php echo $_SESSION['id']; ?>,
      'gegener': <?php echo $_SESSION['gegener']; ?>
    })
  );
});
$("#replay").on('click', function(){
  websocket_server.send(
    JSON.stringify({
      'type': 'replay',
      'spseudo': "<?php echo $_SESSION['pseudo']; ?>",
      'sender': <?php echo $_SESSION['id']; ?>,
      'gegener': <?php echo $_SESSION['gegener']; ?>
    })
  );
  $(".one_duo").css({"display": "none"});
  document.getElementById('middContent').innerHTML += "<br>Waithing for the reponse...";
});
$("#yes_play").on('click', function(){
  $.post("chesswork.php",{yes_play : <?php echo $_SESSION['gegener']; ?>},function(data){
  	websocket_server.send(
    JSON.stringify({
      'type': 'are_ready',
      'sender': <?php echo $_SESSION['id']; ?>,
      'gegener': <?php echo $_SESSION['gegener']; ?>
    })
  );
  },'text');
});
$("#no_play").on("click", function(){
	websocket_server.send(
    JSON.stringify({
      'type': 'no_play',
      'gegener': <?php echo $_SESSION['gegener']; ?>
    })
  );
	$("#comeback").click();
 });
      websocket_server.onmessage = function(e)
      {
        var json = JSON.parse(e.data);
        switch(json.type) {
          case 'chessChat':
            $("#chat").append(json.msg);
            $("#chat").animate({
              scrollTop: $('#chat').height() +99999999+"px"
            }, "fast");
            if(document.getElementById("showChat")){
              $('#showChat').css('background','#5d6549');
            }
          break;
          case 'socket':
            window.location.replace("http://"+window.location.hostname+"/");
          break;
          case 'let_go':
            localStorage.removeItem("shift");
            localStorage.removeItem("fen");
            localStorage.removeItem("history");
            localStorage.removeItem("time");
            $.post("chesswork.php",{se : "a"},function(data){
            	window.location.assign("http://"+window.location.hostname+"/game.php");
            },'text');
          break;
          case 'no_play':
            $("#comeback").click();
          break;
          case 'chooseplay':
            document.getElementById('middContent').textContent = json.ps + " invite you to play another match";
            var one_duo = $(".one_duo");
            var one_duo_none = $(".one_duo_none");

            for (let i = 0; i < 2; i++) {
            	one_duo[i].className = "one_duo_none";
            	one_duo_none[i].className = "one_duo";
            }

          break;
          case 'chessEnd':
            setTimeout(function(){
            	$.post(
            		"chesswork.php",
            		{
            			matchend : "Bahamuth"
            		},
            		    function(gewinner){
            		      if (gewinner.length != 0) {
            		      	$("#thewiner").html(gewinner);
            		      	$("#op4").css("display","block");
            		      }
            		    },

            		'text'
            	);
            }, 1000);
          break;
          case 'chessMove':
            game.move({
            	from: json.move[0],
            	to: json.move[1],
            	promotion: json.move[2]
            });
            board.position(game.fen());

            getTime(true);
            historywriter();

            localStorage.setItem("time", document.getElementById("b").textContent+"/"+document.getElementById("w").textContent);

            if (game.in_checkmate()) {
            	$.post(
            		"chesswork.php",
            		{
            			lost : (game.turn()=='black' ? 'b' : 'w')
            		},
            		function(datam){

            		},

            	'text'
            	);
            	websocket_server.send(
            		JSON.stringify({
            			'type': 'chessEnd',
            			'lost': (game.turn()=='black' ? ( "<?php echo $_SESSION['color']; ?>" == 'b' ? "<?php echo $_SESSION['pgegener']; ?>" : "<?php echo $_SESSION['pseudo']; ?>" ) : ( "<?php echo $_SESSION['color']; ?>" == 'w' ? "<?php echo $_SESSION['pgegener']; ?>" : "<?php echo $_SESSION['pseudo']; ?>" ) ),
            			'sender': <?php echo $_SESSION['id']; ?>,
            			'gegener': <?php echo $_SESSION['gegener']; ?>
            		})
            	);
            }

            if(game.in_check()) {
            	var letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
            	for (let i = 1; i < 9; i++) {
            		for (let j = 0; j < 8; j++) {
            			if( (game.get(letters[j]+i).type).toUpperCase() == 'K' && game.get(letters[j]+i).color==game.turn()){
            				$(".square-"+letters[j]+i).css({"background" : "#bb0000"});
            				$(".square-"+(game.history({verbose})[-1]).to).css({"background" : "#bb0000"});
            				checkPieces[0] = letters[j]+i;
            				checkPieces[1] = (game.history({verbose})[-1]).to;
            			}
            		}
            	}
            }


            break;
        }
}

function ro(){
if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || (window.innerWidth < window.innerHeight) ){
  
  var w = parseInt(($(window).width())/8.5);
  var ss = (90-(($(window).width())*100)/($(window).height()-40));
  $(".mus").css({"position": "absolute", "top":"40px", "left":"0", "opacity":"0", "z-index":"-9999", "min-width":"100vw","height":"calc(100vh - 30px)"});
  $("#music").css({"height":"100%", "width":"100%","display":"block"});
  $("#limit").append($(".mus"));
  $("#appenddivs").append($(".chatbox"));
  $("#appenddivs").append("<div id='ap55'></div>");
  $(".chatbox").css({"min-width":"100vw","min-height":"100vh",'box-sizing':'border-box', "font-size": "14px", "font-weight": "500", 'display':'none', 'position':'absolute', 'top':'0px', 'z-index':'15000', 'border':'0', 'border-radius':'0px'});
  $(".chatbox").prepend("<button id='chatOut' style='height:50px; width:100%; background-color: #000119; font-size: 17px; font-weight: 900; color: #6e8c26; border-radius:0;'>Go back</button>")
  $("#envoyer").css("display", "none");
  $("#text").css({ "font-size": "11px", "font-weight": "500", 'height': "60px", 'width':'calc(100% - 2px)', 'position':'fixed', 'bottom':'0px', 'left':'1px'});
  $("#ap55").append($("#chrono"));
  $("#chrono").css({"height":"60px", "padding":"0", "width":"100%", "font-size": "10px", "display":"flex", "margin-bottom":"5px"});
  $("#chat").css({"border-top": "0", 'box-sizing':'border-box', 'height': "calc(100% - 150px)"});
  $("#limit").append($(".mus"));
  $('iframe').css("height","100%");
  $("#limit").append("<button id='soundCloud' class='showSoundCloud' style='position: absolute; top:0; z-index:9999; left:0; height:40px; width:100%; cursor:pointer; background-color:#000; font-size:15px; font-weight:700;'>SoundCloud</button>");
  $("#soundCloud").on("click", function(){if(this.className=="showSoundCloud"){ $(".mus").css({"opacity":"1", "display": "block", "z-index":"9999"}); this.setAttribute("class", "hideSoundCloud");}else{$(".mus").css({"opacity":"0", "display":"none" ,"z-index":"-9999"}); this.setAttribute("class", "showSoundCloud");}});
  $('img').css({"margin":"0"});
  $("#chesst").css({"padding-top":"0", 'box-shadow': '0px 0px 0px 0px #fff', 'border': '0', 'width': '88vw', 'height': '88vw'});
  $(".timePlayerBW").css({"width":"calc(100% / 3)","font-size": "12px", "display":"block", "border-radius":"0", "height":"100%", "background-color":"#0aa063", "border-color":"#35d090", "box-shadow":"0 0 0 0 #fff"});
  $("#mouves").css({"width":"calc(100% / 3)","font-size": "12px", "display":"block", "border-radius":"0", "height":"100%", "line-height": "200%", "background-color":"#0aa063", "border-color":"#35d090", "box-shadow":"0 0 0 0 #fff"});
  $(".nameBW").css({"height": "50%"});
  $("#appenddivs").css({"display": "flex", "height":"calc((100vh - 88vw)/2)", "margin-top": "15px"});
  $("#notationAlgebrique").css({"display": "none"});
  $("#limit").css("display", "block");
  $("#ap55").append(document.getElementById('buttons'));
  $("#GiveUp").css({"width": "45%"});
  $("#buttons").append("<button id='showChat'>Chat</button>");
  $("#ap55").append(document.getElementById('newpiece'));

  
  $('#showChat').on('click', function() {
  $(".chatbox").css('display','block');
  $('#showChat').css('background-color','');
});
  $('#chatOut').on('click', function() {
  $(".chatbox").css('display','none');
  $('#showChat').css('background-color','');
});
  $('#text').on('click', function(e) {
  setTimeout(function(){
    $("#chat").animate({
    scrollTop: $('#chat').height() +999999+"px"
}, "fast");
  }, 700);
});
  $('#text').on('keypress', function(e) {
  if(e.which == 13){
    e.preventDefault();
    $("#envoyer").click();
  }
});
}
}

$("#comeback").on("click", function(){
	window.location.assign("http://"+window.location.hostname+"/");
});

setTimeout(function(){
$("#muss").css('display','none');
}, 7000);

$(window).on("orientationchange",function(){
  window.location.reload();
});
ro();
</script>
</body>
</html>
<?php
}else{
	echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
?>