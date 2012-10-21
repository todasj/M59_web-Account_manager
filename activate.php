<?php
include ('functions.php');

if (isset($_GET['username'])) {
	$user = strtolower(addslashes($_GET['username'])); }
if (isset($_GET['key']) && (strlen($_GET['key']) == 32)) {
	$key = addslashes($_GET['key']); }
if (isset($user) && isset($key)) {
	$query_pw = 'SELECT Password from m59_Web WHERE Username = "'. $user . '"';
	$result_pw = mysqli_query($dbcon, $query_pw);
	$result_pw_array = mysqli_fetch_row($result_pw);
	$pw = $result_pw_array['0'];
	$query_activate = 'UPDATE m59_Web SET Activation=NULL, Password="' . md5($pw) . '" WHERE(Username ="'.$user.'" AND Activation="'.$key.'")LIMIT 1';
	$result_activate = mysqli_query($dbcon, $query_activate);
	if (mysqli_affected_rows($dbcon) == 1) {
		echo '<h2><a href="index.php">Your account is now active.</a></h2>';
		$data = 'create automated ' . $user . ' ' . $pw; 
		$m59 = m59serv_opencon(); 
		m59serv_senddata($m59,$data);
		m59serv_closecon($m59); 
		echo '<br />Your in-game account has been created, you can now logon and create your new character!'; }
	else {
	echo '<h2>There was an error trying to activate your account, please check the link again or contact an admin.</h2>'; }
}
else {echo 'Error occured, please try again.'; }
	mysqli_close($dbcon);
?>