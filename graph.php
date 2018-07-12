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
if (isset($_POST['user'])) {
	$reqa = $bdd->prepare('SELECT winid, winnerdate FROM wins WHERE gewinner = :gewinner AND winnerdate >= LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL 1 MONTH
  AND winnerdate < LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY');
    $reqa->execute(array(
        'gewinner' => $_POST['user'],
        ));
$sc =0;
$nd=0;
$i =1;
$arr=[];
while ($nd < 31) {
  array_push($arr, 0);
  $nd++;
}
while ($i <  32) {
  $op=1;
    while ($don = $reqa->fetch()) {

    list($year, $month, $day) = array_values(date_parse($don['winnerdate']));


if($i==$day){
  $op= $i-1;
  $arr[$op] = $arr[$op] + 1;
}


                                }
$reqa->closeCursor();
$reqa = $bdd->prepare('SELECT winid, winnerdate FROM wins WHERE gewinner = :gewinner AND winnerdate >= LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL 1 MONTH
  AND winnerdate < LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY');
    $reqa->execute(array(
        'gewinner' => $_POST['user'],
        ));
$i++;
}
echo json_encode($arr);
}




if (isset($_POST['userm'])) {
  $reqa = $bdd->prepare('SELECT winid, winnerdate FROM wins WHERE gewinner = :gewinner AND YEAR(winnerdate) = YEAR(CURRENT_DATE)');
    $reqa->execute(array(
        'gewinner' => $_POST['userm'],
        ));
$sc =0;
$nd=0;
$i =1;
$arr=[];
while ($nd < 12) {
  array_push($arr, 0);
  $nd++;
}
while ($i <  13) {
  $op=1;
    while ($don = $reqa->fetch()) {

    list($year, $month, $day) = array_values(date_parse($don['winnerdate']));


if($i==$month){
  $op= $i-1;
  $arr[$op] = $arr[$op] + 1;
}


                                }
$reqa->closeCursor();
$reqa = $bdd->prepare('SELECT winid, winnerdate FROM wins WHERE gewinner = :gewinner AND YEAR(winnerdate) = YEAR(CURRENT_DATE)');
    $reqa->execute(array(
        'gewinner' => $_POST['userm'],
        ));
$i++;
}
echo json_encode($arr);
}
?>


