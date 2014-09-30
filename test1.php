<?php 
include ("global.php");
include ("layout.php");
include ("functions.php");

echo "hi";
$file = new SimpleXMLElement(file_get_contents("http://catalog.umd.edu/cgi-bin/cpsgequip"));
print_r($file->body -> table[1]->tr);

?>