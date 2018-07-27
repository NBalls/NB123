<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>NB123</title>
</head>

<?php
include "library/simple_html_dom.php";
include "bean/result_bean.php";
$resultUrl = "https://www.liaogou168.com/match/result.html";

$html = new simple_html_dom();
$html->load_file($resultUrl);
$contentTable = $html->find('table.contentTable', 0);
$childs = $contentTable->children(13)->children;
$resultArray = array();

foreach ($childs as $e) {
	if(strcmp($e->children(3)->innertext,'已结束') == 0 
		&& strcmp($e->children(9)->children(0)->children(1)->innertext, "-") != 0){
		//$id = $e->children(0)->children(0)->value;
		//echo $e->children(1)->children(0)->innertext;
		//echo substr($e->children(2)->plaintext, 0, 5);
		//echo $e->children(3)->innertext;
		//if (strcmp(strrchr($e->children(4)->children(0)->plaintext, "&nbsp;"), "") == 0) {
			//echo $e->children(4)->children(0)->plaintext;
		//} else {
			//echo substr(strrchr($e->children(4)->children(0)->plaintext, "&nbsp;"), 6);
		//}
		//echo $e->children(5)->children(0)->children(0)->innertext;
		//if (strcmp(strstr($e->children(6)->children(0)->plaintext, "&nbsp;", true), "") == 0) {
			//echo $e->children(6)->children(0)->plaintext;
		//} else {
			//echo strstr($e->children(6)->children(0)->plaintext, "&nbsp;", true);
		//}
		//echo $e->children(9)->children(0)->children(1)->innertext;
		//echo $e->children(9)->children(1)->children(1)->innertext;
		//echo "</br>";

		$resultBean = new ResultBean();
		$resultBean->id = $e->children(0)->children(0)->value;
		$resultBean->liansai = $e->children(1)->children(0)->innertext;
		$resultBean->time = substr($e->children(2)->plaintext, 0, 5);
		$resultBean->status = $e->children(3)->innertext;
		if (strcmp(strrchr($e->children(4)->children(0)->plaintext, "&nbsp;"), "") == 0) {
			$resultBean->zhudui = $e->children(4)->children(0)->plaintext;
		} else {
			$resultBean->zhudui = substr(strrchr($e->children(4)->children(0)->plaintext, "&nbsp;"), 6);
		}
		if (strcmp(strstr($e->children(6)->children(0)->plaintext, "&nbsp;", true), "") == 0) {
			$resultBean->kedui = $e->children(6)->children(0)->plaintext;
		} else {
			$resultBean->kedui = strstr($e->children(6)->children(0)->plaintext, "&nbsp;", true);
		}
		$resultBean->zhuPoint = substr($e->children(5)->children(0)->children(0)->innertext, 0, 2);
		$resultBean->kePoint = substr($e->children(5)->children(0)->children(0)->innertext, 4, 2);
		$resultBean->aisaPan = $e->children(9)->children(0)->children(1)->innertext;
		$resultBean->bigPan = $e->children(9)->children(1)->children(1)->innertext;

		// echo $resultBean->id."  ".$resultBean->liansai."  ".$resultBean->time."  ".$resultBean->status."  ".$resultBean->zhudui;
		// echo $resultBean->kedui."  ".$resultbean->zhuPoint."  ".$resultbean->kePoint."  ".$resultBean->aisaPan."  ".$resultBean->bigPan;
		$mlevel = 0;
		if (strcmp($e->children(9)->children(0)->children(1)->innertext, "平手") == 0) {
			$mlevel = 0;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让平手/半球") == 0) {
			$mlevel = 0.25;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让半球") == 0) {
			$mlevel = 0.5;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让半/一") == 0) {
			$mlevel = 0.75;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让一球") == 0) {
			$mlevel = 1;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让一球/球半") == 0) {
			$mlevel = 1.25;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让球半") == 0) {
			$mlevel = 1.5;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让球半/两球") == 0) {
			$mlevel = 1.75;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让两球") == 0) {
			$mlevel = 2.0;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让两球/两半") == 0) {
			$mlevel = 2.25;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让两半") == 0) {
			$mlevel = 2.5;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让两半/三球") == 0) {
			$mlevel = 2.75;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "让三秋") == 0) {
			$mlevel = 3.0;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让平手/半球") == 0) {
			$mlevel = -0.25;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让半球") == 0) {
			$mlevel = -0.5;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让半/一") == 0) {
			$mlevel = -0.75;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让一球") == 0) {
			$mlevel = -1;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让一球/球半") == 0) {
			$mlevel = -1.25;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让球半") == 0) {
			$mlevel = -1.5;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让球半/两球") == 0) {
			$mlevel = -1.75;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让两球") == 0) {
			$mlevel = -2.0;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让两球/两半") == 0) {
			$mlevel = -2.25;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让两半") == 0) {
			$mlevel = -2.5;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让两半/三球") == 0) {
			$mlevel = -2.75;
		} else if (strcmp($e->children(9)->children(0)->children(1)->innertext, "受让三秋") == 0) {
			$mlevel = -3.0;
		}
		$resultBean->aisaPan = $mlevel;

		array_push($resultArray, $resultBean);
	}
}


$bbig = 0;
$bsmall = 0;
$bmiddle = 0;
$aup = 0;
$adown = 0;
$alevel = 0;
$lianArray = array();
foreach($resultArray as $e) {
	if (strcmp($e->zhuPoint+$e->kePoint, $e->bigPan) > 0) {
		$bbig = $bbig + 1;
	} else if (strcmp($e->zhuPoint+$e->kePoint, $e->bigPan) < 0) {
		$bsmall = $bsmall + 1;
	} else {
		$bmiddle = $bmiddle + 1;
	}
	if ($e->aisaPan >= 0) {
		if ($e->zhuPoint - $e->aisaPan > $e-kePoint) {
			$aup = $aup + 1;
		} else if ($e->zhuPoint - $e->aisaPan < $e-kePoint) {
			$adown = $adown + 1;
		} else {
			$alevel = $alevel + 1;
		}
	} else {
		if ($e->kePoint + $e->aisaPan > $e-zhuPoint) {
			$aup = $aup + 1;
		} else if ($e->kePoint + $e->aisaPan < $e-zhuPoint) {
			$adown = $adown + 1;
		} else {
			$alevel = $alevel + 1;
		}
	}
	
	if (in_array($e->liansai, $lianArray)) {
	} else {
		array_push($lianArray, $e->liansai);
	}
}

echo "昨日比赛共：".count($resultArray)."场</br>";
echo "大球:".$bbig."场,小球:".$bsmall."场,走水:".$bmiddle."场</br>";
echo "上盘:".$aup."场,下盘:".$adown."场,走水:".$alevel."场</br>";

$mainArray = array();
foreach ($lianArray as $e) {
	$subArray = array();
	foreach ($resultArray as $f) {
		if (strcmp($f->liansai, $e) == 0) {
			array_push($subArray, $f);
		}
	}	
	array_push($mainArray, $subArray);
}

foreach ($mainArray as $e) {
	echo "联赛：".$e[0]->liansai."    ".count($e)."</br>";
}

?>