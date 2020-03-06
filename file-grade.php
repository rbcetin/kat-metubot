<?php

if (!preg_match("#Manual item#si" , $html)) {
	
		$yenilink="https://odtuclass.metu.edu.tr/course/view.php?id=".$dersidss;
		curl_setopt($ch, CURLOPT_URL, "https://odtuclass.metu.edu.tr/course/view.php?id=".$dersidss);
        $html        = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, "https://odtuclass.metu.edu.tr/login/logout.php?sesskey=".$sesskey);
		$logout = curl_exec($ch);
		curl_close($ch);
		
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html, LIBXML_NOWARNING);
libxml_use_internal_errors(false);
$xpath = new DomXpath($dom);
$elements = $xpath->query('//div[@class="activityinstance"]');
$abcd="";
	foreach ($elements as $element) {$nodes = $element->childNodes;
		foreach ($nodes as $node) {
			$sex = $node->nodeValue. "\n";
				if(!preg_match("#Places|Syllabus|Groups#si",$sex)){
					if(preg_match("#M1|M2|MT1|MT2|Results|Final|Grades#si",$sex)) {
					$abcd.= $node->nodeValue.",";
					}
				}
				
	if (file_exists($dosya)) {
		$lines = file($dosya);
		$fh = fopen($dosya, 'w') or die("can't open file");fwrite($fh, $abcd);fclose($fh); 
		unset($elements);
		$lines2 = file($dosya);
	} else {
		$fh = fopen($dosya, 'w') or die("can't open file");fwrite($fh, $abcd);fclose($fh); 
		unset($elements);
			$lines2 = file($dosya);
		$lines = file($dosya);
	}
	
		
		}
	}

?>