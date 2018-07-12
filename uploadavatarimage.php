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
    $error    = NULL;
    $filename = NULL;
    
    
    if (isset($_POST['imagefile'])) {
$req = $bdd->prepare('SELECT avatarimageurl FROM members WHERE pseudo = :pseudo');
            $req->execute(array(
    'pseudo' => $_SESSION['pseudo']));

$resultat = $req->fetch();
unlink(getcwd() . '/profilesimages/' .$resultat['avatarimageurl']);
unlink(getcwd() . '/profilesimages/mini/' .$resultat['avatarimageurl']);
        $filename = $_SESSION['id'];
        $filename2 = "profile".$filename."im".mt_rand (1,10000).".png";
        $targetpath2 = getcwd() . '/profilesimages/' . $filename2;
$img = $_POST['imagefile'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
file_put_contents($targetpath2, $data);

$source = imagecreatefrompng($targetpath2);
$destination = imagecreatetruecolor(80, 80);
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);

imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
imagepng($destination, 'profilesimages/mini/' . $filename2);

            $req = $bdd->prepare('UPDATE members SET avatarimageurl = :avatarimageurl WHERE pseudo = :pseudo');
            $req->execute(array(
	'avatarimageurl' => $filename2,
	'pseudo' => $_SESSION['pseudo']
	));

            $_SESSION['avatarimageurl'] = $filename2;

echo "profilesimages/".$filename2;
    }


 if (isset($_POST['largeimagefile'])) {
    $req = $bdd->prepare('SELECT large FROM members WHERE pseudo = :pseudo');
            $req->execute(array(
    'pseudo' => $_SESSION['pseudo']));

$resultat = $req->fetch();
unlink(getcwd() . '/profilesimages/' .$resultat['large']);
        $filename = $_SESSION['id'];
        $filename2 = "large".$filename."im".mt_rand (1,10000);
        $targetpath2 = getcwd() . '/profilesimages/' . $filename2;
$img = $_POST['largeimagefile'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
file_put_contents($targetpath2, $data);

            $req = $bdd->prepare('UPDATE members SET large = :large WHERE pseudo = :pseudo');
            $req->execute(array(
    'large' => $filename2,
    'pseudo' => $_SESSION['pseudo']
    ));

            $_SESSION['large'] = $filename2;
echo "profilesimages/".$filename2;
    }



if(isset($_FILES['file']) and !$_FILES['file']['error'] && isset($_POST['rec'])){
    $rec = htmlspecialchars($_POST['rec']);
    $fname = "voiceMessage/name" . "F".$_SESSION['id']."to".$rec.mt_rand (1,9999999).mt_rand (1,555555).".ogg";

    move_uploaded_file($_FILES['file']['tmp_name'],  $fname);

    $reqq = $bdd->prepare('INSERT INTO chat(sender, receiver, message, sendate, type) VALUES(:sender, :receiver, :message, UTC_TIMESTAMP(), :type)');
$reqq->execute(array(
  'sender' => $_SESSION['id'],
  'receiver' => $rec,
  'message' => $fname,
  'type'=> 4
  ));
echo $fname;
}


if(isset($_POST['receiver']) AND isset($_FILES['img_message']) AND $_FILES['img_message']['error'] == 0){
    $user_id = htmlspecialchars($_POST['receiver']);

     if ($_FILES['img_message']['size'] <= 10000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['img_message']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    $p1 = mt_rand (1,9999999);
                    $p2 = mt_rand (1,555555);
                    $p3 = mt_rand (1,999999);
    $targetpath2 = "./imageMessage/name" . "F".$p3."aze712qs789jfb745823v1vd7687itt767idjcgpg86kb5n78gfc7s4fcv".$_SESSION['id']."to".$user_id."ut412u3tj8978gjgwb536wi63oyhh63262vfr95236517sxtg".$p1.$p2.".".$extension_upload;
    
                        move_uploaded_file($_FILES['img_message']['tmp_name'], $targetpath2);
$reqq = $bdd->prepare('INSERT INTO chat(sender, receiver, message, sendate, type) VALUES(:sender, :receiver, :message, UTC_TIMESTAMP(), :type)');
$reqq->execute(array(
  'sender' => $_SESSION['id'],
  'receiver' => $user_id,
  'message' => $targetpath2,
  'type'=> 3
  ));
echo $targetpath2;

                }
        }

}


if(isset($_POST['receiver']) AND isset($_FILES['textfile_message']) AND $_FILES['textfile_message']['error'] == 0){
    $user_id = htmlspecialchars($_POST['receiver']);

     if ($_FILES['textfile_message']['size'] <= 10000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['textfile_message']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('pdf', 'epub+zip');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    $p1 = mt_rand (1,9999999);
                    $p2 = mt_rand (1,555555);
                    $p3 = mt_rand (1,999999);
    $targetpath2 = "./bookMessge/name" . "F".$p3."aze712qs789jfb745823v1vd7687itt767idjcgpg86kb5n78gfc7s4fcv".$_SESSION['id']."to".$user_id."ut412u3tj8978gjgwb536wi63oyhh63262vfr95236517sxtg".$p1.$p2.".".$extension_upload;
    
                        move_uploaded_file($_FILES['textfile_message']['tmp_name'], $targetpath2);
$reqq = $bdd->prepare('INSERT INTO chat(sender, receiver, message, sendate, type) VALUES(:sender, :receiver, :message, UTC_TIMESTAMP(), :type)');
$reqq->execute(array(
  'sender' => $_SESSION['id'],
  'receiver' => $user_id,
  'message' => $targetpath2,
  'type'=> 2
  ));
echo $targetpath2;

                }
        }

}




if(isset($_POST['user_id']) AND isset($_POST['lien_msg'])){
  $ar = explode(",", htmlspecialchars($_POST['user_id']));
  $s = count($ar);
  $chat_msg = "post.php?post_id=" . htmlspecialchars($_POST['lien_msg']);

  for ($i=0; $i < $s ; $i++) { 
    $reqq = $bdd->prepare('INSERT INTO chat(sender, receiver, message, sendate, type) VALUES(:sender, :receiver, :message, UTC_TIMESTAMP(), :type)');
    $reqq->execute(array(
      'sender' => $_SESSION['id'],
      'receiver' => $ar[$i],
      'message' => $chat_msg,
      'type'=> 1
    ));
  }
}

if(isset($_POST['chat_msg']) AND isset($_POST['user_id'])){
  $user_id = htmlspecialchars($_POST['user_id']);
  $chat_msg = htmlspecialchars($_POST['chat_msg']);

  $reqq = $bdd->prepare('INSERT INTO chat(sender, receiver, message, sendate) VALUES(:sender, :receiver, :message, UTC_TIMESTAMP())');
  $reqq->execute(array(
    'sender' => $_SESSION['id'],
    'receiver' => $user_id,
    'message' => $chat_msg
  ));
}




?>
