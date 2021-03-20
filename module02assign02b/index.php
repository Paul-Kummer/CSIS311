<?php
$conversion = $_REQUEST['conversion'];

if($conversion == "meterToFeet")
{
	header("Location: http://puff.mnstate.edu/~cx3645kg/private/moduleTwo/assign2b/meterToFeet.html");
	exit();
}

if($conversion == "feetToMeter")
{
	header("Location: http://puff.mnstate.edu/~cx3645kg/private/moduleTwo/assign2b/feetToMeter.html");
	exit();
}
?>