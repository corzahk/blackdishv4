<?php

if($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6){

	$site_plans = isset($_POST['site_plans']) ? 1 : 0;

	for($x=1; $x<=4;$x++){
		$sql = $db->query("DESCRIBE ".prefix."plans");
		while($row = $sql->fetch_array()){
			if($row['Field'] != 'id'){
				if($row['Type'] == "tinyint(1)"){
					$vv = isset($_POST[$row['Field']][$x]) ? 1 : 0;
				}
				elseif($row['Type'] == "int(11)"){
					$vv = isset($_POST[$row['Field']][$x]) ? (int)($_POST[$row['Field']][$x]) : 0;
				}
				else{
					$vv = isset($_POST[$row['Field']][$x]) ? sc_sec($_POST[$row['Field']][$x]) : '';
				}
				db_update("plans", ["{$row['Field']}" => $vv], $x);
			}
		}
	}

	db_update_global('site_plans', $site_plans);

	$alert = [
		'type'  =>'success',
		'alert' => fh_alerts($lang['dash']['alert']['success'], 'success')
	];

	echo json_encode($alert);
}
