var pattern1 = /(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/g;
var pattern2 = /(?:http?s?:\/\/)?(?:www\.|m\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;
var pattern3 = /([-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?(?:jpg|jpeg|gif|png))/gi;

var pattern4 = /(?:http?s?:\/\/)?(?:www\.|)?(?:soundcloud\.com)\/?(.+)/g;

var videoEmbed = {
    invoke: function(){

        $('.post_text').html(function(i, html) {
          var el = document.getElementsByClassName('video_img')[i];
          if(html.length > 10 && el.innerHTML.length == 0){
            el.innerHTML = videoEmbed.convertMedia(html);
            var text_to_change = el.childNodes[0];
            if(typeof text_to_change != 'undefined'){
              text_to_change.nodeValue = '';
            }
            
           document.getElementsByClassName('post_text')[i].innerHTML = document.getElementsByClassName('post_text')[i].innerHTML.replace(pattern1, "");
           document.getElementsByClassName('post_text')[i].innerHTML = document.getElementsByClassName('post_text')[i].innerHTML.replace(pattern2, "");
           document.getElementsByClassName('post_text')[i].innerHTML = document.getElementsByClassName('post_text')[i].innerHTML.replace(pattern3, "");
          }
        });

    },
    invokeSecond: function(text){
      $('#p_wrip').html(function(i, html) {
          if(html.length > 10 ){
            if(document.getElementById('new_frame')){
              document.getElementById('new_frame').remove();
            }
            $('#p_wrip').after("<div id='new_frame' style='height: 300px; width: 100%;'></div>");
            el = document.getElementById('new_frame');
            element = document.getElementById('p_wrip');
            element.parentElement.style.height = 'auto';
            element.style.height = '150px';
            el.innerHTML = videoEmbed.convertMedia(html);
            var text_to_change = el.childNodes[0];
            text_to_change.nodeValue = '';

           document.getElementById('p_wrip').innerHTML = document.getElementById('p_wrip').innerHTML.replace(pattern1, "");
           document.getElementById('p_wrip').innerHTML = document.getElementById('p_wrip').innerHTML.replace(pattern2, "");
           document.getElementById('p_wrip').innerHTML = document.getElementById('p_wrip').innerHTML.replace(pattern3, "");

           $('#p_wrip').attr('forgottenData', ' '+text);
          }
        });
    },
    convertMedia: function(html){

        if(pattern1.test(html)){
           var replacement = '<iframe width="100%" height="300" src="//player.vimeo.com/video/$1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
           var html = html.replace(pattern1, replacement);
        }else if(pattern2.test(html)){
              var replacement = '<iframe width="100%" height="280" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>';
              var html = html.replace(pattern2, replacement);

        }else if(pattern3.test(html)){
            var replacement = '<a href="$1" target="_blank"><img width="100%" class="po_video_img" src="$1" /></a><br />';
            var html = html.replace(pattern3, replacement);
            
        }else if(pattern4.test(html)){
          var trackUrl = html.match(pattern4);
          var Client_ID = 'CLIENT_ID';
          $.get(
                'http://api.soundcloud.com/resolve.json?url=' + trackUrl + '&client_id=' + Client_ID, 
                function (result) {
                var replacement ='<iframe width="100%" height="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' + result.id +'&amp;color=ff6600&amp;auto_play=false&amp;show_artwork=true"></iframe>';//the iframe is copied from soundcloud embed codes
    }
);
        }else{
          html = "";
        }

        return html;      
    }
}





$(document).ready(function(){
var u =0;
$('#slidmenu').on('click', function() {

if (u%2 ==0) {
$("#menu").css("display", "flex");
$("#searchzone").css("display", "none");
$("#avatardiv").css("display", "none");
$("#switch").css("display", "none");
$("#mainheader").css("justify-content", "flex-start");
}
else{
  $("#menu").css("display", "none");
$("#searchzone").css("display", "block");
$("#avatardiv").css("display", "block");
$("#switch").css("display", "flex");
$("#mainheader").css("justify-content", "center");
}  
u++;
});

if($(window).width()<=500  &&  document.getElementById('conectf')){
  var menu = document.getElementById('menu');
  var cfm = document.getElementById('conectf');
  cfm.className = 'Important';
  var new_li = "<li id='con_f'><a href='#'>connected</a></li>";
  menu.children[0].children[0].children[3].remove();
  menu.children[0].children[0].innerHTML += new_li;
$("#con_f").on('click', function(){
    $("#limit").prepend("<div class='cover colorChange' style='height: 100%; padding: 0;'><div id='message_lien' style='height: 100%; width: 100% !important; left: 0;'><div style='display: flex;'><div style='width: calc(100% - 30px); height:40px; text-align: center; line-height: 40px;'>Connected Friends</div><div id='commentEnd' style='position: relative; top: 5px;'></div></div><div style='height: calc(100% - 40px); overflow-y:scroll; overflow-x:hidden; word-wrap: break-word;' id='friends_selection' class='C_phone'></div></div></div>");
    $("body").css('overflow-y', 'hidden');
    $('#commentEnd').on('click', function(){
   $(".cover").remove();
   $("body").css('overflow-y', 'scroll');
  });
document.getElementById('friends_selection').innerHTML = cfm.innerHTML;
});
}


$(document).on('paste','[contenteditable]',function(e) {
    e.preventDefault();
    var text = (e.originalEvent || e).clipboardData.getData('text/plain');
    window.document.execCommand('insertText', false, text);
});


var textsender = document.getElementById('textsender');
var textsenderP = document.getElementById('textsenderParent');
var iH= 0;

$("#textsender").on('keypress', function(e){
  if(e.which != 13){
  if($(textsender).innerHeight() < $("#wrightmessage").height() && $(textsender).innerHeight()>=38){
    $(textsenderP).css({'overflow-y':'hidden'});
    iH = $("#wrightmessage").height();
    $("#wrightmessage").css('height',$(textsender).innerHeight()+'px');
    $("#sendmessage").css({'min-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)",'max-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)"});
  }
  else if($(textsender).innerHeight() >= $(textsenderP).height() && $(textsender).innerHeight()<90){
    iH = $("#wrightmessage").height();
    $("#wrightmessage").css('height',$(textsender).innerHeight()+'px');
    $("#sendmessage").css({'min-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)",'max-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)"});
  }
  if($(textsender).innerHeight()>=88){
    $(textsenderP).css({'overflow-y':'scroll'});
  }
}
});
$("#textsender").on('keydown', function(e){ 
    setTimeout(function(){
       if($("#textsender").html().length>=1){
    $("#ImgAudioVideo").css('display', 'none');
    $(textsenderP).css({'width': 'calc(100% - 70px)'});
    }else if($("#ImgAudioVideo").css('display')=='none'){
      $("#ImgAudioVideo").css('display', 'flex');
    $(textsenderP).css({'width': 'calc(100% - 150px)'});
  }
    }, 100);
  if(e.which != 13){
  if($(textsender).innerHeight() < $("#wrightmessage").height() && $(textsender).innerHeight()>=38){
    $(textsenderP).css({'overflow-y':'hidden'});
    iH = $("#wrightmessage").height();
    $("#wrightmessage").css('height',$(textsender).innerHeight()+'px');
    $("#sendmessage").css({'min-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)",'max-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)"});
  }
  else if($(textsender).innerHeight() >= $(textsenderP).height() && $(textsender).innerHeight()<90){
    iH = $("#wrightmessage").height();
    $("#wrightmessage").css('height',$(textsender).innerHeight()+'px');
    $("#sendmessage").css({'min-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)",'max-height': "calc(100% - 50px - "+$("#wrightmessage").height()+"px)"});
  }
  if($(textsender).innerHeight()>=88){
    $(textsenderP).css({'overflow-y':'scroll'});
  }
}
});











function getPosition(element){
    var top = 0, left = 0;
    
    do {
        top  += element.offsetTop;
        left += element.offsetLeft;
    } while (element = element.offsetParent);
    
    return { x: left, y: top };
}
$("#emojiList").on('click', function(e){
if(e.target.id == 'emojiList'){
  setTimeout(function(){
var x=getPosition(document.getElementById("emojiList")).x, y=getPosition(document.getElementById("emojiList")).y;
  if($("#faceList").css('display')=='none'){
    $("#faceList").css({'display': 'block', 'top': y-220+"px", 'left': x-150+"px"});
  }else{
    $("#faceList").css('display', 'none');
  }
  }, 500);
}
});
for (var i = 600; i <= 640; i++) {
  $("#faceList").append("&#x1F"+i+";");
  if(i==640){
    setTimeout(function(){
      $(".emoji").on('click', function(){
  var emo = this.alt;
  $(textsender).append(emo);
});
    }, 5000);
  }
}



window.onload = function() {
  twemoji.size = '72x72';
  twemoji.parse(document.body);
}

var nigh = localStorage.getItem("nightmode");
if (nigh == 1) {
  var nombre = 1;
  $("#before").css({"transform": "translateX(31px)", "background-color":"black"});
  $(".slider").css({"background-color":"white"});
 $('HEAD').append("<link id='nightStyle' rel='stylesheet' type='text/css' href='nightstyle.css'>");
}else{
  localStorage.setItem("nightmode", 0);
  var nombre = 0;
  $("#before").css({"transform": "translateX(0)", "background-color":"white"});
  $(".slider").css({"background-color":"grey"});
}

$('.slider').on('click', function() {
  nombre++;
if ((nombre % 2) == 1) {
localStorage.setItem("nightmode", 1);
                  $("#before").css({"transform": "translateX(31px)", "background-color":"black"});
                  $(".slider").css({"background-color":"white"});
                  $('HEAD').append("<link id='nightStyle' rel='stylesheet' type='text/css' href='nightstyle.css'>");

}
if ((nombre % 2) == 0) {
localStorage.setItem("nightmode", 0);
                  $("#before").css({"transform": "translateX(0)", "background-color":"white"});
                  $(".slider").css({"background-color":"grey"});
                  $("#nightStyle").remove();

}
});



$(".showImage").on("click", function(){
var imageId = this.className.split(" ")[1];
$("#li2").prepend("<div class='full'></div>");
$("#li2").prepend("<div id='fullS' class='lightbox'><div class='lightboxWindow'><img id='imageSize' class='smallSize' src='profilesimages/"+imageId+"'></div></div>");
var img = document.getElementById('imageSize');
setTimeout(function(){
var width = img.clientWidth;
var height = img.clientHeight;
$('body').css("overflow", "hidden");
if(window.innerHeight < window.innerWidth){
if (window.innerHeight < height) {
  var newHeight = innerHeight;
  var newWidth = width/(height/innerHeight);
  var r = height/innerHeight;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}else if(window.innerWidth < width){
  var newWidth = innerWidth;
  var newHeight = height/(width/innerWidth);
  var r = width/innerWidth;
  var margin = (window.innerHeight - newHeight)/2;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}else{
  var newWidth = width;
  var newHeight = height;
  var margin = (window.innerHeight - newHeight)/2;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}
$("#imageSize").on("click", function(e){
  if($(window).width()>800 || !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))){
  if(this.className=="smallSize"){
    $(".lightbox").animate({scrollTop:((e.pageY-getPosition(this).y)*r)-(window.innerHeight)/2}, 'slow');
    $(".lightbox").animate({scrollLeft:((e.pageX-getPosition(this).x)*r)-(window.innerWidth)/2}, 'slow');
  $(".lightboxWindow").css({"height": +height+"px", "width": +width+"px"});
  $("#imageSize").css({"height": +height+"px", "width": +width+"px", "cursor":"zoom-out"});
  $(".lightbox").css({"overflow-y": "scroll"});
  $("#imageSize").attr("class", "originalSize");
}else{
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
  $(".lightbox").css({"overflow": "hidden"});
  $("#imageSize").attr("class", "smallSize");
}
}
});
$(".lightbox").on('click', function(e){
if(e.target.className=="lightbox"){
  $(".lightbox").remove();
  $(".full").remove();
  $('body').css("overflow-y", "scroll");
}
});
}


if(window.innerHeight > window.innerWidth){
if (window.innerWidth < width) {
  var newWidth = innerWidth;
  var newHeight = height/(width/innerWidth);
  var margin = (window.innerHeight - newHeight)/2;
  var r = width/innerWidth;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}else if(window.innerHeight < height){
  var newHeight = innerHeight;
  var newWidth = width/(height/innerHeight);
  var r = height/innerHeight;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}else{
  var newWidth = width;
  var newHeight = height;
  var margin = (window.innerHeight - newHeight)/2;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}
$("#imageSize").on("click", function(e){
  if($(window).width()>800 || !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))){
  if(this.className=="smallSize"){
    $(".lightbox").animate({scrollTop:(((e.pageY-getPosition(this).y)*r)-(getPosition(this).y))/2}, 'slow');
    $(".lightbox").animate({scrollLeft:((e.pageX-getPosition(this).x)*r)-(window.innerWidth)/2}, 'slow');
  $(".lightboxWindow").css({"height": +height+"px", "width": +width+"px"});
  $("#imageSize").css({"height": +height+"px", "width": +width+"px", "cursor":"zoom-out"});
  $(".lightbox").css({"overflow-y": "scroll"});
  $("#imageSize").attr("class", "originalSize");
}else{
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
  $(".lightbox").css({"overflow": "hidden"});
  $("#imageSize").attr("class", "smallSize");
}
}
});
$(".lightbox").on('click', function(e){
if(e.target.className=="lightbox"){
  $(".lightbox").remove();
  $(".full").remove();
  $('body').css("overflow-y", "scroll");
}
});
}
}, 500);
});
$(document).keyup(function(e) {
     if (e.keyCode == 27) { 
$(".lightbox").remove();
  $(".full").remove();
  $('body').css("overflow-y", "scroll");
    }
});
$("#large").on("click", function(){
    if (($('#labe').length>=1 && $('#labe').attr("for")!="largeimagefile") || ($('#labe').length<1) ) {
var imageId = this.className;
$("#li2").prepend("<div class='full'></div>");
$("#li2").prepend("<div id='fullS' class='lightbox'><div class='lightboxWindow'><img id='imageSize' class='smallSize' src='profilesimages/"+imageId+"'></div></div>");
var img = document.getElementById('imageSize');
setTimeout(function(){
var width = img.clientWidth;
var height = img.clientHeight;
$('body').css("overflow", "hidden");
if(window.innerHeight < window.innerWidth){
if (window.innerHeight < height) {
  var newHeight = innerHeight;
  var newWidth = width/(height/innerHeight);
  var r = height/innerHeight;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}else if(window.innerWidth < width){
  var newWidth = innerWidth;
  var newHeight = height/(width/innerWidth);
  var r = width/innerWidth;
  var margin = (window.innerHeight - newHeight)/2;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}else{
  var newWidth = width;
  var newHeight = height;
  var margin = (window.innerHeight - newHeight)/2;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}
$("#imageSize").on("click", function(e){
  if($(window).width()>800 || !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))){
  if(this.className=="smallSize"){
    $(".lightbox").animate({scrollTop:((e.pageY-getPosition(this).y)*r)-(window.innerHeight)/2}, 'slow');
    $(".lightbox").animate({scrollLeft:((e.pageX-getPosition(this).x)*r)-(window.innerWidth)/2}, 'slow');
  $(".lightboxWindow").css({"height": +height+"px", "width": +width+"px"});
  $("#imageSize").css({"height": +height+"px", "width": +width+"px", "cursor":"zoom-out"});
  $(".lightbox").css({"overflow-y": "scroll"});
  $("#imageSize").attr("class", "originalSize");
}else{
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
  $(".lightbox").css({"overflow": "hidden"});
  $("#imageSize").attr("class", "smallSize");
}
}
});
$(".lightbox").on('click', function(e){
if(e.target.className=="lightbox"){
  $(".lightbox").remove();
  $(".full").remove();
  $('body').css("overflow-y", "scroll");
}
});
}


if(window.innerHeight > window.innerWidth){
if (window.innerWidth < width) {
  var newWidth = innerWidth;
  var newHeight = height/(width/innerWidth);
  var margin = (window.innerHeight - newHeight)/2;
  var r = width/innerWidth;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}else if(window.innerHeight < height){
  var newHeight = innerHeight;
  var newWidth = width/(height/innerHeight);
  var r = height/innerHeight;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}else{
  var newWidth = width;
  var newHeight = height;
  var margin = (window.innerHeight - newHeight)/2;
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
}
$("#imageSize").on("click", function(e){
  if($(window).width()>800 || !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))){
  if(this.className=="smallSize"){
    $(".lightbox").animate({scrollTop:(((e.pageY-getPosition(this).y)*r)-(getPosition(this).y))/2}, 'slow');
    $(".lightbox").animate({scrollLeft:((e.pageX-getPosition(this).x)*r)-(window.innerWidth)/2}, 'slow');
  $(".lightboxWindow").css({"height": +height+"px", "width": +width+"px"});
  $("#imageSize").css({"height": +height+"px", "width": +width+"px", "cursor":"zoom-out"});
  $(".lightbox").css({"overflow-y": "scroll"});
  $("#imageSize").attr("class", "originalSize");
}else{
  $(".lightboxWindow").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  $("#imageSize").css({"height": +newHeight+"px", "width": +newWidth+"px", "cursor":"zoom-in"});
  $(".lightbox").css({"overflow": "hidden"});
  $("#imageSize").attr("class", "smallSize");
}
}
});
$(".lightbox").on('click', function(e){
if(e.target.className=="lightbox"){
  $(".lightbox").remove();
  $(".full").remove();
  $('body').css("overflow-y", "scroll");
}
});
}
}, 500);
    }
});

$("#textsender").on('click', function(){
setTimeout(function(){
var nnn = document.getElementById("sendmessage").scrollHeight;
$("#sendmessage").animate({scrollTop:nnn}, 'fast');  
}, 700);
});

$('.au').on('loadeddata', function(){
    this.removeAttribute("controls");
  });

$("#goback2").on("click", function(){
  $("#navi").css("justify-content", "flex-end");
$("#sendmessage").css("display", "none");
$("#Okoi").css("display", "none");
$("#wrightmessage").css("display", "none");
$("#goback2").css("display", "none");
$("#lastmessages").css("display", "block");
$("#nm1").css("display", "block");
$("#messages").click();
});
$("#goback1").on("click", function(){
  $("#navi").css("justify-content", "flex-end");
});


var op = document.getElementById('op');
var messages = document.getElementById('messages');
messages.addEventListener('click', function() {
  op.style.display = 'block';
  $.post("chatwork.php", {lastmes: "Bahamuth"}, function(data){
    $("#lastmessages").html("");
    $("#lastmessages").append(data);
    twemoji.parse(document.body);
    $(".lm").on("click", function(){
      $("#navi").css("justify-content", "space-between");
      id = this.id;
      userId= id.split(",")[1];
      $("#navi").attr("class", "nav,"+userId);
      $(this).css("background-color", "");
      $.post("chatwork.php", {q: userId}, function(datas){
        $.post("chatwork.php", {Okoi: userId}, function(image){
          $("#Okoi").css({'display':'block', 'background-image': "url(profilesimages/"+image+")"});
        },'text');
        $("#sendmessage").html();
        $("#sendmessage").html(datas);
        $( ".chatPhoto" ).each(function() {
          var img = this;
          var wf = $("#fenetre").width()/2;
  img.onload = function(){
    if(img.width > wf){img.height = img.height*wf/img.width; img.width=wf;}
            if(img.height>$('#sendmessage').height()){img.height = $('#sendmessage').height(); img.width = img.width*$('#sendmessage').height()/img.height;}
    var nnn = document.getElementById("sendmessage").scrollHeight;
$("#sendmessage").animate({scrollTop:nnn}, 'fast');
  }
});
$( "audio" ).each(function() {
  var aud = this;
  var src = this.id.split(",")[1];
  aud.load();
  var ini = false;
$(aud).on('loadedmetadata', function(){
  if(ini) return;
  ini = true;
  if(aud.duration === Infinity){

      aud.currentTime = 0;
      aud.playbackRate = 16;
      aud.volume =0;
      aud.play();
      var ny=0;
      aud.ontimeupdate = function(){
          ny=aud.currentTime;
        }

      }else{
       var ny=aud.duration;
       var reader = "<div class='audioPlayer "+aud.className+"'><div id="+src+" data='"+ny+"' class='audioPlay'></div><div id='PT"+src+"' class='progressTime'>0:00</div><div id='PTr"+src+"' class='progressTrack'><div id='PB"+src+"' class='progressBar'></div></div><div class='audioTotalTime'>"+formatTime(ny)+"</div></div>";
aud.removeAttribute("controls");
            $(this).after(reader);
        play();  
$('.progressBar').on('click', function(event){
  clickProgress(document.getElementById("audio,"+this.id.replace("PB", "")), document.getElementById(this.id), document.getElementById(this.id.replace("PB", "PTr")), event, document.getElementById(this.id.replace("PB", "PT")));
});

$('.progressTrack').on('click', function(event){
  if(this.id[1]=='T'){
    clickProgress(document.getElementById("audio,"+this.id.replace("PTr", "")), document.getElementById(this.id.replace("PTr", "PB")), document.getElementById(this.id), event, document.getElementById(this.id.replace("PTr", "PT")));
  }
}); var i=2;
      }
      if(i!=2){var i =0;}
$(aud).on('ended', function(){
  if(i==0){
    i=1;
  aud.currentTime =0;
  aud.playbackRate = 1;
  aud.volume =1;
  var reader = "<div class='audioPlayer "+aud.className+"'><div id="+src+" data='"+ny+"' class='audioPlay'></div><div id='PT"+src+"' class='progressTime'>0:00</div><div id='PTr"+src+"' class='progressTrack'><div id='PB"+src+"' class='progressBar'></div></div><div class='audioTotalTime'>"+formatTime(ny)+"</div></div>";
aud.removeAttribute("controls");
            $(this).after(reader);
            var nnn = document.getElementById("sendmessage").scrollHeight;
            $("#sendmessage").animate({scrollTop:nnn}, 'fast');
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
});
twemoji.parse(document.body);
$("#lastmessages").css("display", "none");
$("#nm1").css("display", "none");
$("#goback2").css("display", "block");
$("#sendmessage").css("display", "block");
$("#wrightmessage").css("display", "flex");
var nnn = document.getElementById("sendmessage").scrollHeight;
$("#sendmessage").animate({scrollTop:nnn}, 'fast');

            },

            'text'
         );
});
            },

            'text'
         );
  });
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

var out = document.getElementById('out');
out.addEventListener('click', function() {
  op.style.display = 'none';
});

$('#play').on('mouseenter', function() {
  document.getElementById('ns').style.display = 'block';
});
$('#play').on('mouseleave', function() {
  document.getElementById('ns').style.display = 'none';
});


       var goback1 = document.getElementById('goback1');
       var searchuser = document.getElementById('searchuser');
       var lastmessages = document.getElementById('lastmessages');
       var nm1 = document.getElementById('nm1');
       nm1.addEventListener('click', function() {
        $("#navi").css("justify-content", "space-between");
        $.post(
  "chatwork.php",
    {
        listfriend: "Bahamuth"
    },
                function(data){
$("#searchuser").html("");               
$("#searchuser").append(data);
$(".user").on("click", function(){
  id = this.id;
  userId= id.split(",")[1];
  $("#navi").attr("class", "nav,"+userId);
  $.post(
  "chatwork.php",
    {
        q: userId
    },
                function(datas){
                  $.post(
  "chatwork.php",
    {
        Okoi: userId
    },
                function(image){
                  $("#Okoi").css({'display':'block', 'background-image': "url(profilesimages/"+image+")"});
},

            'text'
         );
$("#sendmessage").html();
$("#sendmessage").html(datas);
$( ".chatPhoto" ).each(function() {
  var img = this;
  var wf = $("#fenetre").width()/2;
  img.onload = function(){
    if(img.width > wf){img.height = img.height*wf/img.width; img.width=wf;}
    if(img.height>$('#sendmessage').height()){img.height = $('#sendmessage').height(); img.width = img.width*$('#sendmessage').height()/img.height;}
    var nnn = document.getElementById("sendmessage").scrollHeight;
$("#sendmessage").animate({scrollTop:nnn}, 'fast');
  }
});
$( "audio" ).each(function() {
  var aud = this;
  var src = this.id.split(",")[1];
  aud.load();
  var ini = false;
$(aud).on('loadedmetadata', function(){
  if(ini) return;
  ini = true;
  if(aud.duration === Infinity){

      aud.currentTime = 0;
      aud.playbackRate = 16;
      aud.volume =0;
      aud.play();
      var ny=0;
      aud.ontimeupdate = function(){
          ny=aud.currentTime;
        }

      }else{
       var ny=aud.duration;
       var reader = "<div class='audioPlayer "+aud.className+"'><div id="+src+" data='"+ny+"' class='audioPlay'></div><div id='PT"+src+"' class='progressTime'>0:00</div><div id='PTr"+src+"' class='progressTrack'><div id='PB"+src+"' class='progressBar'></div></div><div class='audioTotalTime'>"+formatTime(ny)+"</div></div>";
aud.removeAttribute("controls");
            $(this).after(reader);
            var nnn = document.getElementById("sendmessage").scrollHeight;
            $("#sendmessage").animate({scrollTop:nnn}, 'fast');
        play();  
$('.progressBar').on('click', function(event){
  clickProgress(document.getElementById("audio,"+this.id.replace("PB", "")), document.getElementById(this.id), document.getElementById(this.id.replace("PB", "PTr")), event, document.getElementById(this.id.replace("PB", "PT")));
});

$('.progressTrack').on('click', function(event){
  if(this.id[1]=='T'){
    clickProgress(document.getElementById("audio,"+this.id.replace("PTr", "")), document.getElementById(this.id.replace("PTr", "PB")), document.getElementById(this.id), event, document.getElementById(this.id.replace("PTr", "PT")));
  }
}); var i=2;
      }
     if(i != 2){var i =0;}
$(aud).on('ended', function(){
  if(i==0){
    i=1;
  aud.currentTime =0;
  aud.playbackRate = 1;
  aud.volume =1;
  var reader = "<div class='audioPlayer "+aud.className+"'><div id="+src+" data='"+ny+"' class='audioPlay'></div><div id='PT"+src+"' class='progressTime'>0:00</div><div id='PTr"+src+"' class='progressTrack'><div id='PB"+src+"' class='progressBar'></div></div><div class='audioTotalTime'>"+formatTime(ny)+"</div></div>";
aud.removeAttribute("controls");
            $(this).after(reader);
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
});
twemoji.parse(document.body);
$("#searchuser").css("display", "none");
$("#goback1").css("display", "none");
$("#goback2").css("display", "block");
$("#sendmessage").css("display", "block");
$("#wrightmessage").css("display", "flex");
var nnn = document.getElementById("sendmessage").scrollHeight;
$("#sendmessage").animate({scrollTop:nnn}, 'fast');

            },

            'text'
         );
});
            },

            'text'
         );
        lastmessages.style.display = 'none';
        searchuser.style.display = 'block';
        
        nm1.style.display ='none';
        goback1.style.display = 'block';
  });

        goback1.addEventListener('click', function() {
        lastmessages.style.display = 'block';
        searchuser.style.display = 'none';
        
        nm1.style.display ='block';
        goback1.style.display = 'none';         
  });
function getPosition(element){
    var top = 0, left = 0;
    
    do {
        top  += element.offsetTop;
        left += element.offsetLeft;
    } while (element = element.offsetParent);
    
    return { x: left, y: top };
}
var g="fff";
function interval(arr, k, bw, wb){
  var st =  setTimeout(function(){
      if($('#'+k).attr("class")=="halt"){
        u = Number(document.getElementById(k).getAttribute("nc"));
if(arr[u+1]==0){
  if(Number(arr[u])==2 || Number(arr[u])==3){
    if(arr[0]=='noir'){
      if(u%4==1 && Number(arr[u])==2){
        document.getElementById("B8"+g+k).append(document.getElementById("D8"+','+k));
        document.getElementById("C8"+g+k).append(document.getElementById("A8"+','+k));
        document.getElementById("A8"+','+k).setAttribute("id", "C8"+','+k);
        document.getElementById("D8"+','+k).setAttribute("id", "B8"+','+k);
      }else if(u%4==1 && Number(arr[u])==3){
        document.getElementById("F8"+g+k).append(document.getElementById("D8"+','+k));
        document.getElementById("E8"+g+k).append(document.getElementById("H8"+','+k));
        document.getElementById("H8"+','+k).setAttribute("id", "E8"+','+k);
        document.getElementById("D8"+','+k).setAttribute("id", "F8"+','+k);
      }else if(Number(arr[u])==2){
        document.getElementById("B1"+g+k).append(document.getElementById("D1"+','+k));
        document.getElementById("C1"+g+k).append(document.getElementById("A1"+','+k));
        document.getElementById("A1"+','+k).setAttribute("id", "C1"+','+k);
        document.getElementById("D1"+','+k).setAttribute("id", "B1"+','+k);
      }else if(Number(arr[u])==3){
        document.getElementById("F1"+g+k).append(document.getElementById("D1"+','+k));
        document.getElementById("E1"+g+k).append(document.getElementById("H1"+','+k));
        document.getElementById("H1"+','+k).setAttribute("id", "E1"+','+k);
        document.getElementById("D1"+','+k).setAttribute("id", "F1"+','+k);
      }
    }else{
      if(u%4==1 && Number(arr[u])==2){
        document.getElementById("G1"+g+k).append(document.getElementById("E1"+','+k));
        document.getElementById("F1"+g+k).append(document.getElementById("H1"+','+k));
        document.getElementById("H1"+k).setAttribute("id", "F1"+','+k);
        document.getElementById("E1"+k).setAttribute("id", "G1"+','+k);
      }else if(u%4==1 && Number(arr[u])==3){
        document.getElementById("C1"+g+k).append(document.getElementById("E1"+','+k));
        document.getElementById("D1"+g+k).append(document.getElementById("A1"+','+k));
        document.getElementById("A1"+k).setAttribute("id", "D1"+','+k);
        document.getElementById("E1"+k).setAttribute("id", "C1"+','+k);
      }else if(Number(arr[u])==2){
        document.getElementById("G8"+g+k).append(document.getElementById("E8"+','+k));
        document.getElementById("F8"+g+k).append(document.getElementById("H8"+','+k));
        document.getElementById("H8"+k).setAttribute("id", "F8"+','+k);
        document.getElementById("E8"+k).setAttribute("id", "G8"+','+k);
      }else if(Number(arr[u])==3){
        document.getElementById("C8"+g+k).append(document.getElementById("E8"+','+k));
        document.getElementById("D8"+g+k).append(document.getElementById("A8"+','+k));
        document.getElementById("A8"+k).setAttribute("id", "D8"+','+k);
        document.getElementById("E8"+k).setAttribute("id", "C8"+','+k);
      }
    }
    
  }
else if(arr[u].split("_").length==2){
    $('#'+arr[u][2]+arr[u][3]+g+k).html("");
    $('#'+arr[u][2]+arr[u][1]+g+k).html("");
      $('#'+arr[u][2]+arr[u][3]+g+k).append(document.getElementById(arr[u][0]+arr[u][1]+','+k));
      document.getElementById(arr[u][0]+arr[u][1]+','+k).setAttribute("id", arr[u][2]+arr[u][3]+','+k);
    }
else if(u<arr.length-1){
      $('#'+arr[u][2]+arr[u][3]+g+k).html("");
      $('#'+arr[u][2]+arr[u][3]+g+k).append(document.getElementById(arr[u][0]+arr[u][1]+','+k));
      document.getElementById(arr[u][0]+arr[u][1]+','+k).setAttribute("id", arr[u][2]+arr[u][3]+','+k);
    }

}else{
  $("#"+arr[u][2]+arr[u][3]+g+k).html("");
  $("#"+arr[u][0]+arr[u][1]+g+k).html("");
  $("#"+arr[u][2]+arr[u][3]+g+k).append("<img class="+arr[u+1][0]+" id="+arr[u][2]+arr[u][3]+","+k+" ondragstart='drag(event)' draggable='true' src='img/chesspieces/wikipedia/"+arr[u+1][0]+arr[u+1][1]+".png'>");
}
      u=u+2;
      document.getElementById(k).setAttribute("nc", u);
    if(u<arr.length-1){
      interval(arr, k, bw, wb);
    }
    else{
      u=1;
      document.getElementById(k).setAttribute("nc", u);
setTimeout(function(){
if($('#'+k).attr("class")=="halt"){
      $("#"+k).click();
}
      $('#pB'+k).attr("currentTime", 0);
      $('#pB'+k).css("width", 0);
       $('.carres'+k).html("");
       var g="fff";
       var arri= ['A','B','C','D','E','F','G','H'];
for (var c=0; c<8; c++) { 
$("#"+arri[c]+2+g+k).append("<img id="+arri[c]+2+','+k+"  class="+bw+"  src='img/chesspieces/wikipedia/"+bw+"P.png'>");
}

for (var c=0; c<8; c++) { 
$("#"+arri[c]+7+g+k).append("<img id="+arri[c]+7+','+k+" class="+wb+"  src='img/chesspieces/wikipedia/"+wb+"P.png'>");
}

for (var c=0; c<8; c++) {
  if (c==0) {pi=(bw+"R");}if (c==1) {pi=(bw+"N");}if (c==2) {pi=(bw+"B");}if (c==3) {if(bw=="w"){pi=(bw+"Q");}else{pi=(bw+"K");}}if (c==4) {if(bw=="w"){pi=(bw+"K");}else{pi=(bw+"Q");}}if (c==5) {pi=(bw+"B");}if (c==6) {pi=(bw+"N");}if (c==7) {pi=(bw+"R");}
$("#"+arri[c]+1+g+k).append("<img id="+arri[c]+1+','+k+" class="+bw+"  src='img/chesspieces/wikipedia/"+pi+".png'>");
}

for (var c=0; c<8; c++) {
  if (c==0) {pi=(wb+"R");}if (c==1) {pi=(wb+"N");}if (c==2) {pi=(wb+"B");}if (c==3) {if(bw=="w"){pi=(wb+"Q");}else{pi=(wb+"K");}}if (c==4) {if(bw=="w"){pi=(wb+"K");}else{pi=(wb+"Q");}}if (c==5) {pi=(wb+"B");}if (c==6) {pi=(wb+"N");}if (c==7) {pi=(wb+"R");}
$("#"+arri[c]+8+g+k).append("<img id="+arri[c]+8+','+k+" class="+wb+"  src='img/chesspieces/wikipedia/"+pi+".png'>");
}
}, 3000);
    }
} else{
  clearTimeout(st);
}
    }, 3000);
  }


var arur= ['H', 'G', 'F', 'E', 'D', 'C', 'B', 'A'] 
var arir= ['A','B','C','D','E','F','G','H'];
setTimeout(function(){
 
$(document.body).on('click', "[which=bh]", function(){
clearInterval(wss);
  

  var u=Number(this.getAttribute("nc"));
  
  var k= this.id;
  var data=this.getAttribute("data");
  var arr = data.split(",");
  var i=1;
  var p=1;
  var changement;
  if(arr[0]=="noir"){
   bw="b";
    wb="w";
  }else{
    bw="w";
    wb="b";
  }
  if(arr[0]=="noir"){
   bw="b";
    wb="w";
    while(arr.length > i){
      if(i == (p*4-1)){
        changement=arr[i];
        if(changement!=2 && changement!=3){
          arr[i]=arur[arir.indexOf(changement[0])]+(9-Number(changement[1]))+arur[arir.indexOf(changement[2])]+(9-Number(changement[3]));
        }
        p++;
      }
      i++;
    }
  }
  else if(arr[0]=="blanc"){
    bw="w";
    wb="b";
    while(arr.length > i){
      if(i == (p*4-3)){
        changement=arr[i];
        if(Number(changement)!=2 && Number(changement)!=3){
         arr[i]=arur[arir.indexOf(changement[0])]+(9-Number(changement[1]))+arur[arir.indexOf(changement[2])]+(9-Number(changement[3])); 
        }  
        p++;
      }
      i++;
    }
  }

if(this.className=="begin"){
    $('#'+this.id).attr("class", "halt");
   interval(arr, k, bw, wb);
  }
  else{
    $('#'+this.id).attr("class", "begin");
    
  }
  
var it=Number($('#pB'+k).attr("currentTime"));  
var alltime= Number($('#pB'+k).parent().attr("alltime"))*3;
var width = Number($('#prBChess').width());


var wss= setInterval(function(){
if($('#'+k).attr("class")=="halt" ){
  it=Number($('#pB'+k).attr("currentTime"));
  it=it+0.1;
  $('#pB'+k).attr("currentTime", it);
  var barwidth = it*width/alltime;
  $('#pB'+k).css("width", barwidth+"px");
  if (it >= alltime) {
    clearInterval(wss);
  }
}
else{
  clearInterval(wss);
}
}, 100);
});

var g="fff";
function getMousePosition(event) {
    return {
        x: event.pageX,
        y: event.pageY
    };
}


$(document.body).on('click', '.pB', function(){
  var ut =0;
var k = $('#'+this.id).parent().attr("lek");
  if($("#"+k).attr("class")=="halt"){
    $("#"+k).click();
   ut=12;
  }
  
  color = $("#"+k).attr("data").split(",");
if (color[0]=="blanc") {
    bw="w";
    wb="b";
  }
  else{
    bw="b";
    wb="w";
  }

  var i=1;
  var p=1;
  var changement;
  if(color[0]=="noir"){
    while(color.length > i){
      if(i == (p*4-1)){
        changement=color[i];
        if(Number(changement)!=2 && Number(changement)!=3){
color[i]=arur[arir.indexOf(changement[0])]+(9-Number(changement[1]))+arur[arir.indexOf(changement[2])]+(9-Number(changement[3]));
        }
        
        p++;
      }
      i++;
    }
  }
  else if(color[0]=="blanc"){
    while(color.length > i){
      if(i == (p*4-3)){
        changement=color[i];
        if(Number(changement)!=2 && Number(changement)!=3){
color[i]=arur[arir.indexOf(changement[0])]+(9-Number(changement[1]))+arur[arir.indexOf(changement[2])]+(9-Number(changement[3]));
        }
        
        p++;
      }
      i++;
    }
  }

  var parent = getPosition(this);
  var target = getMousePosition(event);
  var x = target.x - parent.x; 
  var wrapperWidth = document.querySelector('#prBChess').offsetWidth;
  var duration = Number($('#'+this.id).parent().attr("alltime"))*3;
  var newDuration = duration*x/wrapperWidth;
  var n = Math.round(newDuration/3);
  var u=1;
  var ij=1;
  $('.carres'+k).html("");
  var arr= ['A','B','C','D','E','F','G','H'];
var g="fff";
for (var c=0; c<8; c++) { 
$("#"+arr[c]+2+g+k).append("<img id="+arr[c]+2+','+k+"  class="+bw+"  src='img/chesspieces/wikipedia/"+bw+"P.png'>");
}

for (var c=0; c<8; c++) { 
$("#"+arr[c]+7+g+k).append("<img id="+arr[c]+7+','+k+" class="+wb+"  src='img/chesspieces/wikipedia/"+wb+"P.png'>");
}

for (var c=0; c<8; c++) {
  if (c==0) {pi=(bw+"R");}if (c==1) {pi=(bw+"N");}if (c==2) {pi=(bw+"B");}if (c==3) {if(bw=="w"){pi=(bw+"Q");}else{pi=(bw+"K");}}if (c==4) {if(bw=="w"){pi=(bw+"K");}else{pi=(bw+"Q");}}if (c==5) {pi=(bw+"B");}if (c==6) {pi=(bw+"N");}if (c==7) {pi=(bw+"R");}
$("#"+arr[c]+1+g+k).append("<img id="+arr[c]+1+','+k+" class="+bw+"  src='img/chesspieces/wikipedia/"+pi+".png'>");
}

for (var c=0; c<8; c++) {
  if (c==0) {pi=(wb+"R");}if (c==1) {pi=(wb+"N");}if (c==2) {pi=(wb+"B");}if (c==3) {if(bw=="w"){pi=(wb+"Q");}else{pi=(wb+"K");}}if (c==4) {if(bw=="w"){pi=(wb+"K");}else{pi=(wb+"Q");}}if (c==5) {pi=(wb+"B");}if (c==6) {pi=(wb+"N");}if (c==7) {pi=(wb+"R");}
$("#"+arr[c]+8+g+k).append("<img id="+arr[c]+8+','+k+" class="+wb+"  src='img/chesspieces/wikipedia/"+pi+".png'>");
}
while(ij <= n){
if(color[u+1]==0){
  if(Number(color[u])==2 || Number(color[u])==3){
    if(color[0]=='noir'){
      if(u%4==1 && Number(color[u])==2){
        document.getElementById("B8"+g+k).append(document.getElementById("D8"+','+k));
        document.getElementById("C8"+g+k).append(document.getElementById("A8"+','+k));
        document.getElementById("A8"+','+k).setAttribute("id", "C8"+','+k);
        document.getElementById("D8"+','+k).setAttribute("id", "B8"+','+k);
      }else if(u%4==1 && Number(color[u])==3){
        document.getElementById("F8"+g+k).append(document.getElementById("D8"+','+k));
        document.getElementById("E8"+g+k).append(document.getElementById("H8"+','+k));
        document.getElementById("H8"+','+k).setAttribute("id", "E8"+','+k);
        document.getElementById("D8"+','+k).setAttribute("id", "F8"+','+k);
      }else if(Number(color[u])==2){
        document.getElementById("B1"+g+k).append(document.getElementById("D1"+','+k));
        document.getElementById("C1"+g+k).append(document.getElementById("A1"+','+k));
        document.getElementById("A1"+','+k).setAttribute("id", "C1"+','+k);
        document.getElementById("D1"+','+k).setAttribute("id", "B1"+','+k);
      }else if(Number(color[u])==3){
        document.getElementById("F1"+g+k).append(document.getElementById("D1"+','+k));
        document.getElementById("E1"+g+k).append(document.getElementById("H1"+','+k));
        document.getElementById("H1"+','+k).setAttribute("id", "E1"+','+k);
        document.getElementById("D1"+','+k).setAttribute("id", "F1"+','+k);
      }
    }else{
      if(u%4==1 && Number(color[u])==2){
        document.getElementById("G1"+g+k).append(document.getElementById("E1"+','+k));
        document.getElementById("F1"+g+k).append(document.getElementById("H1"+','+k));
        document.getElementById("H1"+k).setAttribute("id", "F1"+','+k);
        document.getElementById("E1"+k).setAttribute("id", "G1"+','+k);
      }else if(u%4==1 && Number(color[u])==3){
        document.getElementById("C1"+g+k).append(document.getElementById("E1"+','+k));
        document.getElementById("D1"+g+k).append(document.getElementById("A1"+','+k));
        document.getElementById("A1"+k).setAttribute("id", "D1"+','+k);
        document.getElementById("E1"+k).setAttribute("id", "C1"+','+k);
      }else if(Number(color[u])==2){
        document.getElementById("G8"+g+k).append(document.getElementById("E8"+','+k));
        document.getElementById("F8"+g+k).append(document.getElementById("H8"+','+k));
        document.getElementById("H8"+k).setAttribute("id", "F8"+','+k);
        document.getElementById("E8"+k).setAttribute("id", "G8"+','+k);
      }else if(Number(color[u])==3){
        document.getElementById("C8"+g+k).append(document.getElementById("E8"+','+k));
        document.getElementById("D8"+g+k).append(document.getElementById("A8"+','+k));
        document.getElementById("A8"+k).setAttribute("id", "D8"+','+k);
        document.getElementById("E8"+k).setAttribute("id", "C8"+','+k);
      }
    }
    
  }
else if(color[u].split("_").length==2){
    $('#'+color[u][2]+color[u][3]+g+k).html("");
    $('#'+color[u][2]+color[u][1]+g+k).html("");
      $('#'+color[u][2]+color[u][3]+g+k).append(document.getElementById(color[u][0]+color[u][1]+','+k));
      document.getElementById(color[u][0]+color[u][1]+','+k).setAttribute("id", color[u][2]+color[u][3]+','+k);
    }
else{
      $('#'+color[u][2]+color[u][3]+g+k).html("");
      $('#'+color[u][2]+color[u][3]+g+k).append(document.getElementById(color[u][0]+color[u][1]+','+k));
      document.getElementById(color[u][0]+color[u][1]+','+k).setAttribute("id", color[u][2]+color[u][3]+','+k);
    }

}else{
  $("#"+color[u][2]+color[u][3]+g+k).html("");
  $("#"+color[u][0]+color[u][1]+g+k).html("");
  $("#"+color[u][2]+color[u][3]+g+k).append("<img class="+color[u+1][0]+" id="+color[u][2]+color[u][3]+","+k+" ondragstart='drag(event)' draggable='true' src='img/chesspieces/wikipedia/"+color[u+1][0]+color[u+1][1]+".png'>");
}
      u=u+2;
      document.getElementById(k).setAttribute("nc", u);
      ij++;
}
$('#'+this.id).attr("currentTime", newDuration);
$('#'+this.id).css("width", x+"px");
if (ut==12) {
setTimeout(function(){
  if($("#"+k).attr("class")=="begin"){
    $("#"+k).click();
  }
}, 3000);
}
});

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
}, 2000);






$(document.body).on('click', '.saf', function(el){
  if(el.target.className != 'komkom' && el.target.className != 'likes2' && el.target.className != 'likes2 dis2'){
    var id = this.id.split(',');
    $("#limit").prepend("<div class='cover_outClass' id='cov"+z_index+"' style='z-index: "+(Number(9500)+Number(z_index))+";'></div><div class='cover days' style='z-index: "+(Number(9000)+Number(z_index))+";'><div id='cen' style='margin: 0 auto; width: "+(document.getElementById('scorsection') ? document.getElementById('scorsection').offsetWidth : document.getElementById('notificationsection').offsetWidth )+"px'><div class='cadre sous_comment'><div id='ko2'></div></div></div></div>");
    $("body").css('overflow-y', 'hidden');
    $('#cov'+z_index).on('click', function(){
      $('.cover_outClass')[0].remove();
      $('.cover')[0].remove();
      if($('.cover').length == 0){
        $("body").css('overflow-y', 'scroll');
      }
    });
z_index++;

$.post('profilwall.php', {id_k : id[1], p_id : id[2], witch : id[4]}, function(data) {
    $("#ko2").append(data);
}, 'text')
.fail(function(response) {
    $("#ko2").html('');
    $("#ko2").append("<button id='errorButton' class='"+id[1]+","+id[2]+","+id[4]+"'>An Error Has Occured Click Here To Refreach</button>");
});

  }
});

$(document.body).on('click', '#errorButton', function(el){
  var id = this.className.split(',');
  $.post('profilwall.php', {id_k : id[0], p_id : id[1], witch : id[2]}, function(data) {
    $("#ko2").html('');
    $("#ko2").append(data);
}, 'text')
.fail(function(response) {
    $("#ko2").append("<button id='errorButton' class='"+id[0]+","+id[1]+","+id[2]+"'>An Error Has Occured Click Here To Refreach</button>");
});
});

$(document.body).on('click', '#errorButton2', function(el){
  var id = this.className.split(',');
  $.post('profilwall.php', {teig : id[0], uniqueg: id[1]}, function(data) {
    $("#ko").html('');
    $("#ko").append(data);
}, 'text')
.fail(function(response) {
    $("#ko").append("<button id='errorButton2' class='"+id[0]+","+id[1]+"'>An Error Has Occured Click Here To Refreach</button>");
});
});

$.post(
  "profilwall.php",
    {
        notificationExisting : "Baga"
    },
                function(data){
                  if(Number(data) > 0){
                    if(!document.getElementById('notificationsection')){
                      $("#newData").css("background-color", "#b2b2ec");
                      $("#notifierMoi").css({"background-color": "#232333", "color": "#b2b2ec"});
                    }
                }
            },

            'text'
         );

$(document.body).on('click', '.vers_le_commantaire', function(el){
  if(el.target.className != 'komkom' && el.target.className != 'likes2' && el.target.className != 'likes2 dis2'){
    var id = this.id.split(',');
    $("#limit").prepend("<div class='cover_outClass' id='cov"+z_index+"' style='z-index: "+(Number(9500)+Number(z_index))+";'></div><div class='cover days' style='z-index: "+(Number(9000)+Number(z_index))+";'><div id='cen' style='margin: 0 auto; width: "+document.getElementById('notificationsection').offsetWidth+"px'><div class='cadre sous_comment'><div id='ko2'></div></div></div></div>");
    $("body").css('overflow-y', 'hidden');
    $('#cov'+z_index).on('click', function(){
      $('.cover_outClass')[0].remove();
      $('.cover')[0].remove();
      if($('.cover').length == 0){
        $("body").css('overflow-y', 'scroll');
      }
    });
z_index++;
$.post(
  "profilwall.php",
    {
        id_k : id[1],
        p_id : id[2],
        witch : id[4]
    },
                function(data){
                  $("#ko2").append(data);
            },

            'text'
         );

  }
});


$('#enregistre').on('click', function() {
$.post(
  "userInfo.php",
    {
        textarea : document.getElementById('textarea').value
    },
                function(data){
                  if(data.length > 0){
window.location.replace("profile.php?pseudo=" + data);
                  }
            },

            'text'
         );

});
function getMousePosition(event) {
    return {
        x: event.pageX,
        y: event.pageY
    };
}
function move(a,xpos,ypos){
                        a.style.left = xpos + 'px';
                        a.style.top = ypos + 'px';
                    }
function startMoving(evt, img){
  evt = evt || window.event;
  var posX = evt.clientX,
      posY = evt.clientY,
      a = document.getElementById("dragDiv"),
      divTop = a.style.top,
      divLeft = a.style.left;
      divTop = divTop.replace('px','');
      divLeft = divLeft.replace('px','');
  var diffX = posX - divLeft,
      diffY = posY - divTop;
  document.onmousemove = function(evt){
      evt = evt || window.event;
      var posX = evt.clientX,
          posY = evt.clientY,
          aX = posX - diffX,
          aY = posY - diffY;
if(aY <= getPosition(img).y){
  aY = getPosition(img).y;
}if(aX <= getPosition(img).x){
  aX = getPosition(img).x;
}if(aY >= getPosition(img).y + img.height - 170){
  aY = getPosition(img).y + img.height - 170;
}if(aX >= getPosition(img).x + img.width - 170){
  aX = getPosition(img).x + img.width - 170;
}
                                
          move(a,aX,aY);
                        }
                    }

function touchStart(evt, img) {
   evt.preventDefault();
  var touches = evt.changedTouches;
        
  for (var i = 0; i < touches.length; i++) {
    var posX = touches[i].clientX,
      posY = touches[i].clientY,
      a = document.getElementById("dragDiv"),
      divTop = a.style.top,
      divLeft = a.style.left;
      divTop = divTop.replace('px','');
      divLeft = divLeft.replace('px','');
  var diffX = posX - divLeft,
      diffY = posY - divTop;
      document.ontouchmove = function (evt) {
  var touches = evt.changedTouches;

  for (var i = 0; i < touches.length; i++) {
    var posX = touches[i].clientX,
          posY = touches[i].clientY,
          aX = posX - diffX,
          aY = posY - diffY;
if(aY <= getPosition(img).y){
  aY = getPosition(img).y;
}if(aX <= getPosition(img).x){
  aX = getPosition(img).x;
}if(aY >= getPosition(img).y + img.height - 170){
  aY = getPosition(img).y + img.height - 170;
}if(aX >= getPosition(img).x + img.width - 170){
  aX = getPosition(img).x + img.width - 170;
}
           move(a,aX,aY);
  }
}
  }
}

$('#imagefile').on('change', function(e) {
  if($('#imagefile').val().length >= 1){
$("#li2").prepend("<div class='full'><div>");
$("#li2").prepend("<div id='fullS' class='lightbox'><button id='bigger'></button><button id='smaller'></button><button id='savePro'>Save</button><div id='lightboxWindowCanvas'><div id='dragDiv' style='width: 170px; height: 170px; position: absolute;'><div id='blancBorder' ></div></div></div></div>");
$('body').css("overflow-y", "hidden");
$("#dragDiv").on('mousedown', function(event){
  startMoving(event, document.getElementById("idImg"));
});
$("#dragDiv").on('touchstart', function(e){
  touchStart(e, document.getElementById('idImg'));
});


var tn = 0;
$("#dragDiv").on('mouseup', function(event){
  document.onmousemove = function(){}
});
$("#dragDiv").on('touchend', function(event){
  document.ontouchmove = function(){}
});
$("#fullS").css("overflow", "scroll");
 var img = new Image();
   img.src = URL.createObjectURL(e.target.files[0]);
   img.setAttribute("id", "idImg");
   $("#lightboxWindowCanvas").prepend(img);
$("#idImg").on('click', function(e){
  tn++;
  if(tn == 2){
  var relX = e.pageX - $(window).scrollLeft() + $("#fullS").scrollLeft() - 85; var relY = e.pageY - $(window).scrollTop() + + $("#fullS").scrollTop() - 85;
   if(relY <= getPosition(img).y){
  relY = getPosition(img).y;
}if(relX <= getPosition(img).x){
  relX = getPosition(img).x;
}if(relY >= getPosition(img).y + img.height - 170){
  relY = getPosition(img).y + img.height - 170;
}if(relX >= getPosition(img).x + img.width - 170){
  relX = getPosition(img).x + img.width - 170;
}
    document.getElementById("dragDiv").style.left =  relX+ 'px';
    document.getElementById("dragDiv").style.top =  relY+ 'px';
    tn = 0;
  }
  setTimeout(function(){
    tn = 0;
  }, 1500);
});
   $('#imagefile').val("");
   img.onload = function() {

    var ar = img.naturalWidth/$(window).width();
    var y = img.naturalHeight/ar;
    var x = $(window).width();

var width = img.naturalWidth;
var height = img.naturalHeight;


if(window.innerHeight < window.innerWidth){
if (window.innerHeight < height && width < 2*height) {
  var newHeight = innerHeight;
  var newWidth = width/(height/innerHeight);
  var r = height/innerHeight;
  $("#lightboxWindowCanvas").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  img.width = newWidth;
  img.height = newHeight;
}else if(window.innerWidth < width){
  var newWidth = innerWidth;
  var newHeight = height/(width/innerWidth);
  var r = width/innerWidth;
  var margin = (window.innerHeight - newHeight)/2;
  $("#lightboxWindowCanvas").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  img.width = newWidth;
  img.height = newHeight;
}else{
  var newWidth = width;
  var newHeight = height;
  var margin = (window.innerHeight - newHeight)/2;
  $("#lightboxWindowCanvas").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  img.width = newWidth;
  img.height = newHeight;
}
}else if(window.innerHeight > window.innerWidth){
if (window.innerWidth < width && height < 2*width) {
  var newWidth = innerWidth;
  var newHeight = height/(width/innerWidth);
  var margin = (window.innerHeight - newHeight)/2;
  var r = width/innerWidth;
  $("#lightboxWindowCanvas").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  img.width = newWidth;
  img.height = newHeight;
}else if(window.innerHeight < height){
  var newHeight = innerHeight;
  var newWidth = width/(height/innerHeight);
  var r = height/innerHeight;
  $("#lightboxWindowCanvas").css({"height": +newHeight+"px", "width": +newWidth+"px"});
  img.width = newWidth;
  img.height = newHeight;
}else{
  var newWidth = width;
  var newHeight = height;
  var margin = (window.innerHeight - newHeight)/2;
  $("#lightboxWindowCanvas").css({"height": +newHeight+"px", "width": +newWidth+"px", "margin-top":+margin+"px"});
  img.width = newWidth;
  img.height = newHeight;
}
}
$("#dragDiv").css({"top": getPosition(img).y+"px", "left": getPosition(img).x+"px"});

$("#bigger").on('click', function(){
  var nW = img.width + (img.width/100)*5;
  var nH = (nW/img.width)*img.height;
  if(nW >= width){
    nW = width;
  }if(nH >= height){
    nH = height;
  }
  $("#lightboxWindowCanvas").css({"height": nH+"px", "width": nW+"px"});
  img.width = nW;
  img.height = nH;
  $("#dragDiv").css({"top": getPosition(img).y+"px", "left": getPosition(img).x+"px"});
});
$("#smaller").on('click', function(){
  var nW = img.width - (img.width/100)*5;
  var nH = (nW/img.width)*img.height;
  if(nW <= 170){
    nH = img.height;
    nW = img.width;
  }if(nH <= 170){
    nH = img.height;
    nW = img.width;
  }
  $("#lightboxWindowCanvas").css({"height": nH+"px", "width": nW+"px"});
  img.width = nW;
  img.height = nH;
  $("#dragDiv").css({"top": getPosition(img).y+"px", "left": getPosition(img).x+"px"});
});
$("#savePro").on('click', function(){
  $("#fullS").append("<canvas style='display: none;' id='proCanvas'></canvas>");
  var proCanvas = document.getElementById('proCanvas');
var xD = Number(document.getElementById("dragDiv").style.left.replace('px','')) - getPosition(img).x;
var yD = Number(document.getElementById("dragDiv").style.top.replace('px','')) - getPosition(img).y;
var coeficientX = img.width/img.naturalWidth;
var coeficientY = img.height/img.naturalHeight;
proCanvas.width = 170/coeficientX;
proCanvas.height = 170/coeficientY;
var ctx = proCanvas.getContext('2d');
ctx.drawImage(img, xD/coeficientX, yD/coeficientY, 170/coeficientX, 170/coeficientY, 0, 0, 170/coeficientX, 170/coeficientY);
var dataURL = proCanvas.toDataURL("image/png");
$.post(
  "uploadavatarimage.php",
    {
        imagefile : dataURL
    },
                function(data){ 
$("#fullS").remove();
$(".full").remove();
$('body').css("overflow-y", "scroll");
$(".showImage").css({'background-image': "url("+data+")"});
$(".changeNow").css({'background-image': "url("+data+")"});
$('#imagefile').val("");
            },

            'text'
         );
});
}

  }
});

$('#largeimagefile').on('change', function(e) {
  if($('#largeimagefile').val().length >= 1){
    if(document.getElementById("canvas")){
      document.getElementById("canvas").remove();
    }
$("#large").prepend("<canvas id='canvas'></canvas>");
$("#large").css({'overflow-y':'scroll'});
   var img = new Image();
   img.src = URL.createObjectURL(e.target.files[0]);
   $('#largeimagefile').val("");
   img.onload = function() {
    var ar = img.naturalWidth/$(window).width();
    var y = img.naturalHeight/ar;
    var x = $(window).width();

canvas = document.getElementById("canvas");
canvas.style.height = y+"px";
canvas.style.width = "100%";
var marg = document.getElementById("large").scrollHeight - y;
canvas.style.marginBottom = -marg +"px";
canvas.width = img.naturalWidth;
canvas.height = img.naturalHeight;
var ctx = document.getElementById('canvas').getContext('2d');
ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight);
if(document.getElementById("imgSend")){
 document.getElementById("imgSend").remove(); 
}
$("HEADER").prepend("<button id='imgSend'>Save</button>");
  $("#mainheader").css("display", "none");

$("#imgSend").on('click', function(){

var eb = document.getElementById("large").scrollTop * ar;
$("#large").css({'overflow-y':'hidden'});
canvas.style.height = x/3+"px";
canvas.style.width = "100%";

canvas.width = img.naturalWidth;
canvas.height = img.naturalWidth/3;

var marg = document.getElementById("large").height - x/3;
canvas.style.marginBottom = -marg +"px";

ctx.drawImage(img, 0, eb, img.naturalWidth, img.naturalWidth/3, 0, 0, img.naturalWidth, img.naturalWidth/3);
var dataURL = canvas.toDataURL("image/png");
$("#imgSend").remove();
$("HEADER").prepend("<div class='loader'></div>");
$(".loader").css({'position': 'relative', 'height': '20px', 'width': '20px', 'top': '15px'});
$.post(
  "uploadavatarimage.php",
    {
        largeimagefile : dataURL
    },
                function(data){ 
canvas.remove();
$(".loader").remove();
$("#large").css({'background-image': "url("+data+")"});
$("#mainheader").css("display", "flex");
$('#largeimagefile').val("");
            },

            'text'
         );
});

   }
  }
});

$('#pseudonyme').on('keypress', function(e) {
  if(e.which == 13){
    e.preventDefault();
    $.post(
  "userInfo.php",
    {
        pseudo : document.getElementById('pseudonyme').value
    },
                function(data){ 
document.getElementById("pseuUnderImage").innerHTML = data;
document.getElementById("pseudonyme").innerHTML = "";
            document.getElementById('tooltip1').style.display = 'none';
            document.getElementById('pseudonyme').style.display = 'none';
            ep.style.display = 'inline-block';
            },

            'text'
         );
  }
});

   


var avataricon = document.getElementById('avatardiv');
var searchzone = document.getElementById('searchzone');
var swi = document.getElementById('switch');
var profilemenu = document.getElementById('profilemenu');
arrowup = document.getElementById('arrowup');
var menu = document.getElementById('menu');
var limit = document.getElementById('limit');
avataricon.addEventListener('mouseenter', function() {
  profilemenu.style.display = 'block';
  arrowup.style.display = 'block';
});
avataricon.addEventListener('mouseleave', function() {
  profilemenu.style.display = 'none';
  arrowup.style.display = 'none';
});




var pw2 = document.getElementById('pw2');
var sp2 = document.getElementById('tooltip3');
var epass = document.getElementById('epass');

 $('#epass').on('click', function() {
        pw1.style.display = 'inline-block';
        pw2.style.display = 'inline-block';
        epass.style.display = 'none';
        pw1.focus();
  });
$('#pw1').on('keypress', function(e) {
  if(e.which == 13){
  pw2.focus();
  }
});
$('#pw2').on('keypress', function(e) {

  if (pw2.value.length >= 10 || pw2.value.length == 0) {
        sp2.style.display = 'none';
      }else{
        sp2.style.display = 'block';
      }

if(e.which == 13){
  e.preventDefault();
  $.post(
  "userInfo.php",
    {
        pass : $("#pw1").val(),
        passconfirme : $("#pw2").val()
    },
                function(data){ 
            p1.innerHTML = "";
            p2.innerHTML = "";
            pw1.style.display = 'none';
            pw2.style.display = 'none';
            epass.style.display = 'inline-block';
            },

            'text'
         );

}
});



var pw1 = document.getElementById('pw1');
var sp1 = document.getElementById('tooltip2');
$('#pw1').on('blur', function() {
     $.post(
  "userInfo.php",
    {
        newpass : $("#pw1").val()
    },
                function(data){ 
                  if (data == "ok" || pw1.value.length == 0) {
                    sp1.style.display = 'none';
                  }
                  else{
                    sp1.style.display = 'inline-block';                       
                  }
            },

            'text'
         );
  });

  if(document.getElementById("usersection")){
  var childrenU = document.getElementById("usersection").children;
  var nH=0;
  for (var i = 0; i < childrenU.length; i++) {
    nH = nH + childrenU[i].clientHeight;
  }
  document.getElementById("usersection").style.height = nH+20+"px";
}


       
var pseudonyme = document.getElementById('pseudonyme');
var ep = document.getElementById('ep'); 
 $('#ep').on('click', function() {
        pseudonyme.style.display = 'inline-block';
        ep.style.display = 'none';
        pseudonyme.focus();
  });
    
    var sp = document.getElementById('tooltip1');
  $('#pseudonyme').on('keyup', function() {
 $.post(
  "t.php",
    {
        pseu : $("#pseudonyme").val()
    },
                function(data){ 
                  if (data == 1) {
                    sp.style.display = 'inline-block';
                    
                  }
                  if(data !=1 || pseudonyme.value.length == 0){
                    sp.style.display = 'none';

                  }
            },

            'text'
         );

});




var bn1 = document.getElementById('bn1'); 
var newinfo11 = document.getElementById('newinfo11');
 $('#bn1').on('click', function() {
        newinfo11.style.display = 'inline-block';
        bn1.style.display = 'none';
        newinfo11.focus();
  });
 $('#newinfo11').on('keypress', function(e) {
  if(e.which == 13){
    e.preventDefault();
    $.post(
  "userInfo.php",
    {
        studying_level : $("#newinfo11").val()
    },
                function(data){ 
document.getElementById('slspan').innerHTML = data;
newinfo11.value = "";
newinfo11.style.display = 'none';
bn1.style.display = 'inline-block';
            },

            'text'
         );
  }
});
 var bn2 = document.getElementById('bn2'); 
var newinfo22 = document.getElementById('newinfo22');
 $('#bn2').on('click', function() {
        newinfo22.style.display = 'inline-block';
        bn2.style.display = 'none';
        newinfo22.focus();
  });
 $('#newinfo22').on('keypress', function(e) {
  if(e.which == 13){
e.preventDefault();
$.post(
  "userInfo.php",
    {
        profession : $("#newinfo22").val()
    },
                function(data){ 
document.getElementById('prospan').innerHTML = data;
newinfo22.value = "";
newinfo22.style.display = 'none';
bn2.style.display = 'inline-block';
            },

            'text'
         );

}
});




    $('#randomrequest1').on('click', '.ad', function() {
    var id = $(this).attr('id'); 
    $("#randomavatar"+id).parent().remove();
 $.post(
  "a.php",
    {
        ok : id
    },
                function(data){
                  if(data == 654){
                    for (var i = 0; i < document.getElementsByClassName('ad').length; i++) {
                      if(i == 0){
                        var ide = document.getElementsByClassName('ad')[i].id;
                      }else{
                        ide = ide + "," + document.getElementsByClassName('ad')[i].id;
                      }
                      
                    }
             $.post(
  "randomfriends.php",
    {
        muchmorefriend : ide
    },
                function(data){
if(data.length >= 1){
$("#randomrequest1").append(data);
if($("#randomrequest1").children().length < 1){
  $("#randomrequest1").css("display", "none");
}
else{
  $("#randomrequest1").css("display", "block");
}
}

            },

            'text'
         );
           }
            },

            'text'
         );
  
});



    

 $.post(
  "randomfriends.php",
    {
        morefriend : "Bahamuth"
    },
                function(data){                
$("#randomrequest1").append(data);
if($("#randomrequest1").children().length < 1){
  $("#randomrequest1").css("display", "none");
}
else{
  $("#randomrequest1").css("display", "block");
}
            },

            'text'
         );


 














if($('#large').length==1){
$(window).scroll(function() {
   var hT = $('#large').offset().top,
       hH = $('#large').outerHeight(),
       wH = $(window).height(),
       wS = $(this).scrollTop();
   if (wS > (hT+hH)){
      $("HEADER").css({"top":"0", "position":"fixed"});
   }
   else{
      $("HEADER").css({"top":"ws", "position":"static"});
   }
});
}


if($(window).width() <= 783){
  if(document.getElementById("userdata")){
    $("#userdata").css({'height': ($(window).width()/3+76)+'px'});
    $(".largeuser").css({'height': $(window).width()/3+'px'});
  }
}
if(document.getElementById('scorsection') && $(window).width()> 783){
  document.getElementById('scorsection').style.minWidth = ($(window).width()-525-80)+'px';
}

window.addEventListener('resize', function(){
  if(document.getElementById("userdata")){
    if($(window).width() <= 783){
      $("#userdata").css({'height': ($(window).width()/3+76)+'px'});
      $(".largeuser").css({'height': $(window).width()/3+'px'});
    }else{
      $("#userdata").css({'height': '170px'});
      $(".largeuser").css({'height': '89px'});
    }
  }

  if(document.getElementById('scorsection') && document.getElementById('scorsection').offsetWidth>300 && $(window).width()> 783){
    document.getElementById('scorsection').style.minWidth = ($(window).width()-525-80)+'px';
  }
});




$("#p_img").on('click', function(){
  $("#p_file_img").click();
});

$("#p_v").on('click', function(){
  $("#p_file_vid").click();
});

$('#p_wrip').on('paste', function(e){
  var pattern19 = /(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/g;
  var pattern29 = /(?:http?s?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;
  var pattern39 = /([-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?(?:jpg|jpeg|gif|png))/gi;
  var pattern49 = /(?:http?s?:\/\/)?(?:www\.|)?(?:soundcloud\.com)\/?(.+)/g;

  var text = (e.originalEvent || e).clipboardData.getData('text/plain');
  setTimeout(function(){
    if(pattern19.test(text) || pattern29.test(text) || pattern39.test(text) || pattern49.test(text)){
      videoEmbed.invokeSecond(text);
    }
  }, 300);
});

$("#p_s").on('click', function(){
  var data = document.getElementById('p_wrip').textContent + $('#p_wrip').attr('forgottenData');
  if(data.length > 0){
    $.post(
  
  "profilwall.php",
    {
        textp : data
    },
                function(data){                
document.getElementById('p_wrip').textContent= "";
$('#p_wrip').attr('forgottenData', '');
window.location.reload();
            },

            'text'
         );
  }
});

$("#p_file_img").on('change', function(e){
var file = e.target.files[0];

  var img = new Image();
   img.src = URL.createObjectURL(file);


var pr = "<div style='background-color: #cacaca; height: 5px; width: 100%; display: none;'><div id='up'></div></div>";

   img.onload = function(){
    if($(window).width() <= 483){
       img.height = img.height*$(window).width()/img.width;
    img.width = $(window).width();
    
  $("#limit").prepend("<div class='cover colorChange'><div id='poster2'><div style='display: flex;'><div style='width: calc(100% - 30px); height:40px; text-align: center; line-height: 30px;'>New Post</div><div id='commentEnd'></div></div><div id='poster' style='border: 0px; width: 100%; height: 120px;'><div class='cp_wri' id='p_wri' placeholder='Type something...' contenteditable='true' style='height: 100px;'></div></div><div id='vi'></div>"+pr+"<div id='p_c' style='height: 45px;'><div id='pl'></div><div id='p_b'><button id='p_s2'>Post</button></div></div></div></div>");

    }else{
 img.height = img.height*500/img.width
    img.width = 500;
    
  $("#limit").prepend("<div class='cover'><div id='poster2'><div style='display: flex;'><div style='width: calc(100% - 30px); height:40px; text-align: center; line-height: 30px;'>New Post</div><div id='commentEnd'></div></div><div id='poster' style='border: 0px; width: 100%; height: 120px;'><div class='cp_wri' id='p_wri' placeholder='Type something...' contenteditable='true' style='height: 100px;'></div></div><div id='vi'></div>"+pr+"<div id='p_c' style='height: 45px;'><div id='pl'></div><div id='p_b'><button id='p_s2'>Post</button></div></div></div></div>");

    }
     $('#vi').append(img)
  $("body").css('overflow-y', 'hidden');
  $("header").css('position', 'absolute');
  $('#commentEnd').on('click', function(){
   $(".cover").remove();
   $("body").css('overflow-y', 'scroll');
   $("header").css('position', '');
   document.getElementById('p_file_img').value = "";
  });

  /* border */

  $("#p_s2").on('click', function(){
     
    var XHR = new XMLHttpRequest();
    var formData = new FormData();
    formData.append("p_file_img", file);
    formData.append("p_texti", document.getElementById('p_wri').textContent);

    XHR.addEventListener("error", function(event) {
      $("vid").html("<div style='margin: auto; text-align: center; line-height: "+$("vid").height()+"px; font-size: 20px;'>An error had occured</div>");
    });


    var ip = document.getElementById('up');
    var maxW = $(ip).parent().width();
    var size = file.size;
    var coe = maxW/size;



    XHR.onloadstart = function (e) {
    $(ip).parent().css('display', 'block');
    }
    XHR.onloadend = function (e) {
    window.location.reload();
    }

    XHR.upload.onprogress = function(e){
      ip.style.width = e.loaded * coe + "px";
    }

    XHR.open("POST", "profilwall.php");

    XHR.send(formData);
  });
  /* border */
   }

  

});




$("#p_file_vid").on('change', function(e){
var file = e.target.files[0];
  var img = document.createElement('video');

   img.src = URL.createObjectURL(file)+"#t=0.5";


   img.controls = "controls";
   img.preload="metadata";
   img.load();

   var pr = "<div style='background-color: #cacaca; height: 5px; width: 100%; display: none;'><div id='up'></div></div>";
   /* border */
   img.onloadedmetadata = function(){
    if($(window).width() <= 483){
       img.style.height = img.height*$(window).width()/img.width+"px";
    img.style.width = $(window).width()+"px";
    
  $("#limit").prepend("<div class='cover colorChange'><div id='poster2'><div style='display: flex;'><div style='width: calc(100% - 30px); height:40px; text-align: center; line-height: 30px;'>New Post</div><div id='commentEnd'></div></div><div id='poster' style='border: 0px; width: 100%; height: 120px;'><div class='cp_wri' id='p_wri' placeholder='Type something...' contenteditable='true' style='height: 100px;'></div></div><div id='vi'></div>"+pr+"<div id='p_c' style='height: 45px;'><div id='pl'></div><div id='p_b'><button id='p_s2'>Post</button></div></div></div></div>");

    }else{
 img.style.height = img.height*500/img.width+"px";
    img.style.width = 500+"px";
    
  $("#limit").prepend("<div class='cover'><div id='poster2'><div style='display: flex;'><div style='width: calc(100% - 30px); height:40px; text-align: center; line-height: 40px;'>New Post</div><div id='commentEnd'></div></div><div id='poster' style='border: 0px; width: 100%; height: 120px;'><div class='cp_wri' id='p_wri' placeholder='Type something...' contenteditable='true' style='height: 100px;'></div></div><div id='vi'></div>"+pr+"<div id='p_c' style='height: 45px;'><div id='pl'></div><div id='p_b'><button id='p_s2'>Post</button></div></div></div></div>");

    }
     $('#vi').append(img);
videoPlayer();

  $("body").css('overflow-y', 'hidden');
  $("header").css('position', 'absolute');
  $('#commentEnd').on('click', function(){
   $(".cover").remove();
   $("body").css('overflow-y', 'scroll');
   $("header").css('position', '');
   document.getElementById('p_file_vid').value = "";
  });

  /* border */

  $("#p_s2").on('click', function(){
     
    var XHR = new XMLHttpRequest();
    var formData = new FormData();
    formData.append("p_file_vid", file);
    formData.append("p_textv", document.getElementById('p_wri').textContent);


    XHR.addEventListener("error", function(event) {
      $("vid").html("<div style='margin: auto; text-align: center; line-height: "+$("vid").height()+"px; font-size: 20px;'>An error had occured</div>");
    });


    var ip = document.getElementById('up');
    var maxW = $(ip).parent().width();
    var size = file.size;
    var coe = maxW/size;



    XHR.onloadstart = function (e) {
    $(ip).parent().css('display', 'block');
    }
    XHR.onloadend = function (e) {
    window.location.reload();
    }

    XHR.upload.onprogress = function(e){
      ip.style.width = e.loaded * coe + "px";
    }
    
    XHR.open("POST", "profilwall.php");

    XHR.send(formData);
  });
  /* border */
   }


});





$("[contenteditable]").focusout(function(){
        var element = $(this);        
        if (!element.text().trim().length) {
            element.empty();
        }
    });

$(document.body).on('click', 'video', function(){
  var id = this.id;
  document.getElementById('p,'+id).click();
});


$(document.body).on('mousemove', 'video', function(ev){
  var id = this.id;
  document.getElementById('vc,'+id).style.opacity = 1;
});





$(document.body).on('click', '.play', function(){
  var id = this.id.split(',')[1];
  var cl = this;
  var el = document.getElementById(id);
if(el.duration > 0 && el.duration < 100000){
  var duration = el.duration;
  var bar = document.getElementById("b,"+id);
  var coe = 100/duration;
  if(cl.className == 'play'){
    setTimeout(function(){
document.getElementById('vc,'+id).style.opacity = 0;
    }, 2000);
    cl.className = 'play stop';
    var cd = document.getElementById('cd,'+id);
$(el).on('timeupdate', function(){
bar.style.width = el.currentTime*coe+"%";
cd.innerHTML = formatTime(duration - el.currentTime);
if(el.currentTime == duration){
  el.currentTime = 0;
  el.pause();
bar.style.width = el.currentTime*coe+"%";
cd.innerHTML = formatTime(duration - el.currentTime);
cl.className = 'play';
}
});

    el.play();
  }else{
    cl.className = 'play';
    el.pause();
  }

}

});

$(document.body).on('mouseover', '.sound_volume_div', function(){
var id = this.id.split(',')[1];
document.getElementById('ve,'+id).style.paddingRight = '5px';
var el = document.getElementById('vee,'+id);
el.style.width = '60px';
document.getElementById('vp,'+id).style.width = 'calc(100% - 175px)';
});

$(document.body).on('mouseout', '.sound_volume_div', function(e){
 var id = this.id.split(',')[1];
 document.getElementById('ve,'+id).style.paddingRight = '0px';
var el = document.getElementById('vee,'+id);
el.style.width = '0px';
document.getElementById('vp,'+id).style.width = 'calc(100% - 115px)';
});

$(document.body).on('click', '.video_progress_tub', function(e){
  var id = this.id.split(',')[1];
  var target =  getMousePosition(e).x - getPosition(this).x;
  var width = this.offsetWidth;
  var element = document.getElementById(id);
  if(target < 0){target=0;} else if(target > width){target = width;}
  var bar = document.getElementById('b,'+id);
  var duration = element.duration;
  element.currentTime = duration*target/width;
  if(element.paused){
  document.getElementById('cd,'+id).innerHTML = formatTime(duration - element.currentTime);
  bar.style.width = 100*element.currentTime/duration+'%';
                     }
});

$(document.body).on('click', '.sound_volume_tub', function(e){
  var id = this.id.split(',')[1];
  var target =  getMousePosition(e).x - getPosition(this).x;
  var width = this.offsetWidth;
  var element = document.getElementById(id);
  if(target < 3){target=0;} else if(target > width-3){target = width;}
  var bar = document.getElementById('veee,'+id);
  element.volume = target/width;
  bar.style.width = 100*element.volume+'%';
});


$(document).bind('fullscreenchange webkitfullscreenchange mozfullscreenchange msfullscreenchange', function (e) {
  var fullscreenElement = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullscreenElement || document.msFullscreenElement;
  if (!fullscreenElement) {
    var f = document.getElementsByClassName('full_screen_off');
for (var i = 0; i < f.length; i++) {
  f[i].click();
}
  }
});


$(document.body).on('click', '.full_screen', function(){
var id = this.id.split(',')[1];
var el = document.getElementById('vc,'+id);
var elem = document.getElementById(id).parentElement;

if(this.className == 'full_screen'){
  this.className = 'full_screen full_screen_off';
var elem = document.getElementById(id).parentElement;
if (elem.requestFullscreen) {
  elem.requestFullscreen();
} else if (elem.mozRequestFullScreen) {
  elem.mozRequestFullScreen();
} else if (elem.webkitRequestFullscreen) {
  elem.webkitRequestFullscreen();
}else if (elem.msExitFullscreen){
  elem.msRequestFullScreen();
}
el.className = 'video_controls conrols_full';
elem.style.backgroundColor = 'black';
setTimeout(function(){
document.getElementById('vc,'+id).style.opacity = 0;
    }, 4000);
}else{
  this.className = 'full_screen';
  if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
  el.className = 'video_controls';
  elem.style.backgroundColor = '';
}
});

});


function getPosition(element){
    var top = 0, left = 0;
    
    do {
        top  += element.offsetTop;
        left += element.offsetLeft;
    } while (element = element.offsetParent);
    
    return { x: left, y: top };
}
function getMousePosition(event) {
    return {
        x: event.pageX,
        y: event.pageY
    };
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


function videoPlayer(){
var videos = document.getElementsByTagName('video');
for (var i = 0; i < videos.length; i++) {
  if(videos[i].parentElement.children.length == 1){
    var j = videos[i];
    j.id = 'v'+i;
    var p1 = "<div id='p,"+j.id+"' class='play'></div>";
    var p2 = "<div id='v,"+j.id+"' class='sound_volume'></div>";
    var p3 = "<div id='ve,"+j.id+"' class='sound_volume_div'>"+p2+"<div id='vee,"+j.id+"' class='sound_volume_tub'> <div id='veee,"+j.id+"' class='sound_volume_bar'> </div> </div></div>"
    var p4 = "<div id='vp,"+j.id+"' class='video_progress_div'>  <div id='t,"+j.id+"' class='video_progress_tub'> <div id='b,"+j.id+"' class='video_progress_bar'></div> </div>  </div>";
    $(j).parent().append("<div id='vc,"+j.id+"' class='video_controls'>"+p1+p3+p4+"<div id='cd,"+j.id+"' class='count_down'>..:..</div><div id='f,"+j.id+"' class='full_screen'></div></div>");
j.load();
    j.onloadedmetadata = function() {
      document.getElementById("cd,"+j.id).innerHTML = formatTime(j.duration);
    };
  }
}
}












var z_index = 1;