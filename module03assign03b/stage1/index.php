<!DOCTYPE php>

<?php

?>

<html>
   <head>
      <title>Unit Conversion</title>
   </head>
   <body>
	<h1> Meters To Feet</h1>
	<form action="http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage1/meterToFeet.php" method="POST">
		<fieldset>
			<legend>Convert Meters To Feet: 1m = 3.28084ft</legend>
			<p><strong>Enter number of Meters: </strong><input type="text" name="meters">
			<input type="submit" value="Convert Now!"></p>
		</fieldset>
	</form><br><br>

	<h1> Feet To Meters</h1>
	<form action="http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage1/feetToMeter.php" method="POST">
		<fieldset>
			<legend>Convert Meters To Feet: 1ft = 0.3048m</legend>
			<p><strong>Enter number of Feet: </strong><input type="text" name="feet">
			<input type="submit" value="Convert Now!"></p>
		</fieldset>
	</form>
	<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/index.html'" type="button">Back To Main Index</button>
   </body>
</html>
