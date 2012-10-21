<?php
include ('functions.php');
session_start();
if(!isset($_SESSION['account'])) {
	header("Location: index.php"); }
else {
$school = explode('!',$_SESSION['school']);
$account = $_SESSION['account'];
$data = "show account " . $account;
$m59 = m59serv_opencon();
$results = m59serv_senddata($m59,$data);
$char = preg_split("/[\s,]+/",$results[4]);
$charz = "";
for ($i = 4; $i <= count($char)-1; $i++) { $charz .= $char[$i] . ' '; }
$objectnum = $char[2];
$result = m59serv_senddata($m59,'send object '.$objectnum.' RemoveAllSpells');
$result = m59serv_senddata($m59,'send object '.$objectnum.' RemoveAllSkills');
$result = m59serv_senddata($m59,'send object '.$objectnum.' AddDefaultSpells');
//$data = 'send object '. $objectnum . ' getintellect';
for($i=0;$i<=(count($school)-2);$i++) {
	$temp = explode(":",$school[$i]);
	switch ($temp[0]) {
		case 0:
			$result = m59serv_senddata($m59,'send object '.$objectnum.' GivePlayerAllSkills level int '.$temp[1].' iability int 99');
			break;
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
			$result = m59serv_senddata($m59,'send object '.$objectnum.' GivePlayerAllSpells school int '.$temp[0].' level int '.$temp[1].' iability int 99');
			break;
	}
}
unset($_SESSION['account']);
$query_set_built = 'UPDATE m59_Web SET Built="1" WHERE(Username ="'.$account.'")LIMIT 1';
$result_pw = mysqli_query($dbcon, $query_set_built);
echo 'Your character has been built!';
m59serv_closecon($m59);
}
?>