<?php
include ('functions.php');
session_start();
$error = array();

if(empty($_POST['username'])) {
	$error[] = 'Please enter a username.'; }
else {
	$user = strtolower(addslashes($_POST['username'])); }
if(empty($_POST['password'])) {
	$error[] = 'Please enter a password.'; }
else {
	$pw = md5($_POST['password']); }

if(empty($error)) {
	$query_login = 'SELECT * FROM m59_Web WHERE (Username="'.$user.'" AND Password="'.$pw.'" AND Built="0") AND Activation IS NULL';
//	$query_login = 'SELECT * FROM m59_Web WHERE (Username="'.$user.'" AND Password="'.$pw.'") AND Activation IS NULL';
	$result_login = mysqli_query($dbcon,$query_login);
	if(mysqli_num_rows($result_login) == 1) {
		$data = "show account " . $user;
		$m59 = m59serv_opencon();
		$results = m59serv_senddata($m59,$data);
		$char = preg_split("/[\s,]+/",$results[4]);
		$charz = "";
		for ($i = 4; $i <= count($char)-1; $i++) { $charz .= $char[$i] . ' '; }
		$objectnum = $char[2];
		$data = 'send object '. $objectnum . ' getrealintellect';
		$results = m59serv_senddata($m59,$data);
		$pieces = explode(" ",$results[2]);
		$intellect = $pieces[2];
		$intellect = trim($intellect);
		if($intellect < '4') { $_SESSION['levels'] = '8'; }
		elseif($intellect <= '9') { $_SESSION['levels'] = '9'; }
		elseif($intellect < '14') { $_SESSION['levels'] = '10'; }
		elseif($intellect < '19') { $_SESSION['levels'] = '11'; }
		elseif($intellect < '24') { $_SESSION['levels'] = '12'; }
		elseif($intellect < '29') { $_SESSION['levels'] = '13'; }
		elseif($intellect < '34') { $_SESSION['levels'] = '14'; }
		elseif($intellect < '39') { $_SESSION['levels'] = '15'; }
		elseif($intellect < '44') { $_SESSION['levels'] = '16'; }
		elseif($intellect < '49') { $_SESSION['levels'] = '17'; }
		else { $_SESSION['levels'] = '18'; }
		echo '<h3>Levels available: '.$_SESSION['levels'].'</h3>';
		m59serv_closecon($m59); 	
		$_SESSION['account'] = $user;
		$_SESSION['character'] = $charz;
		header("Location: character.php"); }
	else {
		echo 'Incorrect username and/or password or you have already built your character.'; } }

else {
	echo '<ol><span style="color:#FF0000">';
	foreach ($error as $key => $values) {
		echo '<li>' . $values . '</li>'; }
	echo '</span></ol>'; }
?>