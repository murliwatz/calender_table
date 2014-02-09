<?php
	header("Content-Type: application/json");
	
	if((isset($_GET["month"]) || !empty($_GET["month"])) && (isset($_GET["year"]) || !empty($_GET["year"]))){
		$month = $_GET["month"];
		$year = $_GET["year"];
	} else if((isset($_POST["month"]) || !empty($_POST["month"])) && (isset($_POST["year"]) || !empty($_POST["year"]))){
		$month = $_POST["month"];
		$year = $_POST["year"];
	} else {
		$month = date("m");
		$year = date("Y");	
	}
	
	$data = array();
	
	$wd_1 = date("N", mktime(0,0,0,$month,1,$year));
	if($wd_1 == 1)
		$c = 8;
	else
		$c = $wd_1;
	
	if($month == 1){
		$month_before = 12;
		$year_before = $year - 1;
	} else {
		$month_before = $month - 1;
		$year_before = $year;
	}
	if($month == 12){
		$month_after = 1;
		$year_after = $year + 1;
	} else {
		$month_after = $month + 1;
		$year_after = $year;
	}
	$month_count_before = cal_days_in_month(CAL_GREGORIAN, $month_before, $year);
	for($day = $month_count_before-$c+2; $day <= $month_count_before; $day++){
		$col = date("N", mktime(0,0,0,$month_before,$day,$year_before));
		$row = 1;
		$a = array();
		$a["row"] = $row;
		$a["col"] = $col;
		$a["day"] = date("d", mktime(0,0,0,$month_before,$day,$year_before));
		$a["month"] = date("m", mktime(0,0,0,$month_before,$day,$year_before));
		$a["year"] = date("Y", mktime(0,0,0,$month_before,$day,$year_before));
		$a["enabled"] = false;
		if(date("Y-m-d", mktime(0,0,0,$month_before,$day,$year_before)) == date("Y-m-d"))
			$a["current_day"] = true;
		else
			$a["current_day"] = false;
		array_push($data, $a);
		//echo $col . " " . $row . " " .date("d.m.Y", mktime(0,0,0,$month_before,$day,$year_before)). "<br>";
	}
	$month_count = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	for($day = 1; $day <= $month_count; $day++){
		$col = date("N", mktime(0,0,0,$month,$day,$year));
		$row = ceil($c / 7);
		$a = array();
		$a["row"] = $row;
		$a["col"] = $col;
		$a["day"] = date("d", mktime(0,0,0,$month,$day,$year));
		$a["month"] = date("m", mktime(0,0,0,$month,$day,$year));
		$a["year"] = date("Y", mktime(0,0,0,$month,$day,$year));
		$a["enabled"] = true;
		if(date("Y-m-d", mktime(0,0,0,$month,$day,$year)) == date("Y-m-d"))
			$a["current_day"] = true;
		else
			$a["current_day"] = false;
		array_push($data, $a);
		//echo $col . " " . $row .  " " .date("d.m.Y", mktime(0,0,0,$month,$day,$year)). "<br>";
		$c++;
	}
	$max_days_after = (42-$c+1);
	for($day = 1; $day <= $max_days_after; $day++){
		$col = date("N", mktime(0,0,0,$month_after,$day,$year_after));
		$row = ceil($c / 7);
		$a = array();
		$a["row"] = $row;
		$a["col"] = $col;
		$a["day"] = date("d", mktime(0,0,0,$month_after,$day,$year_after));
		$a["month"] = date("m", mktime(0,0,0,$month_after,$day,$year_after));
		$a["year"] = date("Y", mktime(0,0,0,$month_after,$day,$year_after));
		$a["enabled"] = false;
		if(date("Y-m-d", mktime(0,0,0,$month_after,$day,$year_after)) == date("Y-m-d"))
			$a["current_day"] = true;
		else
			$a["current_day"] = false;
		array_push($data, $a);
		//echo $col . " " . $row .  " " .date("d.m.Y", mktime(0,0,0,$month_after,$day,$year_after)). "<br>";
		$c++;
	}
	
	$obj["next_month"] = $month_after;
	$obj["next_year"] = $year_after;
	$obj["previous_month"] = $month_before;
	$obj["previous_year"] = $year_before;
	$obj["next_month_full"] = date("F",mktime(0,0,0,$month_after));
	$obj["next_month_short"] = date("M",mktime(0,0,0,$month_after));
	$obj["previous_month_full"] = date("F",mktime(0,0,0,$month_before));
	$obj["previous_month_short"] = date("M",mktime(0,0,0,$month_before));
	$obj["current_month_full"] = date("F",mktime(0,0,0,$month));
	$obj["current_month_short"] = date("M",mktime(0,0,0,$month));
	$obj["current_year"] = date("Y",mktime(0,0,0,$month,0,$year));
	$obj["calendar_table"] = $data;
	echo json_encode($obj);
?>