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



if(isset($_POST['n'])){

	$number = htmlspecialchars($_POST['n']);
	$i=0;
	$k=0;
    $t=0;
    $f=0;
    $arr=[];
$friends=[];
$passed=[];


     $req188 = $bdd->prepare('SELECT iduser2, iduser1 FROM amis WHERE (iduser2 = :iduser22 OR iduser1 = :iduser12) AND status = :status');
$req188->execute(array(
    'iduser22' => $_SESSION['id'],
    'iduser12' => $_SESSION['id'],
    'status' => 1));
while ($resultatf = $req188->fetch()) {
    if ($resultatf['iduser2']==$_SESSION['id']) {
        array_push($friends, $resultatf['iduser1']);
    }else{
        array_push($friends, $resultatf['iduser2']);
    }
}
array_push($friends, $_SESSION['id']);
$array= "\"" . implode("\",\"", array_map('intval', $friends)) . "\"";


foreach($bdd->query('SELECT Ori_Id, Ori_partageur, s_time, partageur, share_Id FROM all_shares WHERE partageur IN ('.$array.') ORDER BY share_Id DESC') as $resultat){

$counter=0;
array_push($passed, $resultat['Ori_Id']);
$p_size = sizeof($passed);
for($jk=0; $jk < $p_size; $jk++){
if($passed[$jk] == $resultat['Ori_Id']){
    $counter++;
}
}

    if($t==$number AND $counter <= 1){

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
    $video_img = "<video width='100%' style='background-color: #350707; display= block;' class='po_video_img' src='postes/".$rem2['video']."'></video>";
}else{
    $video_img = "";
}

$mu = -1;
$sha = 'sha';
$reu = $bdd->prepare('SELECT partageur, Ori_Id, share_Id, Ori_partageur FROM all_shares WHERE Ori_Id = :Ori_Id');
$reu->execute(array(
    'Ori_Id'=> $resultat['Ori_Id']));
while ($neu = $reu->fetch()) {
$mu++;
if($neu['partageur']==$_SESSION['id'] AND $neu['share_Id']!=$neu['Ori_Id']){
$sha = 'sha shaed';
    }else if($neu['share_Id']!=$neu['Ori_Id']){
        array_push($arr, $neu['partageur']);
    }
}


if($sha == 'sha shaed'){
    $retweet = "<div class='retw'>You retweeted</div>";
}else if(in_array($resultat['Ori_partageur'], $friends) AND in_array($resultat['Ori_partageur'], $arr)){
    $retweet = "<div class='retw'>". $remo['pseudo'] ." retweeted</div>";
}else{
    $values = array_intersect($arr, $friends);
    $size = sizeof($values);
    if($size==0){
        $retweet = "";
    }else if($size==1){
$reno = $bdd->prepare('SELECT pseudo FROM members WHERE id = :id');
$reno->execute(array(
    'id'=> $values[0]));
$redo = $reno->fetch();
$retweet = "<div class='retw'>" . $redo['pseudo'] . " retweeted</div>";
    }else if($size == 2){
        $reno = $bdd->prepare('SELECT pseudo FROM members WHERE id = :id || id = :id2');
$reno->execute(array(
    'id'=> $values[0],
    'id2'=> $values[1]));
$p=[];
while($redo = $reno->fetch()){
    array_push($p, $redo['pseudo']); 
    }
    $retweet = "<div class='retw'>" . $p[0]. " and " . $p[1] . " have retweeted</div>";
}else{

        $reno = $bdd->prepare('SELECT pseudo FROM members WHERE id = :id || id = :id2');
$reno->execute(array(
    'id'=> $values[0],
    'id2'=> $values[1]));
$p=[];
while($redo = $reno->fetch()){
    array_push($p, $redo['pseudo']); 
    }
    if($size==3){$other = ' other';}else{$other= ' others';}
    $retweet = "<div class='retw'>" . $p[0]. ", " . $p[1] . " and " . ($size-2) . $other .  " have retweeted</div>";
}

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

if (isset($_POST['fn'])) {
    $fn=0;
    $req188 = $bdd->prepare('SELECT idu FROM amis WHERE (iduser2 = :iduser22 OR iduser1 = :iduser12) AND status = :status');
$req188->execute(array(
    'iduser22' => $_SESSION['id'],
    'iduser12' => $_SESSION['id'],
    'status' => 1));
while ($resultatf = $req188->fetch()) {
    $fn++;
}
$reqn = $bdd->prepare('SELECT shares FROM members WHERE id = :id');
$reqn->execute(array(
    'id' => $_SESSION['id']));
$re = $reqn->fetch();
$arr= [];
array_push($arr, $fn, $re['shares']);
echo json_encode($arr);
}

?>