<?php
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
<div id="op7" style="display: none;">
        <div id="gamein">
        <div id="data50">
          
        </div>
        <div id="ga">
  <button class='lord,' id="ok2">Accept</button>
  <button class='lord,' id="non2">Decline</button>
  </div>
        </div>
        </div>
<div id="op6" style="display: none;">

<div id="ss2">
<span id="close2" class="clo,"></span>
<div id="players" style="opacity: 1;">
<div id="time">
  <select id="timechoose">
    <option value="1">1 Minutes</option>
    <option value="2">2 Minutes</option>
    <option value="5" selected="select">5 Minutes</option>
    <option value="10">10 Minutes</option>
    <option value="15">15 Minutes</option>
    <option value="20">20 Minutes</option>
    <option value="30">30 Minutes</option>
    <option value="40">40 Minutes</option>
    <option value="45">45 Minutes</option>
    <option value="60">60 Minutes</option>
  </select>
</div>
   <div id="disponible">

   </div>
	
</div>
</div>
</div>