<?php

class MainBean {
	public $id;
	public $liansai;
	public $time;
	public $status;
	public $zhudui;
	public $zhuduiUrl;
	public $kedui;
	public $keduiUrl;
	public $analyseUrl;
	public $bigUrl;
	public $asiaUrl;
	public $ouUrl;
	public $asiaArray = array();
	public $ouArray = array();
}

class AsiaBean {
	public $company;
	public $startZRate;
	public $startPan;
	public $startKRate;
	public $endZRate;
	public $endPan;
	public $endKRate;
}

class OuBean {
	public $company;
	public $startS;
	public $startP;
	public $startF;
	public $endS;
	public $endP;
	public $endF;
}

?>
