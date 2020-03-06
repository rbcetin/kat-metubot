<?php
set_time_limit(0);
header('Content-Type: text/plain;charset=UTF-8');

if(isset($_GET['156rBcEtiN213'])) {
define('IN_MY_PROJECT', true);
date_default_timezone_set("Asia/Baghdad");
error_reporting(E_ERROR | E_PARSE);


function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function includeWithVariables($filePath, $variables = array(), $print = true)
{
    $output = NULL;
    if(file_exists($filePath)){
        // Extract the variables to a local namespace
        extract($variables);

        // Start output buffering
        ob_start();

        // Include the template file
        include $filePath;

        // End buffering and return its contents
        $output = ob_get_clean();
    }
    return $output;
}

function get_last_words($amount, $string){
	$amount+=1;
	$string_array = explode(' ', $string);
	$totalwords= str_word_count($string, 1, 'àáãç3');
	if($totalwords > $amount){
		$words= implode(' ',array_slice($string_array, count($string_array) - $amount));
	} else { 
		$words = implode(' ',array_slice($string_array, count($string_array) - $totalwords));
	}
	$words = str_replace(' ', '', $words); return $words;
	}

function k1s4lt($linkim){
	require 'config.php';

	$url = isset($linkim) ? urldecode(trim($linkim)) : '';
	$db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
	$db->set_charset('utf8mb4');
	$url = $db->real_escape_string($url);
	$result = $db->query('SELECT slug FROM redirect WHERE url = "' . $url . '" LIMIT 1');
	if ($result && $result->num_rows > 0) { // If there’s already a short URL for this URL
		$linkim = "https://bot.metu.fun/?s=" . $result->fetch_object()->slug;
	} else {
		$result = $db->query('SELECT slug, url FROM redirect ORDER BY date DESC, slug DESC LIMIT 1');
		if ($result && $result->num_rows > 0) {
			$slug = generateRandomString();
			if ($db->query('INSERT INTO redirect (slug, url, date, hits) VALUES ("' . $slug . '", "' . $url . '", NOW(), 0)')) {
				header('HTTP/1.1 201 Created');
				$db->query('OPTIMIZE TABLE `redirect`');
				$linkim = "https://bot.metu.fun/?s=" . $slug;
			}
		}
	}
	return $linkim;
}
	
function kayitla($realname, $dersad, $notadi, $not){
	require 'config.php';

	$db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
	$db->set_charset('utf8mb4');
	$db->query("INSERT INTO notlar (name,ders,notadi,grade) VALUES ('$realname', '$dersad', '$notadi', '$not')");

}

function sendFB($notadi,$not,$dersad,$linkim,$averaj,$telegramid,$realname){
	$kisalink = k1s4lt($linkim);
	$message = urlencode("[$dersad] $notadi\nGrade: $not - Avg: $averaj\n$kisalink");
	$chat = "$telegramid";
	$botapi = "XXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
	$link = "https://api.telegram.org/bot$botapi/sendMessage?text=$message&chat_id=$chat";
	$ch = curl_init($link);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	kayitla($realname, $dersad, $notadi, $not);
	}
	
function bakbaba($eklenen,$notlar,$telegramid,$title,$realname){
		$eklenen = preg_quote($eklenen); // Escaping bad characters such as Marketing (%10)
		
		if (strpos($eklenen, " or ") === false) { // TEK NOT ACIKLANDI
			$myid = array_keys(preg_grep("/^$eklenen$/", array_column($notlar, 'column-name')));
			if (!empty($myid)) {
				sendFB($notlar[$myid[0]+1]["column-name"],$notlar[$myid[0]+1]["column-grade"],$title,$notlar[$myid[0]+1]["column-link"],$notlar[$myid[0]+1]["column-average"],$telegramid,$realname);
			} else {
				sendFB(stripslashes($eklenen),"??",$title,$notlar[1]["column-link"],"?? - Check manually.",$telegramid,$realname);	
			}
		} else {  // BIRDDEN FAZLA NOT ACIKLANDI  
			$eklenen = explode(" or ", $eklenen);
			foreach($eklenen as $ek) {
				$myid = array_keys(preg_grep("/^$ek$/", array_column($notlar, 'column-name')));
				if (!empty($myid)) {
					sendFB($notlar[$myid[0]+1]["column-name"],$notlar[$myid[0]+1]["column-grade"],$title,$notlar[$myid[0]+1]["column-link"],$notlar[$myid[0]+1]["column-average"],$telegramid,$realname);
				} else {
					sendFB(stripslashes($ek),"??",$title,$notlar[1]["column-link"],"?? - Check manually.",$telegramid,$realname);	
				}
			}
		}
		
		
}

	
function between($string, $start, $end){
    $out    = explode($start, $string); 
	if(isset($out[1]))    {
		$string = explode($end, $out[1]);
		return $string[0];
		}
	return '';
	}
	
function yeni($birinci,$ikinci) {
	$red = implode(',', $birinci);
	$red2 = implode(',', $ikinci);
	$dilim1 = explode(",", $red);
	$dilim2 = explode(",", $red2);
	$dilimk = array_diff($dilim2,$dilim1);
	return implode(' or ', $dilimk);
	}
	
function get_words($sentence, $count = 2) {
	preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
	return substr($matches[0], 0, -1);
	}


$userdata = array (

array("username"=>"e123456","password"=>"78910","userid"=>11111,"telid"=>111111,"realname"=>"mehmet ali erbil","dersid"=>array(663,2168))

);
  
  
foreach($userdata as $k=>$v){
	$dersid = end($v);
	 array_unshift($dersid, $userdata[$k]["userid"]);
	 $array[] = $dersid;
}

$result = array_unique(array_merge(...$array));
foreach($result as $value){
	for($i=0;$i<count($array);$i++) 
	{
		if (in_array($value, $array[$i]) and $value != $array[$i][0] ) {
			$key = array_search($array[$i][0], array_column($userdata, 'userid'));
			$arrx[] =  array( "username"=>$userdata[$key]["username"],
							  "password"=>$userdata[$key]["password"],
							  "realname"=>$userdata[$key]["realname"],
							  "userid"=>$userdata[$key]["userid"],
							  "telid"=>$userdata[$key]["telid"],
							  "ders"=>$value);
			break;
			}
	} 
}



echo "Started checking.";
foreach($arrx as $user){
	$string = includeWithVariables('metuclass.php', array('aciklandi' => 0,
														  'username' => $user["username"],
														  'realname' => $user["realname"],
														  'password' => $user["password"],
														  'useridimiz' => $user["userid"],
													      'telegramid' => $user["telid"],
														  'dersid' => $user["ders"]));
	echo "\n".$string." - ".$user["ders"];
	
	if($string != "0") {
		for($i=0;$i<count($userdata);$i++)	{
			if (in_array($user["ders"], $userdata[$i]["dersid"]) and $userdata[$i]["username"] != $user["username"]) {		
				$sg = includeWithVariables('metuclass.php', array('aciklananlar' => $string,
																 'aciklandi' => 1,
																 'username' => $userdata[$i]["username"],
																 'realname' => $userdata[$i]["realname"],
																 'password' => $userdata[$i]["password"],
																 'useridimiz' => $userdata[$i]["userid"],
																 'telegramid' => $userdata[$i]["telid"],
																 'dersid' => $user["ders"]));
				echo ", $sg";
			}
		} 
	}
	
}

foreach(glob('cookie/*.txt') as $v){ unlink($v);}

} else {
    die("Nothing to see here, move along.");
}
?>
