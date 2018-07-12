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
?>
<div id="op" style="display: none;" class='<?php echo $_SESSION["id"]; ?>'>
<input name="img" value="" id="chatImg" type="file" style="visibility:hidden; display: none;" accept="image/*">
<input name="textFile" value="" id="chatText" type="file" style="visibility:hidden; display: none;" accept=".pdf, .epub">
<div id="fenetre">
<div id="navi" class="nav,">
	<button id="nm1">New Message</button>
	<span class="fa fa-camera-retro" id="goback1" style=" display: none;"></span>
	<span class="fa fa-camera-retro" id="goback2" style=" display: none;"></span>
	<div id='Okoi' style='height:45px; width:45px; margin:auto; background-size: 100% 100%; border-radius: 50%; display: none;'></div>
	<span  class="fa fa-camera-retro" id="out"></span>
</div>
		
<div id="lastmessages">
	
</div>

<div id="searchuser" style="display: none;">

</div>


<div id="sendmessage" style="display: none;">


</div><div id='faceList'></div>
<div style="background-color: #cacaca; height: 5px; width: 100%; display: none;"><div id="up"></div></div>
	<div id="wrightmessage" style="display: none;">
	<div id='ImgAudioVideo'><div id='saveVoices'></div><div id='sendImg'></div><div id='sendText'></div></div>
		<div id='textsenderParent'><div placeholder="Message" data-type="input" id="textsender" contentEditable=true></div></div><div id='emojiList'></div>
	<div id='sendFlech'></div>
	</div>
</div>
</div>
