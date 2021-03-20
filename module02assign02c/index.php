
<!DOCTYPE php>

<html>
	<head>
		<title>Date Functions</title>
	</head>
	<body>
		<h1> Date Stuff </h1>
		<P>
			<?php
			$today = date("l, F jS, Y, g A");
			$a = 3;
			$b = 4;

			printDate($today);
			printAdd($a, $b)

			function printDate($newDate)
			{
				echo "Today's Day is: $newDate <br>";
			};

			function printAdd($a, $b)
			{
				echo "a + b = " . ($a+$b);
			};
			?>
		</p>
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/moduleTwo/assign2c/index.html'" type="button">Back To Date Index</button><br>
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/index.html'" type="button">Back To Main Index</button>
	</body>
</html>