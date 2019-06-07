<?php
$c['database.hostname'] = 'localhost';
$c['database.username'] = 'tripplan_ner';
$c['database.password'] = 'h.eR~[9-3HWK554';
$c['database.name'] = 'tripplan_ner';

try {
    $hostname = $c['database.hostname'];
    $dbname = $c['database.name'];
    $username = $c['database.username'];
    $password = $c['database.password'];
    $db_link = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $username, $password);
   	// echo "Connected";
}
catch(PDOException $e)
{
   echo $e->getMessage();
}


function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w');
    fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));
    foreach ($array as $line) { 
        fputcsv($f, $line, $delimiter);         
    }
    fseek($f, 0);
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    fpassthru($f);
}

function getCatalogTitles($db_link, $ins, $l){
	$sql = "SELECT `title` FROM `catalogs` WHERE `language`='".$l."' AND (`menuid`=36 OR `menuid`=24) AND `visibility`=1 AND `deleted`=0 AND `id` IN(".$ins.") ORDER BY `position` ASC";
	//echo $sql;
	$prepare = $db_link->prepare($sql);
	$prepare->execute();
	$out = array();
	if($prepare->rowCount()){
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		foreach ($fetch as $v) {
			$out[] = $v["title"];
		}
	}
	return implode(";\n", $out);
}

$userid = (isset($_GET['id'])) ? "`cart`.`userid`='".$_GET['id']."' AND " : "";
$admin = (isset($_GET['admin']) && $_GET['admin']==4) ? "`cart`.`website`='beetrip' AND " : "";
$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'ge';
$type = (isset($_GET['type'])) ? $_GET['type'] : 'transport';
$from = (isset($_GET['from'])) ? $_GET['from'] : 'usersList';

if($type == "transport" && $from == "usersList"){
	$sql = "SELECT 
	`cart`.`id`,
	`cart`.`date`, 
	`cart`.`startdate`,  
	`cart`.`startdate2`,  
	`cart`.`type`,  
	`cart`.`timetrans`,   
	`cart`.`timetrans2`,   
	`cart`.`totalprice`,  
	`cart`.`roud1_price`,  
	`cart`.`roud2_price`,  
	`cart`.`guests`,  
	`cart`.`guests2`,    
	`cart`.`website`,    
	`cart`.`userid`,    
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=`cart`.`startplace` AND `language`='".$lang."' AND `deleted`=0) AS startPlaceName, 
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=`cart`.`endplace` AND `language`='".$lang."' AND `deleted`=0) AS endPlaceName,  
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=`cart`.`startplace2` AND `language`='".$lang."' AND `deleted`=0) AS startPlaceName2, 
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=`cart`.`endplace2` AND `language`='".$lang."' AND `deleted`=0) AS endPlaceName2
	FROM 
	`cart`
	LEFT JOIN `catalogs` ON `catalogs`.`id`=`cart`.`pid` AND `catalogs`.`language`='".$lang."'
	WHERE 
	".$userid." ".$admin."
	`cart`.`type`='".$type."' AND  
	`cart`.`status`='payed'  
	ORDER BY `cart`.`date` DESC";
	
	$prepare = $db_link->prepare($sql);
	$prepare->execute();

	if($prepare->rowCount()){
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		$out = array();
	    $out[0][] = "#";
	    $out[0][] = "Order Date";
	    
	    $out[0][] = "Pick Up Date 1";
	    $out[0][] = "Pick Up Time 1";
	    $out[0][] = "Guests 1";
	    $out[0][] = "Start Place 1";
	    $out[0][] = "End Place 1";
	    $out[0][] = "Trip Price 1";

	    $out[0][] = "Pick Up Date 2";
	    $out[0][] = "Pick Up Time 2";
	    $out[0][] = "Guests 2";
	    $out[0][] = "Start Place 2";
	    $out[0][] = "End Place 2";
	    $out[0][] = "Trip Price 2";

	    $out[0][] = "Type";
	    $out[0][] = "Total Price";
	    $out[0][] = "Website";
	    $out[0][] = "Users Email";
		
		$x = 1;
	    foreach ($fetch as $v) {
	    	$out[$x][] = (!empty($v["id"])) ? $v["id"] : "N/A";
	    	$out[$x][] = (!empty($v["date"])) ? date("Y-m-d", $v["date"]) : "N/A";
	    	
	    	$out[$x][] = (!empty($v["startdate"])) ? $v["startdate"] : "N/A";
	    	$out[$x][] = (!empty($v["timetrans"])) ? $v["timetrans"] : "N/A";
	    	$out[$x][] = (!empty($v["guests"])) ? $v["guests"] : "N/A";
	    	$out[$x][] = (!empty($v["startPlaceName"])) ? $v["startPlaceName"] : "N/A";
	    	$out[$x][] = (!empty($v["endPlaceName"])) ? $v["endPlaceName"] : "N/A";
	    	$out[$x][] = (!empty($v["roud1_price"])) ? $v["roud1_price"] : "N/A";
	    	$out[$x][] = (!empty($v["startdate2"])) ? $v["startdate2"] : "N/A";
	    	$out[$x][] = (!empty($v["timetrans2"])) ? $v["timetrans2"] : "N/A";
	    	$out[$x][] = (!empty($v["guests2"])) ? $v["guests2"] : "N/A";
	    	$out[$x][] = (!empty($v["startPlaceName2"])) ? $v["startPlaceName2"] : "N/A";
	    	$out[$x][] = (!empty($v["endPlaceName2"])) ? $v["endPlaceName2"] : "N/A";
	    	$out[$x][] = (!empty($v["roud2_price"])) ? $v["roud2_price"] : "N/A";
	    	$out[$x][] = (!empty($v["type"])) ? $v["type"] : "N/A";
	    	$out[$x][] = (!empty($v["totalprice"])) ? $v["totalprice"] : "N/A";
	    	$out[$x][] = (!empty($v["website"])) ? $v["website"] : "N/A";
	    	$out[$x][] = (!empty($v["userid"])) ? $v["userid"] : "N/A";
	    	$x++;   	
	    }
		array_to_csv_download($out, "transfers.csv", ",");
	}else{
		echo "No Data !";
	}
}else if($type == "plantrip" && $from == "usersList"){
	$sql = "SELECT 
	`cart`.`id`,
	`cart`.`date`, 
	`cart`.`startdate`,  
	`cart`.`startdate2`,  
	`cart`.`type`, 
	`cart`.`guests`, 	  
	`cart`.`totalprice`, 	     
	`cart`.`website`,    
	`cart`.`tourplaces`,
	`cart`.`userid`
	FROM 
	`cart`
	WHERE 
	".$userid." ".$admin."
	`cart`.`type`='".$type."' AND  
	`cart`.`status`='payed'  
	ORDER BY `cart`.`date` DESC";
	// echo $sql;
	$prepare = $db_link->prepare($sql);
	$prepare->execute();

	if($prepare->rowCount()){
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		$out = array();
	    $out[0][] = "#";
	    $out[0][] = "Order Date";	    
	    $out[0][] = "Places";
	    $out[0][] = "Start Date";
	    $out[0][] = "End Date";
	    $out[0][] = "Type";
	    $out[0][] = "Guests";
	    $out[0][] = "Total Price";
	    $out[0][] = "Website";
	    $out[0][] = "Users Email";
		
		$x = 1;
	    foreach ($fetch as $v) {
	    	$out[$x][] = (!empty($v["id"])) ? $v["id"] : "N/A";
	    	$out[$x][] = (!empty($v["date"])) ? date("Y-m-d", $v["date"]) : "N/A";
	    	// $out[$x][] = (!empty($v["tourplaces"])) ? $v["tourplaces"] : "N/A";
	    	$out[$x][] = (!empty($v["tourplaces"])) ? getCatalogTitles($db_link, $v["tourplaces"], $lang) : "N/A";
	    	
	    	$out[$x][] = (!empty($v["startdate"])) ? $v["startdate"] : "N/A";
	    	$out[$x][] = (!empty($v["startdate2"])) ? $v["startdate2"] : "N/A";
	    	$out[$x][] = (!empty($v["type"])) ? $v["type"] : "N/A";
	    	$out[$x][] = (!empty($v["guests"])) ? $v["guests"] : "N/A";    	
	    	
	    	$out[$x][] = (!empty($v["totalprice"])) ? $v["totalprice"] : "N/A";
	    	$out[$x][] = (!empty($v["website"])) ? $v["website"] : "N/A";
	    	$out[$x][] = (!empty($v["userid"])) ? $v["userid"] : "N/A";
	    	
	    	$x++;   	
	    }
		array_to_csv_download($out, "plantrip.csv", ",");
	}else{
		echo "No Data !";
	}
}else if($type == "ongoing" && $from == "usersList"){
	$sql = "SELECT 
	`cart`.`id`,
	`cart`.`date`, 
	`cart`.`pid`,    
	`cart`.`guests`, 	  
	`cart`.`totalprice`, 
	`cart`.`type`,	     
	`cart`.`website`,
	`cart`.`userid`
	FROM 
	`cart`
	WHERE 
	".$userid." ".$admin."
	`cart`.`type`='".$type."' AND  
	`cart`.`status`='payed'  
	ORDER BY `cart`.`date` DESC";
	// echo $sql;
	$prepare = $db_link->prepare($sql);
	$prepare->execute();

	if($prepare->rowCount()){
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		$out = array();
	    $out[0][] = "#";
	    $out[0][] = "Order Date";	    
	    $out[0][] = "Tour";
	    $out[0][] = "Guests";
	    $out[0][] = "Total Price";
	    $out[0][] = "Type";
	    $out[0][] = "Website";
	    $out[0][] = "Users Email";
		
		$x = 1;
	    foreach ($fetch as $v) {
	    	$out[$x][] = (!empty($v["id"])) ? $v["id"] : "N/A";
	    	$out[$x][] = (!empty($v["date"])) ? date("Y-m-d", $v["date"]) : "N/A";
	    	$out[$x][] = (!empty($v["pid"])) ? getCatalogTitles($db_link, $v["pid"], $lang) : "N/A";
	    	$out[$x][] = (!empty($v["guests"])) ? $v["guests"] : "N/A";    	
	    	
	    	$out[$x][] = (!empty($v["totalprice"])) ? $v["totalprice"] : "N/A";
	    	$out[$x][] = (!empty($v["type"])) ? $v["type"] : "N/A";
	    	$out[$x][] = (!empty($v["website"])) ? $v["website"] : "N/A";
	    	$out[$x][] = (!empty($v["userid"])) ? $v["userid"] : "N/A";
	    	
	    	$x++;   	
	    }
		array_to_csv_download($out, "ongoing.csv", ",");
	}else{
		echo "No Data !";
	}
}