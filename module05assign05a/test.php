<?php
$arr = array("one");//, "two", "three");

for ($ct = 0 ; $ct < 50; $ct++)
{
	$ind = rand(0,count($arr)-1);
	print_r($arr[$ind]." || ");
}
?>