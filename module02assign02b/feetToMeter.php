<!DOCTYPE php>
<html>
	<head>
		<title>Feet To Meters</title>
	</head>
	<body>
		<?php
		$feetToConvert = $_REQUEST['feet'];
		$meterConversion = $feetToConvert / 3.28084;

		echo "<h2> $feetToConvert feet = $meterConversion meters</h2>";
		?><br>

		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/moduleTwo/assign2b/meterToFeet.html'" type="button">Back To m --> ft</button>
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/moduleTwo/assign2b/index.html'" type="button">Back To Conversion</button><br>
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/index.html'" type="button">Back To Main Index</button>
	</body>
</html>