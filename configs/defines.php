<?php


# Getting the current page name
define("page", basename($_SERVER['PHP_SELF'], '.php'));
define("nophoto", path."/img/nophoto.jpg");
define("noimage", path."/img/noimage.jpg");

# Default Country code
define("c_code", "us");


$flatColors = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "7f8c8d"];

# If the installation file exists
if (file_exists(__DIR__."/../install.php")) {
	die('<meta http-equiv="refresh" content="0;url=install.php">');
}
