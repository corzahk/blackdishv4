<?php


$connect = [
	# Database Host Name
	'HOSTNAME' => 'localhost',

	# Database Username
	'USERNAME' => 'root',

	# Database Password
	'PASSWORD' => '',

	# Database Name
	'DATABASE' => 'blackdishdish'
];

# Tables' Prefix
define('prefix', 'pl_');

# No es necesario cambiar nada debajo de esta línea
$db = new mysqli($connect['HOSTNAME'], $connect['USERNAME'], $connect['PASSWORD'], $connect['DATABASE']);
if($db->connect_errno){
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		exit;
}


$sql_mode = $db->query("SELECT @@GLOBAL.sql_mode;");
$rs_mode = $sql_mode->fetch_assoc();
if(!empty($rs_mode["@@GLOBAL.sql_mode"])) {
	$db->query("SET GLOBAL sql_mode='';");
}
