<?php
defined('IN_MY_PROJECT') || die("Nothing to see here, move along.");
	$dosya       = getcwd()."/txt/$useridimiz-$dersid.txt";
    
	$url      = 'https://odtuclass.metu.edu.tr/login/index.php';	
	$url1             = "https://odtuclass.metu.edu.tr/course/user.php?mode=grade&id=$dersid&user=$useridimiz";
	$cookie_file_path = "cookie/". $dersid . "_" . time() . "_" . substr(md5(microtime()), 0, 5) . ".txt";
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

	$postinfo         = "username=$username&password=$password&rememberusername=1&anchor=&logintoken=$logintoken";
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


	if (!$html || strlen(trim($html)) == 0) { } elseif (preg_match("#Log in to the site#si" , $html)) { } elseif (preg_match("#Enrollment options#si" , $html)) { } else { 
		$xml = new DOMDocument();
		$xml->validateOnParse = true;
		$xml->loadHTML($html);
		$xpath = new DOMXPath($xml);

		preg_match_all("/<th.{1,}\[(.*?)\]/", $html, $pagetitle); // $pagetitle[1][0] returns IE 206 All Sections
		
		$table = $xpath->query("//tbody")->item(0); // TBODY ICINDEKI ILK TABLOYU CEK	
		$rows = $table->getElementsByTagName("tr");

		
		$notlar = array();
		$x = 0;
		foreach ($rows as $row) {
			$count = 1;	
			$kontrol = $row ->getElementsByTagName('th')->item(0);
			
			if($kontrol){ 
				if (strpos($kontrol->getAttribute('class'), 'baggt') !== false) { // Course total ise veya bos satir ise atla
					continue;
				}
			} else {
				continue; 
			} 
			
			$isim = $kontrol->nodeValue;
			$cells = $row -> getElementsByTagName('td');
			
			foreach ($cells as $cell) {
				$value = $cell->nodeValue;
				$class = get_last_words(1,$cell->getAttribute('class')); // Classin son kelimesini cek: column-grade, column-average
				if (strpos($class, 'column-leader') !== false or strpos($class, 'feedbacktextcolumn-feedback') !== false or strpos($class, 'column-contributiontocoursetotal') !== false or strpos($class, 'column-weight') !== false) {continue;}		
				$notlar[$x][$class] = $value;
				if($count==1) {
					$count++;
					$notlar[$x]["column-name"] = $isim;
					$notlar[$x]["column-link"] = $url1;
				}
			}
			
		$x++;
		}

		foreach ($notlar as $key => $item) {
			if(!is_numeric($item["column-grade"]))  { // Grade numerik degil ise arrayden cikar.
				unset($notlar[$key]);
			}
		}
			

		$notlar = array_values($notlar); // ARRAY SIRASI 1 3 8 14 DIYE GELIYOR ONU 0 1 2 3 YAP
		array_unshift($notlar,""); // Arrayi 0 yerine 1 den baslat
		unset($notlar[0]);
		
		if (!$aciklandi) { // ACIKLANDI 0 İSE İFE GİR
			$string_data= implode(',', array_column($notlar, 'column-name')); // VIRGUL ILE ACIKLANAN NOT ISIMLERINI AYIR
			if (file_exists($dosya)) {
				$lines = file($dosya);
				$fh = fopen($dosya, 'w') or die("can't open file");fwrite($fh, $string_data);fclose($fh);
				$lines2 = file($dosya);
			} else {
				$fh = fopen($dosya, 'a') or die("can't create file");fwrite($fh, $string_data);fclose($fh);
				$lines = file($dosya);
				$lines2 = file($dosya);
			}
		}
		
	}

	if (!$aciklandi) { // ACIKLANDI 0 İSE İFE GİR
		if ($lines != $lines2) { // YENI BIR SEYLER VAR.
			$eklenen = yeni($lines,$lines2); // YENI EKLENEN ITEMI BUL
			echo $eklenen;
			bakbaba($eklenen,$notlar,$telegramid,$pagetitle[1][0],$realname);
		} else {
			echo 0; // Diger kullanicilara bakma.
		}
	} else { // ACIKLANAN SEYI ARA
		$eklenen = $aciklananlar; // YENI EKLENEN ITEMI BUL
		echo $useridimiz; // İkinci leveldaki kullanicilari listele 
		bakbaba($eklenen,$notlar,$telegramid,$pagetitle[1][0],$realname);
	}
?>