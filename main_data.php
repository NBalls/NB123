<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>NB123</title>
</head>

<?php
include "library/simple_html_dom.php";
include "extra/main_extra.php";
include "bean/main_bean.php";

$mainUrl = "https://www.liaogou168.com/match/immediate.html";
$asiaUrl = "https://www.liaogou168.com/match/odd/asia/";
$ouUrl = "https://www.liaogou168.com/match/odd/ou/";
$html1 = new simple_html_dom();
$html1->load_file($mainUrl);
$contentTable = $html1->find('table.contentTable', 0);
$childs = $contentTable->children(13)->children;
$mainArray = array();

foreach ($childs as $e) {
	$id = $e->children(0)->children(0)->value;
	$mainBean = new MainBean();
	$mainBean->id = $e->children(0)->children(0)->value;
	$mainBean->liansai = $e->children(1)->children(0)->innertext;
	$mainBean->time = $e->children(2)->innertext;
	$mainBean->status = $e->children(3)->innertext;
	$mainBean->zhuduiUrl = "https://www.liaogou168.com".$e->children(4)->children(0)->href;
	$mainBean->zhudui = $e->children(4)->children(0)->plaintext;
	$mainBean->zhuPoint = $e->children(5)->children(0)->children(0)->innertext;
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
		$asiaBean = new AsiaBean();
		$asiaBean->company = $f->children(0)->innertext;
		$asiaBean->startZRate = $f->children(1)->innertext;
		$asiaBean->startKRate = $f->children(3)->innertext;
		$asiaBean->endZRate = $f->children(4)->innertext;
		$asiaBean->endKRate = $f->children(6)->innertext;
		$asiaBean->startPan = changePan($f->children(2)->innertext);
		$asiaBean->endPan = changePan($f->children(5)->innertext);
		array_push($mainBean->asiaArray, $asiaBean);
	}

	$html3 = new simple_html_dom();
	$html3->load_file($ouUrl.$id);
	$ouDiv = $html3->find('div#Odd', 0);
	$ouTr = $ouDiv->children(0)->children(1)->children;
	$mainBean->ouArray = array();
	foreach ($ouTr as $f) {
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


	/*$html4 = new simple_html_dom();
	$html4->load_file($mainBean->analyseUrl);
	$historyDiv = $html4->find('div#Data_History', 0);
	if ($historyDiv != null 
		&& $historyDiv->children(1) != null
		&& $historyDiv->children(1)->children(1) != null
		&& $historyDiv->children(1)->children(1)->children(2) != null
		&& $historyDiv->children(1)->children(1)->children(2)->children(1) != null
		&& $historyDiv->children(2) != null
		&& $historyDiv->children(2)->children(1) != null 
		&& $historyDiv->children(2)->children(1)->children(2) != null
		&& $historyDiv->children(2)->children(1)->children(2)->children(1) != null) {

		// sleep(5);
		$zhuBody = $historyDiv->children(1)->children(1)->children(2)->children(1);
		$zhuTr = $zhuBody->children;
		foreach ($zhuTr as $e) {
			// array_push($mainBean->zhuResult, $e->children(23)->innertext);
		}
		$keBody = $historyDiv->children(2)->children(1)->children(2)->children(1);
		$keTr = $keBody->children;
		foreach ($keTr as $e) {
			//array_push($mainBean->keResult, $e->children(23)->innertext);
		}
	}*/
	
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


// ###################### 1.44比赛 ####################################
echo "<font color='#ff0000' size='6'>".'1.44比赛</br>'."</font>";
$num1 = 0;
foreach ($mainArray as $e) {

	$isPrint = false;
	if (count($e->ouArray) >= 2) {
		foreach ($e->ouArray as $f) {
			if (strcmp($f->startS, '1.44') == 0 
				|| strcmp($f->startF, '1.44') == 0
				|| strcmp($f->endS, '1.44') == 0
				|| strcmp($f->endF, '1.44') == 0) {
				$isPrint = true;
			} 
		}

		if ($isPrint) {
			$num1 = $num1 + 1;
			echoTable($e, $num1);
		}
	}
}
echo "</br></br></br>";
// ###################### 1.44比赛 ####################################

// ###################### 连续变化两个盘口比赛 ###########################
echo "<font color='#ff0000' size='6'>".'变盘2个盘口以上比赛<br>'."</font>";
$num2 = 0;
foreach ($mainArray as $e) {

	$isPrint = 0;
	foreach ($e->asiaArray as $f) {
		if ($f->endPan - $f->startPan >= 0.5 ||
				$f->endPan - $f->startPan <= -0.5) {
			$isPrint = $isPrint + 1;
		} 
	}

	if ($isPrint >= 2) {
		$num2 = $num2 + 1;
		echoTable($e, $num2);
	}
}
echo "</br></br></br>";
// ###################### 连续变化两个盘口比赛 ###########################

// ###################### 下盘看近期比赛 ################################
echo "<font color='#ff0000' size='6'>".'下盘比赛<br>'."</font>";
$num3 = 0;
foreach ($mainArray as $e) {

	$isPrint = false;
	if (count($f->zhuResult) > 0 && count($f->keResult) > 0) {
		if ($f->endPan >= 0.25 && strcmp($f->zhuResult->children(0), '赢') == 0 && strcmp($f->keResult->children(0), '输') == 0) {
			$isPrint = true;
		} else if ($f->endPan <= -0.25 && strcmp($f->zhuResult->children(0), '输') == 0 && strcmp($f->keResult->children(0), '赢') == 0) {
			$isPrint = true;
		}
	}

	if ($isPrint) {
		$num2 = $num3 + 1;
		echoTable($e, $num3);
	}
}
echo "</br></br></br>";
// ###################### 下盘看近期比赛 ################################

$num8 = 0;
foreach ($mainArray as $e) {
	$num8 = $num8 + 1;
	if (count($e->ouArray) >= 2) {
		echoTable($e, $num8);
	}
}

?>