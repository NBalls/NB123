<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>NB123</title>
</head>

<?php
include "simple_html_dom.php";
include "bean.php";

$mainUrl = "https://www.liaogou168.com/match/immediate.html";
$asiaUrl = "https://www.liaogou168.com/match/odd/asia/";
$ouUrl = "https://www.liaogou168.com/match/odd/ou/";

$html1 = new simple_html_dom();
$html1->load_file($mainUrl);
$contentTable = $html1->find('table.contentTable', 0);


// ###############################################
$childs1 = $contentTable->children(13)->children;
$childs = array();
array_push($childs, $childs1[0]);
array_push($childs, $childs1[1]);
array_push($childs, $childs1[2]);
// ###############################################

$mainArray = array();

foreach ($childs as $e) {
	// 联赛,时间,状态,主队,客队
	$id = $e->children(0)->children(0)->value;
	//echo $e->children(1)->children(0)->innertext;
	//echo $e->children(2)->innertext;
	//echo $e->children(3)->innertext;
	//echo $e->children(4)->children(0)->plaintext;
	//echo $e->children(6)->children(0)->plaintext;
	//echo "</br>";
	
	$mainBean = new MainBean();
	$mainBean->id = $e->children(0)->children(0)->value;
	$mainBean->liansai = $e->children(1)->children(0)->innertext;
	$mainBean->time = $e->children(2)->innertext;
	$mainBean->status = $e->children(3)->innertext;
	$mainBean->zhuduiUrl = "https://www.liaogou168.com".$e->children(4)->children(0)->href;
	$mainBean->zhudui = $e->children(4)->children(0)->plaintext;
	$mainBean->keduiUrl = "https://www.liaogou168.com".$e->children(6)->children(0)->href;
	$mainBean->kedui = $e->children(6)->children(0)->plaintext;
	$mainBean->analyseUrl = "https://www.liaogou168.com".$e->children(10)->children(0)->href;
	$mainBean->bigUrl = $e->children(10)->children(2)->href;
	$mainBean->asiaUrl = $e->children(10)->children(1)->href;
	$mainBean->ouUrl = $e->children(10)->children(3)->href;

	$html2 = new simple_html_dom();
	$html2->load_file($asiaUrl.$id);
	$asiaDiv = $html2->find('div#Odd', 0);
	$asiaTr = $asiaDiv->children(0)->children(1)->children;
	$mainBean->asiaArray = array();
	foreach ($asiaTr as $f) {
		//echo $f->children(0)->innertext;
		//echo $f->children(1)->innertext;
		//echo $f->children(2)->innertext;
		//echo $f->children(3)->innertext;
		//echo $f->children(4)->innertext;
		//echo $f->children(5)->innertext;
		//echo "</br>";
		$asiaBean = new AsiaBean();
		$asiaBean->company = $f->children(0)->innertext;
		$asiaBean->startZRate = $f->children(1)->innertext;
		$asiaBean->startPan = $f->children(2)->innertext;
		$asiaBean->startKRate = $f->children(3)->innertext;
		$asiaBean->endZRate = $f->children(4)->innertext;
		$asiaBean->endPan = $f->children(5)->innertext;
		$asiaBean->endKRate = $f->children(6)->innertext;
		array_push($mainBean->asiaArray, $asiaBean);
	}

	//echo "</br></br>";
	$html3 = new simple_html_dom();
	$html3->load_file($ouUrl.$id);
	$ouDiv = $html3->find('div#Odd', 0);
	$ouTr = $ouDiv->children(0)->children(1)->children;
	$mainBean->ouArray = array();
	foreach ($ouTr as $f) {
		//echo $f->children(0)->innertext;
		//echo $f->children(1)->innertext;
		//echo $f->children(2)->innertext;
		//echo $f->children(3)->innertext;
		//echo $f->children(4)->innertext;
		//echo $f->children(5)->innertext;
		//echo "</br>";
		$ouBean = new OuBean();
		$ouBean->company = $f->children(0)->innertext;
		$ouBean->startS = $f->children(1)->innertext;
		$ouBean->startP = $f->children(2)->innertext;
		$ouBean->startF = $f->children(3)->innertext;
		$ouBean->endS = $f->children(4)->innertext;
		$ouBean->endP = $f->children(5)->innertext;
		$ouBean->endF = $f->children(6)->innertext;
		array_push($mainBean->ouArray, $ouBean);

	}
	array_push($mainArray, $mainBean);
}

date_default_timezone_set('PRC');
echo "<div align='center'><font color='red' size='5'>今日".date("Y-m-d")."共有比赛：".count($mainArray)."场</font><div>";

$earlyTime = "23:59";
$completeCount = 0;
$playingCount = 0;
$nostartCount = 0;
foreach ($mainArray as $e) {
	if (strcmp($e->time, "12:00") > 0 && strcmp($e->time, $earlyTime) < 0) {
		$earlyTime = $e->time;	
	}
	if ($e->status == "已结束") {
		$completeCount = $completeCount + 1;
	} else if ($e->status == "") {
		$nostartCount = $nostartCount + 1;
	} else {
		$playingCount = $playingCount + 1;
	}
}
echo "<br><div align='center'>最早比赛时间：".$earlyTime;
echo "&nbsp&nbsp完场比赛：".$completeCount;
echo "场 &nbsp进行中比赛：".$playingCount;
echo "场 &nbsp尚未开始比赛：".$nostartCount."场</div><br><br>";

$num = 0;
foreach ($mainArray as $e) {
	echo "<table border='0' cellpadding='5' cellspacing='0'>
			<tr bgcolor='#66aa66' bgcolor='0'>
			<td align='center' width='60'>";

	$num = $num + 1;
	if ($num < 10) {
		echo "00".$num;
	} else if ($num < 100) {
		echo "0".$num;
	} else {
		echo $num;
	}
	echo "</td><td align='center' width='60'>";
	echo $e->status;
	echo "</td><td align='center' width='60'>";
	echo $e->liansai;
	echo "</td><td align='center' width='60'>";
	echo $e->time;
	echo "</td><td align='center' width='60'>";
	echo "<a href=".$e->zhuduiUrl.">".$e->zhudui."</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a href=".$e->keduiUrl.">".$e->kedui."</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a href=".$e->analyseUrl.">析</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a href=".$e->bigUrl.">大</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a href=".$e->ouUrl.">欧</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a href=".$e->asiaUrl.">亚</a>";
	echo "</td><td></td><td></td><td></td><td></td></tr>";

	if (count($e->asiaArray) == count($e->ouArray)) {
		for ($x = 0; $x < count($e->asiaArray); $x++) {
			echo "<tr bgcolor='#EEEEEE'><td align='center' width='100'>";
			echo $e->asiaArray[$x]->company;
			echo "</td><td align='center' width='60'>";
			echo $e->asiaArray[$x]->startZRate;
			echo "</td><td align='center' width='100'>";
			echo $e->asiaArray[$x]->startPan;
			echo "</td><td align='center' width='60'>";
			echo $e->asiaArray[$x]->startKRate;
			echo "</td><td align='center' width='60'>";

			if (strcmp($e->asiaArray[$x]->endZRate, $e->asiaArray[$x]->startZRate) > 0) {
				echo "<font color='#ff0000'>".$e->asiaArray[$x]->endZRate."</font>";
			} else if (strcmp($e->asiaArray[$x]->endZRate, $e->asiaArray[$x]->startZRate) < 0){
				echo "<font color='#00ff00'>".$e->asiaArray[$x]->endZRate."</font>";
			} else {
				echo "<font color='#000000'>".$e->asiaArray[$x]->endZRate."</font>";
			}
			echo "</td><td align='center' width='100'>";
			echo $e->asiaArray[$x]->endPan;
			echo "</td><td align='center' width='60'>";

			if (strcmp($e->asiaArray[$x]->endKRate, $e->asiaArray[$x]->startKRate) > 0) {
				echo "<font color='#ff0000'>".$e->asiaArray[$x]->endKRate."</font>";
			} else if (strcmp($e->asiaArray[$x]->endKRate, $e->asiaArray[$x]->startKRate) < 0){
				echo "<font color='#00ff00'>".$e->asiaArray[$x]->endKRate."</font>";
			} else {
				echo "<font color='#000000'>".$e->asiaArray[$x]->endKRate."</font>";
			}
			echo "</td>";

			echo "<td align='center' width='60'>";
			echo $e->ouArray[$x]->company;
			echo "</td><td align='center' width='60'>";
			echo $e->ouArray[$x]->startS;
			echo "</td><td align='center' width='60'>";
			echo $e->ouArray[$x]->startP;
			echo "</td><td align='center' width='60'>";
			echo $e->ouArray[$x]->startF;
			echo "</td><td align='center' width='60'>";

			if (strcmp($e->ouArray[$x]->endS, $e->ouArray[$x]->startS) > 0) {
				echo "<font color='#ff0000'>".$e->ouArray[$x]->endS."</font>";
			} else if (strcmp($e->ouArray[$x]->endS, $e->ouArray[$x]->startS) < 0) {
				echo "<font color='#00ff00'>".$e->ouArray[$x]->endS."</font>";
			} else {
				echo "<font color='#FF0000'>".$e->ouArray[$x]->endS."</font>";
			}
			echo "</td><td align='center' width='60'>";

			if (strcmp($e->ouArray[$x]->endP, $e->ouArray[$x]->startP) > 0) {
				echo "<font color='#ff0000'>".$e->ouArray[$x]->endP."</font>";
			} else if (strcmp($e->ouArray[$x]->endP, $e->ouArray[$x]->startP) < 0) {
				echo "<font color='#00ff00'>".$e->ouArray[$x]->endP."</font>";
			} else {
				echo "<font color='#000000'>".$e->ouArray[$x]->endP."</font>";
			}
			echo "</td><td align='center' width='60'>";

			if (strcmp($e->ouArray[$x]->endF, $e->ouArray[$x]->startF) > 0) {
				echo "<font color='#ff0000'>".$e->ouArray[$x]->endF."</font>";
			} else if (strcmp($e->ouArray[$x]->endF, $e->ouArray[$x]->startF) < 0) {
				echo "<font color='#00ff00'>".$e->ouArray[$x]->endF."</font>";
			} else {
				echo "<font color='#000000'>".$e->ouArray[$x]->endF."</font>";
			}
			echo "</td></tr>";
		}
	}
	
	echo "</table>";
}



?>