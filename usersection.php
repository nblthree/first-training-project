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
if (isset($_REQUEST['pseudo'])){
	$pseudo = htmlspecialchars($_REQUEST['pseudo']);
	$reponse1 = $bdd->query('SELECT pseudo FROM members');
$more_than_one_pseudo = 0;
while ($donnees = $reponse1->fetch())
{
if ($donnees['pseudo'] == $pseudo) {
	$more_than_one_pseudo++;
}
}
$reponse1->closeCursor();
if($more_than_one_pseudo == 1){
	$req = $bdd->prepare('SELECT id, avatarimageurl, bio, studying_level, profession, country, birthdate FROM members WHERE pseudo = :pseudo');
    $req->execute(array(
    'pseudo' => $pseudo));
    $resultat = $req->fetch();
?>
<section id="usersection">
	<div id="newavatar">
<div id="undernewavatar" class="showImage <?php echo $resultat['avatarimageurl'];?>" style="background-image: url(profilesimages/<?php echo $resultat['avatarimageurl'];?>);">
		</div><h2 id="pseu_under_image"><?php echo $pseudo;?></h2>
	</div>
	<div id="userinfo">
	  <?php if($resultat['country'] != 'NULL'){ ?><span id="inp">From: <?php echo $resultat['country']; ?></span><br><br><?php } ?>
	    <span id="inp">Born in: <?php echo $resultat['birthdate']; ?></span><br><br>
		<?php if(strlen($resultat['studying_level']) >= 2){ ?><span id="inp">Studying level: <?php echo $resultat['studying_level']; ?></span><br><br><?php } ?>
		<?php if(strlen($resultat['profession']) >= 1){ ?><span id="inp">Profession: <?php echo $resultat['profession']; ?></span><br><br><?php } ?>
		<?php if(strlen($resultat['bio']) >= 1){ ?><span id="inpbio">About me: <?php echo $resultat['bio']; ?></span><?php } ?>

	</div>
	<?php if ($_SESSION['id'] == $resultat['id']) {	?>
<div style="width: 100%; height: auto; display: flex; margin-top: 10px;
    margin-bottom: 5px;">
	<button id="eprofile">Edite</button>
</div>
	<?php }else { ?>



<div style="width: 100%; height: auto; display: flex; justify-content: space-around;"><div style="width: 48%; height: auto; display: flex;"><a style="margin: auto; width: 100%;" href="friends.php?pseudo=<?php echo $pseudo; ?>"><button style="width: 100% !important;" id="fri">Friends</button></a></div><div id="btt" style="width: 48%; height: auto; display: flex;"></div></div>


<script type="text/javascript">

function allRelation(){
	$("#btt").html("");
	$.post(
  "a.php",
    {
        friendOrNot : <?php echo $resultat['id']; ?>
    },
                function(data){
/* Not friend && No Invitation */
if(data=="0"){
	$("#btt").append("<button id='ajouter'>Add</button>");
	$("#ajouter").on("click", function(){
		$.post(
  "a.php",
    {
        ok : <?php echo $resultat['id']; ?>
    },
                function(data){ 
if(Number(data)==654){
	$("#ajouter").remove();
	$("#btt").append("<button id='annulerAjouter'>Cancel</button>");
	$("#annulerAjouter").on("click", function(){
	$.post(
  "a.php",
    {
        cancel : <?php echo $resultat['id']; ?>
    },
                function(data){ 
if(Number(data)==777){
	$("#annulerAjouter").remove();
	allRelation();
}
            },

            'text'
         );
});
}
            },

            'text'
         );
	});
}
/* Invitation from the user */
else if(data == "cancel"){
	$("#btt").append("<button id='annulerAjouter'>Cancel</button>");
$("#annulerAjouter").on("click", function(){
	$.post(
  "a.php",
    {
        cancel : <?php echo $resultat['id']; ?>
    },
                function(data){ 
if(Number(data)==777){
	$("#annulerAjouter").remove();
	allRelation();
}
            },

            'text'
         );
});
}
/* Accept Or Refuse Invitation */
else if(data == "accept"){
	$("#btt").append("<button id='accept'>Accept</button>");
	$("#btt").append("<button id='refuse'>Refuse</button>");

	$('#accept').on('click', function() {
    $.post(
  "a.php",
    {
        snj : <?php echo $resultat['id']; ?>
    },
                function(data){ 
                  if (Number(data) == 55) {
allRelation();
                 }
            },

            'text'
         );
});

	$('#refuse').on('click', function() {
    $.post(
  "a.php",
    {
        snjr : <?php echo $resultat['id']; ?>
    },
                function(data){ 
                  if (Number(data) == 555) {
allRelation();  
                 }
            },

            'text'
         );
});
}
/* Unfriend */
else if(data=="1"){
	$("#btt").append("<button id='unfriend'>Unfriend</button>");
	$("#unfriend").on("click", function(){
		$.post(
  "a.php",
    {
        unfriend : <?php echo $resultat['id']; ?>
    },
                function(data){ 
                  if (Number(data) == 4971) {
allRelation();  
                 }
            },

            'text'
         );
	})
}
            },

            'text'
         );
}
allRelation();
</script>

<?php } ?>
</section>
<?php 
}    
}    
?>	