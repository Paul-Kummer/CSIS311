<!DOCTYPE php>
<html>
	<head>
		<title>Meters To Feet</title>
	</head>
	<body>
		<?php
		$meterToConvert = $_REQUEST['meters'];
		$feetConversion = $meterToConvert * 3.28084;

		echo "<h2> $meterToConvert meters = $feetConversion feet</h2>";
		?><br>

		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/moduleTwo/assign2b/meterToFeet.html'" type="button">Back To ft --> m</button>
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/moduleTwo/assign2b/index.html'" type="button">Back To Conversion</button><br>
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/index.html'" type="button">Back To Main Index</button>
	</body>
</html>