<?php
include ('functions.php');
$error = array();
if(empty($_POST['username'])) {
	$error[] = 'Please enter a username.'; }
else {
	$user = strtolower(addslashes($_POST['username'])); }
if(empty($_POST['email'])) {
	$error[] = 'Please enter a e-mail.'; }
else {
	if(is_valid_email($_POST['email'])) {
		$email = $_POST['email']; }
	else {
		$error[] = 'Invalid e-mail.'; }
}
if(empty($_POST['password'])) {
	$error[] = 'Please enter a password.'; }
	else {
		$pw = $_POST['password']; }
		
 if (empty($error)) {
	$query = 'SELECT * FROM m59_Web WHERE Username = "'.$user.'"';
	$check_username = mysqli_query($dbcon,$query);
	if (mysqli_num_rows($check_username) == 0) {
		$activation = md5(uniqid(rand(), true));
		$query_insert = 'INSERT INTO m59_Web (`Email`, `Username`, `Password`, `IP`, `Built`, `Activation`) VALUES ("'.$email.'","'.$user.'","'.$pw.'","'.$_SERVER["REMOTE_ADDR"].'","0","'.$activation.'")';
		$results = mysqli_query($dbcon,$query_insert);
		if (mysqli_affected_rows($dbcon) == 1) {
			$message = 'To activate your account, click on this link: ';
			$message .= 'http://pvp.meridian59.org/activate.php?username='. $user . '&key='. $activation;
			mail($email, 'Confirm e-mail', $message, 'From:info@meridian59.org');
			echo 'An e-mail has been sent to ' . $email . ', click on the link in the e-mail to activate your account. If you do not see the e-mail in your inbox within a few minutes, please check your spam folder.'; } }
	else { echo 'Username already exists, please choose another one.'; } }
	 
else {
	echo '<ol><span style="color:#FF0000">';
	foreach ($error as $key => $values) {
		echo '<li>' . $values . '</li>'; }
	echo '</span></ol>'; }
mysqli_close($dbcon);
?> 
