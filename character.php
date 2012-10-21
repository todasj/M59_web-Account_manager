<?php
include ('functions.php');
session_start();
if(!isset($_SESSION['account'])) {
	header("Location: index.php"); }
if(isset($_POST['submit'])) {
$levels_choosen = '';
$_SESSION['school'] = '';
for($i=0;$i<=6;$i++) {
	if(strlen($_POST[$i]) == 1 && $_POST[$i] <> 0 && is_numeric($_POST[$i])) {
		$levels_choosen += ($_POST[$i]-1);
		$_SESSION['school'] .= $i . ':' . $_POST[$i] . '!';
	}
}
if($levels_choosen > $_SESSION['levels']) {
	echo '<h2>'.$_SESSION['character'].'</h2>';
	echo '<h3><span style="color:#FF0000">You have choosen to many levelpoints. '.$levels_choosen.' levels out of '.$_SESSION['levels'] . '</spam></h3>';
	echo 'Example how it works. If you want kraanan level 6 that is 5 levelpoints, level 1 does not count as a level but all the levels above counts as one. So for example 12 levelpoints can do the combo 5/5/5.';
	generate_level_form(); }
elseif($levels_choosen < $_SESSION['levels']) {
	echo '<h2>'.$_SESSION['character'].'</h2>';
	if($levels_choosen == "") { $levels_choosen = '0'; }
	echo '<h3><span style="color:#FF0000">You have choosen to few levelpoints. '.$levels_choosen.' levels out of '.$_SESSION['levels'] . '</span></h3>';
	echo 'Example how it works. If you want kraanan level 6 that is 5 levelpoints, level 1 does not count as a level but all the levels above counts as one. So for example 12 levelpoints can do the combo 5/5/5.';
	generate_level_form();}
elseif ($level_choosen = $_SESSION['levels']) {
	echo '<form action="build.php" method="post">';
	echo '<input type="submit" name="submit" value="I want to build this character">';
	echo '</form>';
	$school = explode('!',$_SESSION['school']);
	for($i=0;$i<=(count($school)-2);$i++) {
	$temp = explode(":",$school[$i]);
	switch ($temp[0]) {
		case 0:
			echo 'Weaponcraft: ' . $temp[1] . '<br />';
			break;
		case 1:
			echo 'Shalille: ' . $temp[1] . '<br />';
			break;
		case 2:
			echo 'Qor: ' . $temp[1] . '<br />';
			break;
		case 3:
			echo 'Kraanan: ' . $temp[1] . '<br />';
			break;
		case 4:
			echo 'Faren: ' . $temp[1] . '<br />';
			break;
		case 5:
			echo 'Riija: ' . $temp[1] . '<br />';
			break;
		case 6:
			echo 'Jala: ' . $temp[1] . '<br />';
			break;
	}
	}
}
}
else { 
	echo '<h2>'.$_SESSION['character'].'</h2>';
	echo '<h3><span style="color:#FF0000">Levels available: '.$_SESSION['levels'].'</span></h3>';
	echo 'Example how it works. If you want kraanan level 6 that is 5 levelpoints, level 1 does not count as a level but all the levels above counts as one. So for example 12 levelpoints can do the combo 5/5/5.';
	generate_level_form();
}
?>