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

<h1> Feet To Meters</h1>
	<form action="feetToMeter.php" method="POST">
		<fieldset>
			<legend>Convert Meters To Feet: 1ft = 0.3048m</legend>
			<p><strong>Enter number of Feet: </strong><input type="text" name="feet" value="<?php echo $feetConversion?>">
			<input type="submit" value="Convert Now!"></p>
		</fieldset>
	</form>

		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage1/index.php'" type="button">Back To Conversion</button><br>
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/index.html'" type="button">Back To Main Index</button>
	</body>
</html>