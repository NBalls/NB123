<?php

function echoTable($e, $num) {
	echo "<table border='0' cellpadding='5' cellspacing='0'>
			<tr bgcolor='#56e23B' bgcolor='0'>
			<td align='center' width='60'>";

	if ($num < 10) {
		echo "<font color='#ff0000'>"."00".$num."</font>";
	} else if ($num < 100) {
		echo "<font color='#ff0000'>"."0".$num."</font>";
	} else {
		echo "<font color='#ff0000'>".$num."</font>";
	}
	echo "</td><td align='center' width='60'>";
	echo "<font color='#ff0000'>".$e->status."</font>";
	echo "</td><td align='center' width='60'>";
	echo "<font color='#ff0000'>".$e->liansai."</font>";
	echo "</td><td align='center' width='60'>";
	echo "<font color='#ff0000'>".$e->time."</font>";
	echo "</td><td align='center' width='80'>";
	echo "<a target='_blank' href=".$e->zhuduiUrl.">".$e->zhudui."</a>";
	echo "</td><td align='center' width='80'>";
	echo "<a target='_blank' href=".$e->keduiUrl.">".$e->kedui."</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a target='_blank' href=".$e->analyseUrl.">析</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a target='_blank' href=".$e->bigUrl.">大</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a target='_blank' href=".$e->ouUrl.">欧</a>";
	echo "</td><td align='center' width='60'>";
	echo "<a target='_blank' href=".$e->asiaUrl.">亚</a>";
	echo "</td><td align='center' width='60'>";
	echo "<font color='#ff0000'>".substr($e->zhuPoint, 0, 2)."</font>";
	echo "</td><td align='center' width='60'>";
	echo "<font color='#ff0000'>".substr($e->zhuPoint, 4, 2)."</font>";
	echo "</td><td></td><td></td></tr>";

	if (count($e->asiaArray) == count($e->ouArray)) {
		for ($x = 0; $x < count($e->asiaArray); $x++) {
			echo "<tr bgcolor='#EEEEEE'><td align='center' width='100'>";
			echo $e->asiaArray[$x]->company;
			echo "</td><td align='center' width='60'>";
			echo $e->asiaArray[$x]->startZRate;
			echo "</td><td align='center' width='60'>";
			echo $e->asiaArray[$x]->startPan;
			echo "</td><td align='center' width='60'>";
			echo $e->asiaArray[$x]->startKRate;
			echo "</td><td align='center' width='80'>";

			if (strcmp($e->asiaArray[$x]->endZRate, $e->asiaArray[$x]->startZRate) > 0) {
				echo "<font color='#ff0000'>".$e->asiaArray[$x]->endZRate."</font>";
			} else if (strcmp($e->asiaArray[$x]->endZRate, $e->asiaArray[$x]->startZRate) < 0){
				echo "<font color='#00ff00'>".$e->asiaArray[$x]->endZRate."</font>";
			} else {
				echo "<font color='#000000'>".$e->asiaArray[$x]->endZRate."</font>";
			}
			echo "</td><td align='center' width='80'>";
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

function changePan($inputPan) {
	$mlevel = 0;
	if (strcmp($inputPan, "平手") == 0) {
		$mlevel = 0;
	} else if (strcmp($inputPan, "让平手/半球") == 0) {
		$mlevel = 0.25;
	} else if (strcmp($inputPan, "让半球") == 0) {
		$mlevel = 0.5;
	} else if (strcmp($inputPan, "让半/一") == 0) {
		$mlevel = 0.75;
	} else if (strcmp($inputPan, "让一球") == 0) {
		$mlevel = 1;
	} else if (strcmp($inputPan, "让一球/球半") == 0) {
		$mlevel = 1.25;
	} else if (strcmp($inputPan, "让球半") == 0) {
		$mlevel = 1.5;
	} else if (strcmp($inputPan, "让球半/两球") == 0) {
		$mlevel = 1.75;
	} else if (strcmp($inputPan, "让两球") == 0) {
		$mlevel = 2.0;
	} else if (strcmp($inputPan, "让两球/两半") == 0) {
		$mlevel = 2.25;
	} else if (strcmp($inputPan, "让两半") == 0) {
		$mlevel = 2.5;
	} else if (strcmp($inputPan, "让两半/三球") == 0) {
		$mlevel = 2.75;
	} else if (strcmp($inputPan, "让三秋") == 0) {
		$mlevel = 3.0;
	} else if (strcmp($inputPan, "受让平手/半球") == 0) {
		$mlevel = -0.25;
	} else if (strcmp($inputPan, "受让半球") == 0) {
		$mlevel = -0.5;
	} else if (strcmp($inputPan, "受让半/一") == 0) {
		$mlevel = -0.75;
	} else if (strcmp($inputPan, "受让一球") == 0) {
		$mlevel = -1;
	} else if (strcmp($inputPan, "受让一球/球半") == 0) {
		$mlevel = -1.25;
	} else if (strcmp($inputPan, "受让球半") == 0) {
		$mlevel = -1.5;
	} else if (strcmp($inputPan, "受让球半/两球") == 0) {
		$mlevel = -1.75;
	} else if (strcmp($inputPan, "受让两球") == 0) {
		$mlevel = -2.0;
	} else if (strcmp($inputPan, "受让两球/两半") == 0) {
		$mlevel = -2.25;
	} else if (strcmp($inputPan, "受让两半") == 0) {
		$mlevel = -2.5;
	} else if (strcmp($inputPan, "受让两半/三球") == 0) {
		$mlevel = -2.75;
	} else if (strcmp($inputPan, "受让三秋") == 0) {
		$mlevel = -3.0;
	}

	return $mlevel;
}

?>