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

<h1> Meters To Feet</h1>
	<form action="meterToFeet.php" method="POST">
		<fieldset>
			<legend>Convert Meters To Feet: 1m = 3.28084ft</legend>
			<p><strong>Enter number of Meters: </strong><input type="text" name="meters" value="<?php echo $meterConversion?>">
			<input type="submit" value="Convert Now!"></p>
		</fieldset>
	</form>

		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage1/index.php'" type="button">Back To Conversion</button><br>
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/index.html'" type="button">Back To Main Index</button>
	</body>
</html>