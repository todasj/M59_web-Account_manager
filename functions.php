<?php
$db_host = 'hostname'; //Hostname/IP of database
$db_name = 'database'; //Database name
$db_username = 'username'; //Database username
$db_password = 'password'; //Database password
$dbcon = mysqli_connect($db_host,$db_username,$db_password,$db_name);

function is_valid_email($email) {
	if (strlen($email) > 80)
		return false;
	return preg_match('%^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|("[^"]+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\])|(([a-zA-Z\d\-]+\.)+[a-zA-Z]{2,}))$%', $email); }
	
function m59serv_opencon() {
	$m59_server = 'server_ip'; //IP to Meridian 59 server
	$m59_port = 'server_maintance_port'; //Maintance port to Meridian 59 server
	$fp = fsockopen($m59_server, $m59_port);
	return $fp;}
	
function m59serv_closecon($fp) {
	fclose($fp);  }
	
function m59serv_senddata($fp,$data) {
	fwrite($fp,$data . "\r"); 
	stream_set_timeout($fp, 2); 
	$results = array(); 
	$status = socket_get_status($fp); 
	while (!feof($fp) && !$status['timed_out']) { 
		$results[] = fgets($fp); 
		$status = socket_get_status($fp); }
	return $results; }
	
function generate_level_form() {
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
for($i=0;$i<=6;$i++){
echo '<h4>';
switch ($i) {
	case 0:
		echo 'Weaponcraft';
		break;
	case 1:
		echo 'Shalille';
		break;
	case 2:
		echo 'Qor';
		break;
	case 3:
		echo 'Kraanan';
		break;
	case 4:
		echo 'Faren';
		break;
	case 5:
		echo 'Riija';
		break;
	case 6:
		echo 'Jala';
		break;
}
echo '</h4>';
echo '<select name="'.$i.'">';
echo '<option value="0" selected="selected">0</option>';
echo '<option value="1">1</option>';
echo '<option value="2">2</option>';
echo '<option value="3">3</option>';
echo '<option value="4">4</option>';
echo '<option value="5">5</option>';
echo '<option value="6">6</option>';
echo '</select>';
}
echo '<INPUT type="submit" name="submit" value="Send"> <INPUT type="reset">';
echo '</form>';
}
?>