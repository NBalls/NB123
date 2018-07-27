<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>NB123</title>
</head>

<?php

include "simple_html_dom.php";
$resultUrl = "https://www.liaogou168.com/match/result.html";

$html1 = new simple_html_dom();
$html1->load_file($resultUrl);
$contentTable = $html1->find('table.contentTable', 0);
$childs = $contentTable->children(13)->children;
$mainArray = array();

foreach ($childs as $e) {
	// 联赛,时间,状态,主队,客队
	$id = $e->children(0)->children(0)->value;
	echo $e->children(1)->children(0)->innertext;
	echo $e->children(2)->innertext;
	echo $e->children(3)->innertext;
	echo $e->children(4)->children(0)->plaintext;
	echo $e->children(6)->children(0)->plaintext;
	echo "</br>";
}

?>