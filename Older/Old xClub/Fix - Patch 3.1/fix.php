<?php  error_reporting(E_ALL); 
//Vital file include
require_once("load.php");
$db->query("Update ".DB_PREFIX."videos set thumb = CONCAT('http:',thumb) where thumb like '//%'");
echo "Fix applied.<br>";

echo "<pre>";
$db->debug();
echo "</pre>";
?>