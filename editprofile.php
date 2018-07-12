<?php 
@session_start();
 ?>

<section id="psection" style="opacity: : 0; z-index: -100000;">
	<div id="newavatar">
		<label for="imagefile" id="avatarlabel"><div id="undernewavatar" class="changeNow" style="background-image: url(profilesimages/<?php echo $_SESSION['avatarimageurl'];?>);"><h3 id="h5modifier" >Modifier</h3></div></label><h1 id="pseuUnderImage"><?php echo $_SESSION['pseudo'];?></h1><form id="imageform" target="uploadFrame" action="uploadavatarimage.php" enctype="multipart/form-data" method="post">
			<input name="imagefile" value="" id="imagefile" type="file" style="display: none;" accept=".jpg, .png, .png-large, .jpg-large, .jpeg, .jpeg-large">
		</form>

	</div>
	<div id="changeinfo">
		<div id="changeinfoform1">
		<div id="s2"><input id="pseudonyme" type="text" name="pseudo" placeholder="New Username" maxlength="120" style="display: none;"><button id="ep">Edite Username.</button></div>
		<span id="tooltip1" style="display: none">Username already used.</span>
		</div>

		<div id="changeinfoform2">
		<div id="s2"><input id="pw1" type="password" name="pass" placeholder="The last password." maxlength="100" style="display: none;"><button id="epass">Edite password.</button></div>
		<span id="tooltip2" style="display: none;">False password.</span>
		<div id="s2"><input id="pw2" type="password" name="passconfirme" placeholder="The new password" maxlength="100" style="display: none;"></div>
		<span id="tooltip3" style="display: none">Password must contains more<br> than 10 charachters.</span>
		</div>

	</div>
	<div id="newinfo">
		<div id="newinfo1">
			<div id="s2"><input id="newinfo11" type="text" name="studying_level" placeholder="Studying Level." style="display: none;"><button id="bn1">Edite studying level.</button></div>
			<span id="slspan"><?php echo $_SESSION['studying_level']; ?></span>
		</div>
		<div id="newinfo2">
			<div id="s2"><input id="newinfo22" type="text" name="profession" placeholder="profession." style="display: none;"><button id="bn2">Edite profession.</button></div>
			<span id="prospan"><?php echo $_SESSION['profession']; ?></span>
		</div>
	</div>
	<div id="about" >
	<label for="textarea"><h4 style="text-align:  center; color: #025d2e;">About Me</h4></label>
		<div id="aboutme">
			<textarea id="textarea" name="textarea" maxlength="250"><?php echo $_SESSION['bio']; ?></textarea>
		</div>
	</div>



<div style="height: auto; width: 100%; display: flex;"><button id="enregistre">Finish</button></div>
</section>
<script type="text/javascript">
	              var psection = document.getElementById('psection');
       var eprofile = document.getElementById('eprofile');
       eprofile.addEventListener('click', function() {
        usersection.style.display = 'none';
        psection.style.display = 'block';
        if($("#labe").length >= 1){
        	$("#labe").attr("for", "largeimagefile");
        }
  });
        var psection = document.getElementById('psection');
       var enregistre = document.getElementById('enregistre');
       enregistre.addEventListener('click', function() {
        
        psection.style.display = 'none';
        usersection.style.display = 'block';
  });


  var childrenU = psection.children;
  var nH=0;
  for (var i = 0; i < childrenU.length; i++) {
    nH = nH + childrenU[i].clientHeight;
  }
  psection.style.height = nH+150+"px";
  psection.style.display = "none";
  psection.style.opacity = "1";
  psection.style.zIndex = "0";


</script>