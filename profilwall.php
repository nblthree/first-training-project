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
session_start();


function dateF($value)
{
    $y = strtotime("now") - strtotime($value);
        $monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if($y < 60){
            $r= $y."s";
        }
        else if($y < 3600){
            $r= floor($y/60)."m";
        }
        else if ($y < 86400){
            $r = floor($y/3600)."h";
        }
        else if ($y < 172800){
            $r = "Yesterday";
        }
        else {
            list($year, $month, $day) = array_values(date_parse($value));
            if(date("Y") == $year){
                if($day == 1){
                    $r = $day."st"." ".$monthNames[$month-1];
                }else if($day == 2){
                    $r = $day."nd"." ".$monthNames[$month-1];
                }else if($day == 3){
                    $r = $day."rd"." ".$monthNames[$month-1];
                }else{
                    $r = $day."th"." ".$monthNames[$month-1];
                }
            }else{
                if($day == 1){
                    $r = $day."st"." ".$monthNames[$month-1]." ".$year;
                }else if($day == 2){
                    $r = $day."nd"." ".$monthNames[$month-1]." ".$year;
                }else if($day == 3){
                    $r = $day."rd"." ".$monthNames[$month-1]." ".$year;
                }else{
                    $r = $day."th"." ".$monthNames[$month-1]." ".$year;
                }
            }
        }
        return $r;
}




if(isset($_POST['n']) AND isset($_POST['id'])){
	$id = htmlspecialchars($_POST['id']);
	$number = htmlspecialchars($_POST['n']);
	$i=0;
	$k=0;
    $f=0;
    $t=0;
    $arr=[];

$req1889 = $bdd->prepare('SELECT Ori_Id, Ori_partageur, s_time, partageur, share_Id FROM all_shares WHERE partageur = :partageur ORDER BY share_Id DESC');
$req1889->execute(array(
    'partageur'=> $id));
while ($resultat = $req1889->fetch()) {
    if($t==$number){

    $res = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
$res->execute(array(
    'id'=> $resultat['partageur']));
$rem = $res->fetch();

$reso = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
$reso->execute(array(
    'id'=> $resultat['Ori_partageur']));
$remo = $reso->fetch();


$ret = $bdd->prepare('SELECT unique_id, text_p, image, video FROM postes WHERE unique_id = :unique_id');
$ret->execute(array(
    'unique_id'=> $resultat['Ori_Id']));
$rem2 = $ret->fetch();

$color= "likes";
$req18899 = $bdd->prepare('SELECT liebhaber FROM likesdis WHERE unique_id = :unique_id');
$req18899->execute(array(
    'unique_id'=> $resultat['Ori_Id']));
$i=0;
while ($re = $req18899->fetch()) {
    $i++;
    if($re['liebhaber']==$_SESSION['id']){
        $color = "likes dis";
    }
}
$mj=0;
$reqds = $bdd->prepare('SELECT id_c FROM comment WHERE unique_id = :unique_id AND teilen = :teilen');
$reqds->execute(array(
    'unique_id'=> $resultat['Ori_Id'],
    'teilen' => $resultat['Ori_partageur']));
while ($ops = $reqds->fetch()) {
$mj++;
    }
if($rem2['video']=='null' AND $rem2['image']!='null'){
    $video_img = "<img width='100%' class='po_video_img' src='postes/".$rem2['image']."'>";
}else if($rem2['video']!='null' AND $rem2['image']=='null'){
    $video_img = "<video width='100%' style='background-color: #350707;' class='po_video_img' src='postes/".$rem2['video']."'></video>";
}else{
    $video_img = "";
}
$retweet = "";
$mu = -1;
$sha = 'sha';
$reu = $bdd->prepare('SELECT partageur, share_Id, Ori_Id FROM all_shares WHERE Ori_Id = :Ori_Id');
$reu->execute(array(
    'Ori_Id'=> $resultat['Ori_Id']));
while ($neu = $reu->fetch()) {
$mu++;
if($neu['partageur']==$_SESSION['id'] AND $neu['share_Id']!=$neu['Ori_Id']){
$sha = 'sha shaed';
    }
if($neu['partageur']==$id AND $neu['share_Id']!=$neu['Ori_Id']){
$retweet = "<div class='retw'>". $rem['pseudo'] ." retweeted</div>";
    }
}

if($sha == 'sha shaed'){
    $retweet = "<div class='retw'>You retweeted</div>";
}

$s = "<div class='numberliebe'><span class='".$sha."' id='numberSha,".$resultat['Ori_Id'].",".$resultat['Ori_partageur'].",".$remo['pseudo'].",".$resultat['partageur'].",".$rem['pseudo']."'></span><p>".$mu."</p></div>";
$tf = "<div class='numberliebe'><span class='tof' id='numberTof,".$resultat['Ori_Id'].",".$resultat['Ori_partageur'].",".$remo['pseudo'].",".$resultat['partageur'].",".$rem['pseudo']."'></span></div>";

    $data = "
<div id='cadreId,".$resultat['Ori_Id']."' class='cadre' style='width: 100%; padding: 0px; box-sizing: border-box;'>
    ".$retweet."
    <div class='m_top'>
        <div class='sharer'><div class='petitimage' style='background-image: url(profilesimages/mini/".$remo['avatarimageurl'].")'></div><p style='margin-left: 10px;'>".$remo['pseudo']."</p></div>
    </div>

    <div class='po_vi' style='height: auto;'>
        <div class='post_text' style='word-wrap: break-word; padding-bottom: 10px;'>".$rem2['text_p']."</div>
        <div class='video_img'>".$video_img."</div>
    </div>

    <div class='bottom'><div class='likeDislike'><div class='numberliebe'><span class='".$color."' id='numberLikes,".$resultat['Ori_Id'].",".$resultat['Ori_partageur'].",".$remo['pseudo'].",".$resultat['partageur'].",".$rem['pseudo']."'></span><p id='NL".$resultat['Ori_Id']."'>".$i."</p></div><div class='numberliebe'><span class='kommentar' id='numberKommentar,".$resultat['Ori_Id'].",".$resultat['Ori_partageur'].",".$remo['pseudo'].",".$resultat['partageur'].",".$rem['pseudo']."'></span><p>".$mj."</p></div>".$s.$tf."</div><p>".dateF($resultat['s_time'])."</p></div>
</div>";

    echo json_encode([$data, $resultat['Ori_Id']]);
}
   $t++;

}
}

if (isset($_POST['pseu']) AND isset($_POST['idl'])) {
    $id = htmlspecialchars($_POST['pseu']);
    $idl = htmlspecialchars($_POST['idl']);
    $reqid = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
    $reqid->execute(array(
    'id' => $id));
    $resultatid = $reqid->fetch();
$arrt = [];
array_push($arrt, $resultatid['pseudo'], $resultatid['avatarimageurl']);
$reqidl = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
    $reqidl->execute(array(
    'id' => $idl));
    $resultatidl = $reqidl->fetch();
    array_push($arrt, $resultatidl['pseudo'], $resultatidl['avatarimageurl']);
echo json_encode($arrt);
}


if (isset($_POST['resp']) AND isset($_POST['unique'])) {

    $iop = htmlspecialchars($_POST['resp']);
    $unique = htmlspecialchars($_POST['unique']);
    $reqrt = $bdd->prepare('SELECT lid FROM likesdis WHERE unique_id = :unique_id AND teilen = :teilen AND liebhaber = :liebhaber');
    $reqrt->execute(array(
    'unique_id'=> $unique,
    'teilen' => $iop,
    'liebhaber' => $_SESSION['id']));
    $resultat = $reqrt->fetch();
    if(!$resultat){
        echo "0";
    }
    else{
        echo "1";
    }
}

if (isset($_POST['iop']) AND isset($_POST['unique']) AND isset($_POST['siop'])) {

    $iop = htmlspecialchars($_POST['iop']);
    $siop = htmlspecialchars($_POST['siop']);
    $unique = htmlspecialchars($_POST['unique']);

    $reqrt = $bdd->prepare('SELECT lid FROM likesdis WHERE unique_id = :unique_id AND teilen = :teilen AND liebhaber = :liebhaber');
    $reqrt->execute(array(
    'unique_id'=> $unique,
    'teilen' => $iop,
    'liebhaber' => $_SESSION['id']));
    $resultat = $reqrt->fetch();
    if(!$resultat){
        $reqd = $bdd->prepare('INSERT INTO likesdis(unique_id, teilen, liebhaber) VALUES(:unique_id, :teilen, :liebhaber)');
$reqd->execute(array(
    'unique_id'=> $unique,
    'teilen' => $iop,
    'liebhaber' => $_SESSION['id']));

if($_SESSION['id'] != $iop){
    $reqdbn = $bdd->prepare('INSERT INTO notification(Id, Id_macher, Id_p, liebe) VALUES(:Id, :Id_macher, :Id_p, :liebe)');
$reqdbn->execute(array(
    'Id'=> $iop,
    'Id_macher' => $_SESSION['id'],
    'Id_p' => $unique,
    'liebe' => 1));
}

if($iop != $siop AND $_SESSION['id'] != $siop){
    $reqdjn = $bdd->prepare('INSERT INTO notification(Id, Id_macher, Id_p, liebe) VALUES(:Id, :Id_macher, :Id_p, :liebe)');
$reqdjn->execute(array(
    'Id'=> $siop,
    'Id_macher' => $_SESSION['id'],
    'Id_p' => $unique,
    'liebe' => 1));
    }
}
}

if (isset($_POST['ip']) AND isset($_POST['unique']) AND isset($_POST['sip'])) {

    $iop = htmlspecialchars($_POST['ip']);
    $siop = htmlspecialchars($_POST['sip']);
    $unique = htmlspecialchars($_POST['unique']);

    $reqrt = $bdd->prepare('SELECT lid FROM likesdis WHERE unique_id = :unique_id AND teilen = :teilen AND liebhaber = :liebhaber');
    $reqrt->execute(array(
    'unique_id'=> $unique,
    'teilen' => $iop,
    'liebhaber' => $_SESSION['id']));
    $resultat = $reqrt->fetch();
    if($resultat){
        $requy = $bdd->prepare('DELETE FROM likesdis WHERE unique_id = :unique_id AND teilen = :teilen AND liebhaber = :liebhaber');
        $requy->execute(array(
    'unique_id'=> $unique,
    'teilen' => $iop,
    'liebhaber' => $_SESSION['id']));

$reqd = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND Id_p = :Id_p AND liebe = :liebe');
$reqd->execute(array(
    'Id'=> $iop,
    'Id_macher' => $_SESSION['id'],
    'Id_p' => $unique,
    'liebe' => 1));
if($iop != $siop){
    $reqd = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND Id_p = :Id_p AND liebe = :liebe');
$reqd->execute(array(
    'Id'=> $siop,
    'Id_macher' => $_SESSION['id'],
    'Id_p' => $unique,
    'liebe' => 1));
    }

    }
}

if (isset($_POST['ipp']) AND isset($_POST['unique'])) {
    $iop = htmlspecialchars($_POST['ipp']);
    $unique = htmlspecialchars($_POST['unique']);
    $reqrt = $bdd->prepare('SELECT lid FROM likesdis WHERE unique_id = :unique_id AND teilen = :teilen');
    $reqrt->execute(array(
    'unique_id'=> $unique,
    'teilen' => $iop,));
    $i=0;
    while ($resultat = $reqrt->fetch()) {
        $i++;
    }
    echo $i;
}



if(isset($_POST['tei']) AND isset($_POST['stei']) AND isset($_POST['unique']) AND isset($_POST['com']) AND strlen($_POST['com'])>0){
    $t= htmlspecialchars($_POST['tei']);
    $st= htmlspecialchars($_POST['stei']);
    $u= htmlspecialchars($_POST['unique']);
    $c= htmlspecialchars($_POST['com']);

$reqd = $bdd->prepare('INSERT INTO comment(unique_id, teilen, denke, com, co_time) VALUES(:unique_id, :teilen, :denke, :com, UTC_TIMESTAMP())');
$reqd->execute(array(
    'unique_id'=> $u,
    'teilen' => $t,
    'denke' => $_SESSION['id'],
    'com'=> $c));
$reqd = $bdd->prepare('SELECT id_c FROM comment WHERE unique_id = :unique_id AND teilen = :teilen AND denke = :denke AND com = :com ORDER By id_c DESC LIMIT 1');
$reqd->execute(array(
    'unique_id'=> $u,
    'teilen' => $t,
    'denke' => $_SESSION['id'],
    'com' => $c));
$resultat = $reqd->fetch();

if($_SESSION['id'] != $t){
    $reqd = $bdd->prepare('INSERT INTO notification(Id, Id_macher, Id_p, Id_k) VALUES(:Id, :Id_macher, :Id_p, :Id_k)');
    $reqd->execute(array(
        'Id'=> $t,
        'Id_macher' => $_SESSION['id'],
        'Id_p' => $u,
        'Id_k' => $resultat['id_c']));
}
if($t != $st AND $st != $_SESSION['id']){
    $reqd = $bdd->prepare('INSERT INTO notification(Id, Id_macher, Id_p, Id_k) VALUES(:Id, :Id_macher, :Id_p, :Id_k)');
    $reqd->execute(array(
        'Id'=> $st,
        'Id_macher' => $_SESSION['id'],
        'Id_p' => $u,
        'Id_k' => $resultat['id_c']));
}


}

if(isset($_POST['id_k']) AND isset($_POST['p_id']) AND isset($_POST['witch'])){
    $id_c = htmlspecialchars($_POST['id_k']);
    $p_id = htmlspecialchars($_POST['p_id']);
    $witch = htmlspecialchars($_POST['witch']);

if($witch == 0){
    $retm = $bdd->prepare('SELECT * FROM comment WHERE id_c = :id_c');
$retm->execute(array(
    'id_c'=> $id_c));
$resultat = $retm->fetch();

$n=0;
$retm = $bdd->prepare('SELECT master FROM kommentar WHERE comment_id = :comment_id AND witch = :witch');
$retm->execute(array(
    'comment_id'=> $resultat['id_c'],
    'witch' => 0));
while ($imn = $retm->fetch()) {
    $n++;
}

$retm = $bdd->prepare('SELECT master FROM ko_liebe WHERE comment_id = :comment_id AND witch = :witch');
$retm->execute(array(
    'comment_id'=> $resultat['id_c'],
    'witch' => 0));
$num=0;
$l="likes2";
while($imn = $retm->fetch()){
    $num++;
    if($imn['master']==$_SESSION['id']){
        $l="likes2 dis2";
    }
}


    $ret = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
$ret->execute(array(
    'id'=> $resultat['denke']));
$im = $ret->fetch();
?>
<div class='topSaf' id='k,<?php echo $resultat['id_c']; ?>,<?php echo $p_id; ?>,<?php echo $resultat['denke']; ?>,0'>
<div id="randomimage" style="width: 100%; display: flex;">
<span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $im['avatarimageurl']; ?>);"><a style="height: 100%; width: 100%; display: block;" href="profile.php?pseudo=<?php echo $im['pseudo']; ?>"></a></span>
<span style="line-height: 50px; margin-left: 10px;"><?php echo $im['pseudo']; ?></span>
</div>
<div style="word-wrap: break-word; padding-left: 60px;"><?php echo $resultat['com']; ?></div>
<div style="display: flex; justify-content: flex-end; font-size: 12px; padding: 8px;">
<div class="KLK" style="height: 20px; width: calc(100% - 150px); padding-left: 5px; display: flex; justify-content: flex-start;"><div class="KoLiebe" style="line-height: 20px;"><span class="<?php echo $l; ?>" id="nKL,<?php echo $resultat['id_c']; ?>,0,<?php echo $p_id; ?>,<?php echo $resultat['denke']; ?>"></span><p><?php echo $num; ?></p></div><div class="KoLiebe" style="line-height: 20px;"><span class="komkom" id="nKre,<?php echo $resultat['id_c']; ?>,<?php echo $im['pseudo']; ?>,<?php echo $resultat['com']; ?>,<?php echo $p_id; ?>,<?php echo $resultat['denke']; ?>,0"></span><p><?php echo $n; ?></p></div></div>
<div style="display: flex; justify-content: flex-end; font-size: 12px; width: 150px;"><?php echo dateF($resultat['co_time']); ?></div>
</div>
</div>
<?php
}else {
    $retm = $bdd->prepare('SELECT * FROM kommentar WHERE id_k = :id_k');
$retm->execute(array(
    'id_k'=> $id_c));
$resultat = $retm->fetch();

$n=0;
$retm = $bdd->prepare('SELECT master FROM kommentar WHERE comment_id = :comment_id AND witch = :witch');
$retm->execute(array(
    'comment_id'=> $resultat['id_k'],
    'witch' => 1));
while ($imn = $retm->fetch()) {
    $n++;
}

$retm = $bdd->prepare('SELECT master FROM ko_liebe WHERE comment_id = :comment_id AND witch = :witch');
$retm->execute(array(
    'comment_id'=> $resultat['id_k'],
    'witch' => 1));
$num=0;
$l="likes2";
while($imn = $retm->fetch()){
    $num++;
    if($imn['master']==$_SESSION['id']){
        $l="likes2 dis2";
    }
}


    $ret = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
$ret->execute(array(
    'id'=> $resultat['master']));
$im = $ret->fetch();
?>
<div class='topSaf' id='k,<?php echo $resultat['id_k']; ?>,<?php echo $p_id; ?>,<?php echo $resultat['master']; ?>,1'>
<div id="randomimage" style="width: 100%; display: flex;">
<span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $im['avatarimageurl']; ?>);"><a style="height: 100%; width: 100%; display: block;" href="profile.php?pseudo=<?php echo $im['pseudo']; ?>"></a></span>
<span style="line-height: 50px; margin-left: 10px;"><?php echo $im['pseudo']; ?></span>
</div>
<div style="word-wrap: break-word; padding-left: 60px;"><?php echo $resultat['comment']; ?></div>
<div style="display: flex; justify-content: flex-end; font-size: 12px; padding: 8px;">
<div class="KLK" style="height: 20px; width: calc(100% - 150px); padding-left: 5px; display: flex; justify-content: flex-start;"><div class="KoLiebe" style="line-height: 20px;"><span class="<?php echo $l; ?>" id="nKL,<?php echo $resultat['id_c']; ?>,0,<?php echo $p_id; ?>,<?php echo $resultat['master']; ?>"></span><p><?php echo $num; ?></p></div><div class="KoLiebe" style="line-height: 20px;"><span class="komkom" id="nKre,<?php echo $resultat['id_k']; ?>,<?php echo $im['pseudo']; ?>,<?php echo $resultat['comment']; ?>,<?php echo $p_id; ?>,<?php echo $resultat['master']; ?>,1"></span><p><?php echo $n; ?></p></div></div>
<div style="display: flex; justify-content: flex-end; font-size: 12px; width: 150px;"><?php echo dateF($resultat['comment_time']); ?></div>
</div>
</div>
<?php
}




    $retml = $bdd->prepare('SELECT comment, master, comment_time, id_k FROM kommentar WHERE comment_id = :comment_id AND witch = :witch ORDER BY id_k DESC');
$retml->execute(array(
    'comment_id'=> $id_c,
    'witch' => $witch));


while ($imn = $retml->fetch()) {

$n=0;
$retm = $bdd->prepare('SELECT master FROM kommentar WHERE comment_id = :comment_id AND witch = :witch');
$retm->execute(array(
    'comment_id'=> $imn['id_k'],
    'witch' => 1));
while ($imnj = $retm->fetch()) {
    $n++;
}

$retm = $bdd->prepare('SELECT master FROM ko_liebe WHERE comment_id = :comment_id AND witch = :witch');
$retm->execute(array(
    'comment_id'=> $imn['id_k'],
    'witch' => 1));
$num=0;
$l="likes2";
while($imnl = $retm->fetch()){
    $num++;
    if($imnl['master']==$_SESSION['id']){
        $l="likes2 dis2";
    }
}

    $ret = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
$ret->execute(array(
    'id'=> $imn['master']));
$im = $ret->fetch();
?>
 <div class='saf' style='margin-right: -5px; border-color: #9e9dc1;' id='kk,<?php echo $imn['id_k']; ?>,<?php echo $p_id; ?>,<?php echo $imn['master']; ?>,1'>
<div id='randomimage' style='width: 100%; display: flex;'>
<span id='avataricon' style='background-image: url(profilesimages/mini/<?php echo $im['avatarimageurl']; ?>'><a style='height: 100%; width: 100%; display: block;' href='profile.php?pseudo=<?php echo $im['pseudo']; ?>'></a></span>
<span style='line-height: 50px; margin-left: 10px;''><?php echo $im['pseudo']; ?></span>
</div>
<div style='word-wrap: break-word; padding-left: 60px;'><?php echo $imn['comment']; ?></div>
<div style="display: flex; justify-content: flex-end; font-size: 12px; padding: 8px;">
<div class="KLK" style="height: 20px; width: calc(100% - 150px); padding-left: 5px; display: flex; justify-content: flex-start;"><div class="KoLiebe" style="line-height: 20px;"><span class="<?php echo $l; ?>" id="nKL,<?php echo $imn['id_k']; ?>,1,<?php echo $p_id; ?>,<?php echo $imn['master']; ?>"></span><p><?php echo $num; ?></p></div><div class="KoLiebe" style="line-height: 20px;"><span class="komkom" id="nK,<?php echo $imn['id_k']; ?>,<?php echo $im['pseudo']; ?>,<?php echo $imn['comment']; ?>,<?php echo $p_id; ?>,<?php echo $imn['master']; ?>,1"></span><p><?php echo $n; ?></p></div></div>
<div style="display: flex; justify-content: flex-end; font-size: 12px; width: 150px;"><?php echo dateF($imn['comment_time']); ?></div>
</div>
</div>
<?php
}
}

if(isset($_POST['teig']) AND isset($_POST['uniqueg'])){

    $t= htmlspecialchars($_POST['teig']);
    $u= htmlspecialchars($_POST['uniqueg']);


$reqd = $bdd->prepare('SELECT com, denke, co_time, id_c FROM comment WHERE unique_id = :unique_id AND teilen = :teilen ORDER BY id_c DESC');
$reqd->execute(array(
    'unique_id'=> $u,
    'teilen' => $t));
while ($resultat = $reqd->fetch()) {

$n=0;
$retm = $bdd->prepare('SELECT master FROM kommentar WHERE comment_id = :comment_id AND witch = :witch');
$retm->execute(array(
    'comment_id'=> $resultat['id_c'],
    'witch' => 0));
while ($imn = $retm->fetch()) {
    $n++;
}

$retm = $bdd->prepare('SELECT master FROM ko_liebe WHERE comment_id = :comment_id AND witch = :witch');
$retm->execute(array(
    'comment_id'=> $resultat['id_c'],
    'witch' => 0));
$num=0;
$l="likes2";
while($imn = $retm->fetch()){
    $num++;
    if($imn['master']==$_SESSION['id']){
        $l="likes2 dis2";
    }
}


    $ret = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
$ret->execute(array(
    'id'=> $resultat['denke']));
$im = $ret->fetch();
?>
<div class='saf' id='k,<?php echo $resultat['id_c']; ?>,<?php echo $u; ?>,<?php echo $resultat['denke']; ?>,0'>
<div id="randomimage" style="width: 100%; display: flex;">
<span id="avataricon" style="background-image: url(profilesimages/mini/<?php echo $im['avatarimageurl']; ?>);"><a style="height: 100%; width: 100%; display: block;" href="profile.php?pseudo=<?php echo $im['pseudo']; ?>"></a></span>
<span style="line-height: 50px; margin-left: 10px;"><?php echo $im['pseudo']; ?></span>
</div>
<div style="word-wrap: break-word; padding-left: 60px;"><?php echo $resultat['com']; ?></div>
<div style="display: flex; justify-content: flex-end; font-size: 12px; padding: 8px;">
<div class="KLK" style="height: 20px; width: calc(100% - 150px); padding-left: 5px; display: flex; justify-content: flex-start;"><div class="KoLiebe" style="line-height: 20px;"><span class="<?php echo $l; ?>" id="nKL,<?php echo $resultat['id_c']; ?>,0,<?php echo $u; ?>,<?php echo $resultat['denke']; ?>"></span><p><?php echo $num; ?></p></div><div class="KoLiebe" style="line-height: 20px;"><span class="komkom" id="nK,<?php echo $resultat['id_c']; ?>,<?php echo $im['pseudo']; ?>,<?php echo $resultat['com']; ?>,<?php echo $u; ?>,<?php echo $resultat['denke']; ?>,0"></span><p><?php echo $n; ?></p></div></div>
<div style="display: flex; justify-content: flex-end; font-size: 12px; width: 150px;"><?php echo dateF($resultat['co_time']); ?></div>
</div>
</div>
<?php
}


}


if (isset($_POST['uniquexp']) AND isset($_POST['witch']) AND isset($_POST['p_id']) AND isset($_POST['co_master'])) {

    $unique = htmlspecialchars($_POST['uniquexp']);
    $witch = htmlspecialchars($_POST['witch']);
    $p_id = htmlspecialchars($_POST['p_id']);
    $co_master = htmlspecialchars($_POST['co_master']);

    $reqrt = $bdd->prepare('SELECT id_l FROM ko_liebe WHERE comment_id = :comment_id AND master = :master AND witch = :witch');
    $reqrt->execute(array(
    'comment_id'=> $unique,
    'master' => $_SESSION['id'],
    'witch' => $witch));
    $resultat = $reqrt->fetch();
    if(!$resultat){
        $reqd = $bdd->prepare('INSERT INTO ko_liebe(comment_id, master, witch) VALUES(:comment_id, :master, :witch)');
$reqd->execute(array(
    'comment_id'=> $unique,
    'master' => $_SESSION['id'],
    'witch' => $witch));

if($_SESSION['id'] != $co_master){
    $reqd = $bdd->prepare('INSERT INTO notification(Id, Id_macher, Id_p, Id_kkl) VALUES(:Id, :Id_macher, :Id_p, :Id_kkl)');
    $reqd->execute(array(
        'Id'=> $co_master,
        'Id_macher' => $_SESSION['id'],
        'Id_p' => $p_id,
        'Id_kkl' => $unique.",".$witch));
}

    }else{
        $requy = $bdd->prepare('DELETE FROM ko_liebe WHERE comment_id = :comment_id AND master = :master AND witch = :witch');
        $requy->execute(array(
    'comment_id'=> $unique,
    'master' => $_SESSION['id'],
    'witch' => $witch));
if($_SESSION['id'] != $co_master){
    $requy = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND Id_p = :Id_p AND Id_kkl = :Id_kkl');
    $requy->execute(array(
        'Id'=> $co_master,
        'Id_macher' => $_SESSION['id'],
        'Id_p' => $p_id,
        'Id_kkl' => $unique.",".$witch));
}
    }

}


if(isset($_POST['uniquex']) AND isset($_POST['comx']) AND strlen($_POST['uniquex'])>0 AND isset($_POST['tko']) AND isset($_POST['uni']) AND isset($_POST['witch'])){
    $unique = htmlspecialchars($_POST['uniquex']);
    $c = htmlspecialchars($_POST['comx']);

    $tko = htmlspecialchars($_POST['tko']);
    $uni = htmlspecialchars($_POST['uni']);

    $witch = htmlspecialchars($_POST['witch']);

    $reqd = $bdd->prepare('INSERT INTO kommentar(comment_id, comment, master, witch, comment_time) VALUES(:comment_id, :comment, :master, :witch, UTC_TIMESTAMP())');
$reqd->execute(array(
    'comment_id'=> $unique,
    'comment'=> $c,
    'master' => $_SESSION['id'],
    'witch' => $witch));

$reqd = $bdd->prepare('SELECT id_k FROM kommentar WHERE comment_id = :comment_id AND comment = :comment AND master = :master AND witch = :witch ORDER By id_k DESC LIMIT 1');
$reqd->execute(array(
    'comment_id'=> $unique,
    'comment' => $c,
    'master' => $_SESSION['id'],
    'witch' => $witch));
$resultat = $reqd->fetch();

if($_SESSION['id'] != $tko){
    $reqd = $bdd->prepare('INSERT INTO notification(Id, Id_macher, Id_p, Id_kkc) VALUES(:Id, :Id_macher, :Id_p, :Id_kkc)');
    $reqd->execute(array(
        'Id'=> $tko,
        'Id_macher' => $_SESSION['id'],
        'Id_p' => $uni,
        'Id_kkc' => $unique.",".$witch));
}



}




if(isset($_POST['textp']) AND strlen($_POST['textp'])){
    $text = htmlspecialchars($_POST['textp']);


$reqd = $bdd->prepare('INSERT INTO all_shares(partageur, Ori_partageur, s_time) VALUES(:partageur, :Ori_partageur, UTC_TIMESTAMP())');
$reqd->execute(array(
    'partageur'=> $_SESSION['id'],
    'Ori_partageur' => $_SESSION['id'],
    ));
$red = $bdd->prepare('SELECT share_Id FROM all_shares WHERE partageur = :partageur ORDER BY share_Id DESC LIMIT 1');
$red->execute(array(
    'partageur'=> $_SESSION['id'],
    ));
$id = $red->fetch();

    $req8888 = $bdd->prepare('UPDATE all_shares SET Ori_Id = :Ori_Id WHERE share_Id = :share_Id');
    $req8888->execute(array(
    'Ori_Id' =>  $id['share_Id'],            
    'share_Id' => $id['share_Id']
    ));


$reqq = $bdd->prepare('INSERT INTO postes(unique_id, text_p, image, video) VALUES(:unique_id, :text_p, :image, :video)');
$reqq->execute(array(
  'unique_id' => $id['share_Id'],
  'text_p' => $text,
  'image' => 'null',
  'video' => 'null',
  ));

$reqr = $bdd->prepare('SELECT shares FROM members WHERE id = :id');
$reqr->execute(array(
    'id' => $_SESSION['id'],
    ));
$dr = $reqr->fetch();
$e = $dr['shares'] +1;
$ret = $bdd->prepare('UPDATE members SET shares = :shares WHERE id = :id');
            $ret->execute(array(
    'shares' => $e,            
    'id' => $_SESSION['id']
    ));
            
}


if(isset($_POST['p_texti']) AND isset($_FILES['p_file_img']) AND $_FILES['p_file_img']['error'] == 0){
    $text = htmlspecialchars($_POST['p_texti']);

     if ($_FILES['p_file_img']['size'] <= 10000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['p_file_img']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
$reqd = $bdd->prepare('INSERT INTO all_shares(partageur, Ori_partageur, s_time) VALUES(:partageur, :Ori_partageur, UTC_TIMESTAMP())');
$reqd->execute(array(
    'partageur'=> $_SESSION['id'],
    'Ori_partageur' => $_SESSION['id']
    ));
$red = $bdd->prepare('SELECT share_Id FROM all_shares WHERE partageur = :partageur ORDER BY share_Id DESC LIMIT 1');
$red->execute(array(
    'partageur'=> $_SESSION['id'],
    ));
$id = $red->fetch();

    $req8888 = $bdd->prepare('UPDATE all_shares SET Ori_Id = :Ori_Id WHERE share_Id = :share_Id');
    $req8888->execute(array(
    'Ori_Id' =>  $id['share_Id'],            
    'share_Id' => $id['share_Id']
    ));
    $targetpath2 = 'Image' . $id['share_Id'] . "." . $extension_upload;
                        move_uploaded_file($_FILES['p_file_img']['tmp_name'], 'postes/' . $targetpath2);
    $reqq = $bdd->prepare('INSERT INTO postes(unique_id, text_p, image, video) VALUES(:unique_id, :text_p, :image, :video)');
$reqq->execute(array(
  'unique_id' => $id['share_Id'],
  'text_p' => $text,
  'image' => $targetpath2,
  'video' => 'null',
  ));
$reqr = $bdd->prepare('SELECT shares FROM members WHERE id = :id');
$reqr->execute(array(
    'id' => $_SESSION['id'],
    ));
$dr = $reqr->fetch();
$e = $dr['shares'] +1;
$ret = $bdd->prepare('UPDATE members SET shares = :shares WHERE id = :id');
            $ret->execute(array(
    'shares' => $e,            
    'id' => $_SESSION['id']
    ));
                }
        }

}


if(isset($_POST['p_textv']) AND isset($_FILES['p_file_vid']) AND $_FILES['p_file_vid']['error'] == 0){
    $text = htmlspecialchars($_POST['p_textv']);

     if ($_FILES['p_file_vid']['size'] <= 120000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['p_file_vid']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('mp4', 'webm', '3g2', '3gp', '3gpp', 'avi', 'mkv', 'wmv', 'ogg');
                if (in_array($extension_upload, $extensions_autorisees))
                {
$reqd = $bdd->prepare('INSERT INTO all_shares(partageur, Ori_partageur, s_time) VALUES(:partageur, :Ori_partageur, UTC_TIMESTAMP())');
$reqd->execute(array(
    'partageur'=> $_SESSION['id'],
    'Ori_partageur' => $_SESSION['id']
    ));
$red = $bdd->prepare('SELECT share_Id FROM all_shares WHERE partageur = :partageur ORDER BY share_Id DESC LIMIT 1');
$red->execute(array(
    'partageur'=> $_SESSION['id'],
    ));
$id = $red->fetch();

    $req8888 = $bdd->prepare('UPDATE all_shares SET Ori_Id = :Ori_Id WHERE share_Id = :share_Id');
    $req8888->execute(array(
    'Ori_Id' =>  $id['share_Id'],            
    'share_Id' => $id['share_Id']
    ));
    $targetpath2 = 'Video' . $id['share_Id'] . "." . $extension_upload;
                        move_uploaded_file($_FILES['p_file_vid']['tmp_name'], 'postes/' . $targetpath2);
    $reqq = $bdd->prepare('INSERT INTO postes(unique_id, text_p, image, video) VALUES(:unique_id, :text_p, :image, :video)');
$reqq->execute(array(
  'unique_id' => $id['share_Id'],
  'text_p' => $text,
  'image' => 'null',
  'video' => $targetpath2,
  ));
$reqr = $bdd->prepare('SELECT shares FROM members WHERE id = :id');
$reqr->execute(array(
    'id' => $_SESSION['id'],
    ));
$dr = $reqr->fetch();
$e = $dr['shares'] +1;
$ret = $bdd->prepare('UPDATE members SET shares = :shares WHERE id = :id');
            $ret->execute(array(
    'shares' => $e,            
    'id' => $_SESSION['id']
    ));
                }
        }

}





if(isset($_POST['shao']) AND isset($_POST['shau'])){
    $u = htmlspecialchars($_POST['shau']);
    $o = htmlspecialchars($_POST['shao']);
$red = $bdd->prepare('SELECT s_time FROM all_shares WHERE Ori_partageur = :Ori_partageur AND share_Id = :share_Id ORDER BY share_Id DESC LIMIT 1');
$red->execute(array(
    'Ori_partageur'=> $o,
    'share_Id'=> $u
    ));
$id = $red->fetch();
    $reqd = $bdd->prepare('INSERT INTO all_shares(partageur, Ori_Id, Ori_partageur, s_time) VALUES(:partageur, :Ori_Id, :Ori_partageur, :s_time)');
$reqd->execute(array(
    'partageur'=> $_SESSION['id'],
    'Ori_Id'=> $u,
    'Ori_partageur' => $o,
    's_time'=> $id['s_time']
    ));

if($_SESSION['id'] != $o){
    $reqd = $bdd->prepare('INSERT INTO notification(Id, Id_macher, Id_p, shared) VALUES(:Id, :Id_macher, :Id_p, :shared)');
    $reqd->execute(array(
        'Id'=> $o,
        'Id_macher' => $_SESSION['id'],
        'Id_p' => $u,
        'shared' => 1));
}

$reqr = $bdd->prepare('SELECT shares FROM members WHERE id = :id');
$reqr->execute(array(
    'id' => $_SESSION['id'],
    ));
$dr = $reqr->fetch();
$e = $dr['shares'] + 1;
$ret = $bdd->prepare('UPDATE members SET shares = :shares WHERE id = :id');
            $ret->execute(array(
    'shares' => $e,            
    'id' => $_SESSION['id']
    ));
}


if(isset($_POST['shaooff']) AND isset($_POST['shauoff'])){
    $u = htmlspecialchars($_POST['shauoff']);
    $o = htmlspecialchars($_POST['shaooff']);

    $reqd = $bdd->prepare('DELETE FROM all_shares WHERE partageur = :partageur AND Ori_Id = :Ori_Id AND Ori_partageur = :Ori_partageur AND share_Id != :share_Id');
$reqd->execute(array(
    'partageur'=> $_SESSION['id'],
    'Ori_Id'=> $u,
    'Ori_partageur'=> $o,
    'share_Id'=> $u
    ));

if($_SESSION['id'] != $o){
    $requy = $bdd->prepare('DELETE FROM notification WHERE Id = :Id AND Id_macher = :Id_macher AND Id_p = :Id_p AND shared = :shared');
    $requy->execute(array(
        'Id'=> $o,
        'Id_macher' => $_SESSION['id'],
        'Id_p' => $p_id,
        'shared' => 1));
}

$reqr = $bdd->prepare('SELECT shares FROM members WHERE id = :id');
$reqr->execute(array(
    'id' => $_SESSION['id'],
    ));
$dr = $reqr->fetch();
$e = $dr['shares'] - 1;
$ret = $bdd->prepare('UPDATE members SET shares = :shares WHERE id = :id');
            $ret->execute(array(
    'shares' => $e,            
    'id' => $_SESSION['id']
    ));
}













if(isset($_POST['post_id'])){
    $id = htmlspecialchars($_POST['post_id']);
    $i=0;
    $k=0;
    $f=0;
    $t=0;
    $arr=[];

$req1889 = $bdd->prepare('SELECT Ori_Id, Ori_partageur, s_time, partageur, share_Id FROM all_shares WHERE share_Id = :share_Id');
$req1889->execute(array(
    'share_Id'=> $id));
$resultat = $req1889->fetch();

if($resultat){

    $res = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
$res->execute(array(
    'id'=> $resultat['partageur']));
$rem = $res->fetch();

$reso = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE id = :id');
$reso->execute(array(
    'id'=> $resultat['Ori_partageur']));
$remo = $reso->fetch();


$ret = $bdd->prepare('SELECT unique_id, text_p, image, video FROM postes WHERE unique_id = :unique_id');
$ret->execute(array(
    'unique_id'=> $resultat['Ori_Id']));
$rem2 = $ret->fetch();

$color= "likes";
$req18899 = $bdd->prepare('SELECT liebhaber FROM likesdis WHERE unique_id = :unique_id');
$req18899->execute(array(
    'unique_id'=> $resultat['Ori_Id']));
$i=0;
while ($re = $req18899->fetch()) {
    $i++;
    if($re['liebhaber']==$_SESSION['id']){
        $color = "likes dis";
    }
}
$mj=0;
$reqds = $bdd->prepare('SELECT id_c FROM comment WHERE unique_id = :unique_id AND teilen = :teilen');
$reqds->execute(array(
    'unique_id'=> $resultat['Ori_Id'],
    'teilen' => $resultat['Ori_partageur']));
while ($ops = $reqds->fetch()) {
$mj++;
    }
if($rem2['video']=='null' AND $rem2['image']!='null'){
    $video_img = "<img width='100%' class='po_video_img' src='postes/".$rem2['image']."'>";
}else if($rem2['video']!='null' AND $rem2['image']=='null'){
    $video_img = "<video width='100%' style='background-color: #350707;' class='po_video_img' src='postes/".$rem2['video']."' ></video>";
}else{
    $video_img = "";
}
$retweet = "";
$mu = -1;
$sha = 'sha';
$reu = $bdd->prepare('SELECT partageur, share_Id, Ori_Id FROM all_shares WHERE Ori_Id = :Ori_Id');
$reu->execute(array(
    'Ori_Id'=> $resultat['Ori_Id']));
while ($neu = $reu->fetch()) {
$mu++;
if($neu['partageur']==$_SESSION['id'] AND $neu['share_Id']!=$neu['Ori_Id']){
$sha = 'sha shaed';
    }
}


$s = "<div class='numberliebe'><span class='".$sha."' id='numberSha,".$resultat['Ori_Id'].",".$resultat['Ori_partageur'].",".$remo['pseudo'].",".$resultat['partageur'].",".$rem['pseudo']."'></span><p>".$mu."</p></div>";
$tf = "<div class='numberliebe'><span class='tof' id='numberTof,".$resultat['Ori_Id'].",".$resultat['Ori_partageur'].",".$remo['pseudo'].",".$resultat['partageur'].",".$rem['pseudo']."'></span></div>";

    $data = "
<div class='cadre' style='width: 100%; padding: 0px; box-sizing: border-box;'>
    ".$retweet."
    <div class='m_top'>
        <div class='sharer'><div class='petitimage' style='background-image: url(profilesimages/mini/".$remo['avatarimageurl'].")'></div><p style='margin-left: 10px;'>".$remo['pseudo']."</p></div>
    </div>

    <div class='po_vi' style='height: auto;'>
        <div class='post_text' style='word-wrap: break-word; padding-bottom: 10px;'>".$rem2['text_p']."</div>
        <div class='video_img'>".$video_img."</div>
    </div>

    <div class='bottom'><div class='likeDislike'><div class='numberliebe'><span class='".$color."' id='numberLikes,".$resultat['Ori_Id'].",".$resultat['Ori_partageur'].",".$remo['pseudo'].",".$resultat['partageur'].",".$rem['pseudo']."'></span><p id='NL".$resultat['Ori_Id']."'>".$i."</p></div><div class='numberliebe'><span class='kommentar' id='numberKommentar,".$resultat['Ori_Id'].",".$resultat['Ori_partageur'].",".$remo['pseudo'].",".$resultat['partageur'].",".$rem['pseudo']."'></span><p>".$mj."</p></div>".$s.$tf."</div><p>".dateF($resultat['s_time'])."</p></div>
    <div id='ko' style='width: 100%;'></div>
</div>";

    echo json_encode($data);

}else{
    echo json_encode("Error page doesn't exist.");
}
}



//Notifications Sitting

if(isset($_POST['notf'])){
    $re = $bdd->prepare('SELECT Id_macher, Id_p, liebe, Id_k, Id_kkc, Id_kkl, readingSteiner, shared, friend FROM notification WHERE Id = :Id ORDER BY idn DESC');
    $re->execute(array(
        'Id'=> $_SESSION['id']));

$ar1 = [];
$ar2 = [];
$ar3 = [];
$ar4 = [];
$ar5 = [];
$ar6 = [];

    while ($r = $re->fetch()){
        if($r['liebe'] != 0 AND !in_array($r['Id_p'], $ar1)){
            array_push($ar1, $r['Id_p']);
            if($r['readingSteiner'] == 0){
                $not = ' notf';
            }else{
                $not = '';
            }
            $re1 = $bdd->prepare('SELECT Id_macher, liebe FROM notification WHERE Id = :Id AND Id_p = :Id_p AND liebe = :liebe ORDER BY idn DESC');
            $re1->execute(array(
                'Id'=> $_SESSION['id'],
                'Id_p' => $r['Id_p'],
                'liebe' => 1));
            $i=0;
            $j=0;
            $ray = [];
            while ($r1 = $re1->fetch()){
                if($i < 7 && !in_array($r1['Id_macher'], $ray)){
                    array_push($ray, $r1['Id_macher']);
                    $da = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE Id = :Id');
                    $da->execute(array(
                        'Id'=> $r1['Id_macher']));
                    $dat = $da->fetch();
                    if($i==0){
                        $a = "";
                        $p = $dat['pseudo'];
                    }else if($i==1){
                        $p = $p . " and ". $dat['pseudo']; 
                    }
                    $a = $a . "<div class='sehrKlein' style='background-image: url(profilesimages/mini/".$dat['avatarimageurl'].")'><a href='profile.php?pseudo=".$dat['pseudo']."'></a></div>";
                    $j++;
                }
                $i++;
            }
            if($j > 2){
               $p = $p .  " and " . ($i-2) . " other";
            }
            
            $req1889 = $bdd->prepare('SELECT Ori_partageur, partageur FROM all_shares WHERE Ori_Id = :Ori_Id AND partageur = :partageur');
            $req1889->execute(array(
                'Ori_Id'=> $r['Id_p'],
                'partageur' => $_SESSION['id']));
            $resultat = $req1889->fetch();
            if($resultat['Ori_partageur'] != $resultat['partageur']){
                $retweet = " Liked your retweet";
            }else{
                $retweet = " Liked your post";
            }

            $rome = $bdd->prepare('SELECT text_p FROM postes WHERE unique_id = :unique_id');
            $rome->execute(array(
                'unique_id'=> $r['Id_p']));
            $roma = $rome->fetch();
            if($roma){
                $text = $roma['text_p'];
            }else{
               $text = "";
            }
            $url = implode('',array_slice(explode('/', $_SERVER['HTTP_REFERER']),1,2)); 
            $data = "<div class='longN".$not."'><div class='longN_child'><div class='notifiers'><div class='notAvatar'>".$a."</div></div><div class='directing'><a href='post.php?post_id=".$r['Id_p']."'><div class='notName'>".$p.$retweet."</br>".$text."</div><div class='notName'>".$url."/post.php?post_id=".$r['Id_p']."</div></a></div></div></div>";
            echo $data;
        }



        else if($r['Id_k'] != 0 AND !in_array($r['Id_p'], $ar2)){
            array_push($ar2, $r['Id_p']);
            if($r['readingSteiner'] == 0){
                $not = ' notf';
            }else{
                $not = '';
            }
            $re1 = $bdd->prepare('SELECT Id_macher, Id_k FROM notification WHERE Id = :Id AND Id_p = :Id_p AND Id_k != :Id_k ORDER BY idn DESC');
            $re1->execute(array(
                'Id'=> $_SESSION['id'],
                'Id_p' => $r['Id_p'],
                'Id_k' => 0));
            $i=0;
            $j=0;
            $ray = [];
            while ($r1 = $re1->fetch()){
                if($i < 7 && !in_array($r1['Id_macher'], $ray)){
                    array_push($ray, $r1['Id_macher']);
                    $da = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE Id = :Id');
                    $da->execute(array(
                        'Id'=> $r1['Id_macher']));
                    $dat = $da->fetch();
                    if($i==0){
                        $a = "";
                        $p = $dat['pseudo'];
                    }else if($i==1){
                        $p = $p . " and ". $dat['pseudo']; 
                    }
                    $a = $a . "<div class='sehrKlein' style='background-image: url(profilesimages/mini/".$dat['avatarimageurl'].")'><a href='profile.php?pseudo=".$dat['pseudo']."'></a></div>";
                    $j++;
                }
                $i++;
            }
            if($j > 2){
               $p = $p .  " and " . ($i-2) . " other";
            }
            
            $req1889 = $bdd->prepare('SELECT Ori_partageur, partageur FROM all_shares WHERE Ori_Id = :Ori_Id AND partageur = :partageur');
            $req1889->execute(array(
                'Ori_Id'=> $r['Id_p'],
                'partageur' => $_SESSION['id']));
            $resultat = $req1889->fetch();
            if($resultat['Ori_partageur'] != $resultat['partageur']){
                $retweet = " Commented your retweet";
            }else{
                $retweet = " Commented your post";
            }

            $rome = $bdd->prepare('SELECT com FROM comment WHERE id_c = :id_c');
            $rome->execute(array(
                'id_c'=> $r['Id_k']));
            $roma = $rome->fetch();
            if($roma){
                $text = $roma['com'];
            }else{
               $text = "";
            } 
            $url = implode('',array_slice(explode('/', $_SERVER['HTTP_REFERER']),1,2));
            $data = "<div class='longN".$not."'><div class='longN_child'><div class='notifiers'><div class='notAvatar'>".$a."</div></div><div class='directing'><a href='post.php?post_id=".$r['Id_p']."#k,".$r['Id_k']."'><div class='notName'>".$p.$retweet."</br>".$text."</div><div class='notName'>".$url."/post.php?post_id=".$r['Id_p']."</div></a></div></div></div>";
            echo $data;
        }



        else if($r['Id_kkl'] != '0' AND !in_array($r['Id_kkl'], $ar3)){
            array_push($ar3, $r['Id_kkl']);
            if($r['readingSteiner'] == 0){
                $not = ' notf';
            }else{
                $not = '';
            }
            $re1 = $bdd->prepare('SELECT Id_macher, Id_kkl FROM notification WHERE Id = :Id AND Id_kkl = :Id_kkl ORDER BY idn DESC');
            $re1->execute(array(
                'Id'=> $_SESSION['id'],
                'Id_kkl' => $r['Id_kkl']));
            $i=0;
            $j=0;
            $ray = [];
            while ($r1 = $re1->fetch()){
                if($i < 7 && !in_array($r1['Id_macher'], $ray)){
                    array_push($ray, $r1['Id_macher']);
                    $da = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE Id = :Id');
                    $da->execute(array(
                        'Id'=> $r1['Id_macher']));
                    $dat = $da->fetch();
                    if($i==0){
                        $a = "";
                        $p = $dat['pseudo'];
                    }else if($i==1){
                        $p = $p . " and ". $dat['pseudo']; 
                    }
                    $a = $a . "<div class='sehrKlein' style='background-image: url(profilesimages/mini/".$dat['avatarimageurl'].")'><a href='profile.php?pseudo=".$dat['pseudo']."'></a></div>";
                    $j++;
                }
                $i++;
            }
            if($j > 2){
               $p = $p .  " and " . ($i-2) . " other";
            }
            
            
            $retweet = " Liked your comment";
            $tr = explode(",", $r['Id_kkl']);
            if(intval($tr[1])==0){
                $rome = $bdd->prepare('SELECT com FROM comment WHERE id_c = :id_c AND denke = :denke');
                $rome->execute(array(
                    'id_c'=> intval($tr[0]),
                    'denke' => $_SESSION['id']));
                $roma = $rome->fetch();
                if($roma){
                    $text = $roma['com'];
                }else{
                    $text = "";
                } 
            }else{
                $rome = $bdd->prepare('SELECT comment FROM kommentar WHERE id_k = :id_k AND master = :master ORDER By id_k DESC LIMIT 1');
                $rome->execute(array(
                    'id_k'=> intval($tr[0]),
                    'master' => $_SESSION['id']));
                $roma = $rome->fetch();
                if($roma){
                    $text = $roma['comment'];
                }else{
                    $text = "";
                } 
            }
            $url = implode('',array_slice(explode('/', $_SERVER['HTTP_REFERER']),1,2));
            $data = "<div class='longN".$not."'><div class='longN_child'><div class='notifiers'><div class='notAvatar'>".$a."</div></div><div class='directing vers_le_commantaire' id='vk,".$tr[0].",".$r['Id_p'].",".$_SESSION['id'].",".$tr[1]."'><div class='notName'>".$p.$retweet."</br>".$text."</div><div class='notName'>".$url."/post.php?post_id=".$r['Id_p']."</div></div></div></div>";
            echo $data;
        }



        else if($r['Id_kkc'] != '0' AND !in_array($r['Id_kkc'], $ar4)){
            array_push($ar4, $r['Id_kkc']);
            if($r['readingSteiner'] == 0){
                $not = ' notf';
            }else{
                $not = '';
            }
            $re1 = $bdd->prepare('SELECT Id_macher, Id_kkc FROM notification WHERE Id = :Id AND Id_kkc = :Id_kkc ORDER BY idn DESC');
            $re1->execute(array(
                'Id'=> $_SESSION['id'],
                'Id_kkc' => $r['Id_kkc']));
            $i=0;
            $j=0;
            $ray = [];
            while ($r1 = $re1->fetch()){
                if($i < 7 && !in_array($r1['Id_macher'], $ray)){
                    array_push($ray, $r1['Id_macher']);
                    $da = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE Id = :Id');
                    $da->execute(array(
                        'Id'=> $r1['Id_macher']));
                    $dat = $da->fetch();
                    if($i==0){
                        $a = "";
                        $p = $dat['pseudo'];
                    }else if($i==1){
                        $p = $p . " and ". $dat['pseudo']; 
                    }
                    $a = $a . "<div class='sehrKlein' style='background-image: url(profilesimages/mini/".$dat['avatarimageurl'].")'><a href='profile.php?pseudo=".$dat['pseudo']."'></a></div>";
                    $j++;
                }
                $i++;
            }
            if($j > 2){
               $p = $p .  " and " . ($i-2) . " other";
            }
            
            
            $retweet = " Commented your comment";
            $tr = explode(",", $r['Id_kkc']);
            if(intval($tr[1])==0){
                $rome = $bdd->prepare('SELECT com FROM comment WHERE id_c = :id_c AND denke = :denke ORDER By id_c DESC LIMIT 1');
                $rome->execute(array(
                    'id_c'=> intval($tr[0]),
                    'denke' => $_SESSION['id']));
                $roma = $rome->fetch();
                if($roma){
                    $text = $roma['com'];
                }else{
                    $text = "";
                } 
            }else{
                $rome = $bdd->prepare('SELECT comment FROM kommentar WHERE id_k = :id_k AND master = :master ORDER By id_k DESC LIMIT 1');
                $rome->execute(array(
                    'id_k'=> intval($tr[0]),
                    'master' => $_SESSION['id']));
                $roma = $rome->fetch();
                if($roma){
                    $text = $roma['comment'];
                }else{
                    $text = "";
                } 
            }

            $url = implode('',array_slice(explode('/', $_SERVER['HTTP_REFERER']),1,2));
            $data = "<div class='longN".$not."'><div class='longN_child'><div class='notifiers'><div class='notAvatar'>".$a."</div></div><div class='directing vers_le_commantaire' id='vk,".$tr[0].",".$r['Id_p'].",".$_SESSION['id'].",".$tr[1]."'><div class='notName'>".$p.$retweet."</br>".$text."</div><div class='notName'>".$url."/post.php?post_id=".$r['Id_p']."</div></div></div></div>";
            echo $data;
        }





        else if($r['shared'] != 0 AND !in_array($r['Id_p'], $ar5)){
            array_push($ar5, $r['Id_p']);
            if($r['readingSteiner'] == 0){
                $not = ' notf';
            }else{
                $not = '';
            }
            $re1 = $bdd->prepare('SELECT Id_macher, shared FROM notification WHERE Id = :Id AND Id_p = :Id_p AND shared = :shared ORDER BY idn DESC');
            $re1->execute(array(
                'Id'=> $_SESSION['id'],
                'Id_p' => $r['Id_p'],
                'shared' => 1));
            $i=0;
            $j=0;
            $ray = [];
            while ($r1 = $re1->fetch()){
                if($i < 7 && !in_array($r1['Id_macher'], $ray)){
                    array_push($ray, $r1['Id_macher']);
                    $da = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE Id = :Id');
                    $da->execute(array(
                        'Id'=> $r1['Id_macher']));
                    $dat = $da->fetch();
                    if($i==0){
                        $a = "";
                        $p = $dat['pseudo'];
                    }else if($i==1){
                        $p = $p . " and ". $dat['pseudo']; 
                    }
                    $a = $a . "<div class='sehrKlein' style='background-image: url(profilesimages/mini/".$dat['avatarimageurl'].")'><a href='profile.php?pseudo=".$dat['pseudo']."'></a></div>";
                    $j++;
                }
                $i++;
            }
            if($j > 2){
               $p = $p .  " and " . ($i-2) . " other";
            }
            
            
            $retweet = " Shared your post";

            $rome = $bdd->prepare('SELECT text_p FROM postes WHERE unique_id = :unique_id');
            $rome->execute(array(
                'unique_id'=> $r['Id_p']));
            $roma = $rome->fetch();
            if($roma){
                $text = $roma['text_p'];
            }else{
               $text = "";
            } 
            $url = implode('',array_slice(explode('/', $_SERVER['HTTP_REFERER']),1,2));
            $data = "<div class='longN".$not."'><div class='longN_child'><div class='notifiers'><div class='notAvatar'>".$a."</div></div><div class='directing'><a href='post.php?post_id=".$r['Id_p']."'><div class='notName'>".$p.$retweet."</br>".$text."</div><div class='notName'>".$url."/post.php?post_id=".$r['Id_p']."</div></a></div></div></div>";
            echo $data;
        }




        else if($r['friend'] != 0 AND !in_array(1, $ar6)){
            array_push($ar6, 1);
            if($r['readingSteiner'] == 0){
                $not = ' notf';
            }else{
                $not = '';
            }
            $re1 = $bdd->prepare('SELECT Id_macher, friend FROM notification WHERE Id = :Id AND friend = :friend ORDER BY idn DESC');
            $re1->execute(array(
                'Id'=> $_SESSION['id'],
                'friend' => 1));
            $i=0;
            $j=0;
            $ray = [];
            while ($r1 = $re1->fetch()){
                if($i < 7 && !in_array($r1['Id_macher'], $ray)){
                    array_push($ray, $r1['Id_macher']);
                    $da = $bdd->prepare('SELECT pseudo, avatarimageurl FROM members WHERE Id = :Id');
                    $da->execute(array(
                        'Id'=> $r1['Id_macher']));
                    $dat = $da->fetch();
                    if($i==0){
                        $a = "";
                        $p = 'You and ' . $dat['pseudo'];
                    }else if($i==1){
                        $p = $p . " and ". $dat['pseudo']; 
                    }
                    $a = $a . "<div class='sehrKlein' style='background-image: url(profilesimages/mini/".$dat['avatarimageurl'].")'><a href='profile.php?pseudo=".$dat['pseudo']."'></a></div>";
                    $j++;
                }
                $i++;
            }
            if($j > 2){
               $p = $p .  " and " . ($i-2) . " other";
            }
            
            
            $retweet = " Are Friends Now";

            $text = "";
            $url = implode('',array_slice(explode('/', $_SERVER['HTTP_REFERER']),1,2));
            $data = "<div class='longN".$not."'><div class='longN_child'><div class='notifiers'><div class='notAvatar'>".$a."</div></div><div class='directing'><a href='".$_SESSION['pseudo']."/friends'><div class='notName'>".$p.$retweet."</br>".$text."</div><div class='notName'>".$url."/".$_SESSION['pseudo']."/friends</div></a></div></div></div>";
            echo $data;
        }
    }
}

























if (isset($_POST['notificationExisting'])) {
$reqd = $bdd->prepare('SELECT idn FROM notification WHERE Id = :Id AND readingSteiner = :readingSteiner');
$reqd->execute(array(
    'Id'=> $_SESSION['id'],
    'readingSteiner' => 0));
$i = 0;
while ($resultat = $reqd->fetch()) {
    $i++;
}
if($i == 0){
    $req = $bdd->prepare('SELECT iduser1 FROM amis WHERE status = :status AND ((user1_to_user2 = :user1_to_user2 AND iduser2 = :iduser2) OR (user2_to_user1 = :user2_to_user1 AND iduser1 = :iduser1))');
    $req->execute(array(
        'status' => 0,
        'user1_to_user2' => 1,
        'iduser2' => $_SESSION['id'],
        'user2_to_user1' => 1,
        'iduser1' => $_SESSION['id']));
    while ($resultat = $req->fetch()) {
        $i++;
    }
}
echo $i;
}

if (isset($_POST['notificationEa'])) {
$reqd = $bdd->prepare('UPDATE notification SET readingSteiner = :readingSteiner WHERE Id = :Id');
$reqd->execute(array(
    'readingSteiner'=> 1,
    'Id' => $_SESSION['id']));
}



?>