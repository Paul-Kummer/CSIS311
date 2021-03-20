<!DOCTYPE php>

<?php
include "functions.php";
extract($_REQUEST);
$meterToFeet = $meters;
$feetToMeter = $feet;
$conversion = "";
$toggleVal = $toggle;
$showIndexPHP = $persistIndexView;
$showFunctionsPHP = $persistFuncView;

if ($convertButton == "Convert Meters Now!")
{
	$feetToMeter = ConvertMeterToFeet($meterToFeet);
	$conversion = $meterToFeet . " Meters = " . $feetToMeter . " Feet";
}

elseif($convertButton == "Convert Feet Now!")
{
	$meterToFeet = ConvertFeetToMeter($feetToMeter);
	$conversion = $feetToMeter . " Feet = " . $meterToFeet . " Meters";
}

else
{
	if(!$toggleVal)
	{
		$meterToFeet = 0;
		$feetToMeter = 0;
		$conversion = "No Conversion Done Yet";
	}

	else
	{
		$conversion = "-" . $toggleVal . "-";
	};
};

if ($toggleVal == "Show index Code")
{
	ToggleBool($showIndexPHP);
}

elseif($toggleVal == "Show functions Code")
{
	ToggleBool($showFunctionsPHP);
}

else
{
	$showIndexPHP = false;
	$showFunctionsPHP = false;
};
?>

<html>
   <head>
      <title>Unit Conversion</title>
   </head>
	<h2>
		<?php
			echo $conversion;
		?>
	</h2>
   <body>
	<h1> Meters To Feet</h1>
	<form action="http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage2/index.php" method="POST">
		<fieldset>
			<legend>Convert Meters To Feet: 1m = 3.28084ft</legend>
			<p><strong>Enter number of Meters: </strong><input type="text" name="meters" value="<?php echo $meterToFeet;?>">
			<input type="submit" name="convertButton" value="Convert Meters Now!"></p>
		</fieldset>
	</form><br><br>

	<h1> Feet To Meters</h1>
	<form action="http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage2/index.php" method="POST">
		<fieldset>
			<legend>Convert Meters To Feet: 1ft = 0.3048m</legend>
			<p><strong>Enter number of Feet: </strong><input type="text" name="feet" value="<?php echo $feetToMeter;?>">
			<input type="submit" name="convertButton" value="Convert Feet Now!"></p>
		</fieldset>
	</form>
	
	<form action="index.php" method="POST">
		<button onclick="location.href='http://puff.mnstate.edu/~cx3645kg/private/index.html'" type="button">Back To Main Index</button>
		<input type="submit" class="button" name="toggle" value="Show index Code">
		<input type="submit" class="button" name="toggle" value="Show functions Code">
		<input type="hidden" name="persistIndexView" value=<?php echo $showIndexPHP?>>
		<input type="hidden" name="persistFuncView" value =<?php echo $showFunctionsPHP?>>
		<input type="hidden" name="meters" value =<?php echo $meterToFeet?>>
		<input type="hidden" name="feet" value =<?php echo $feetToMeter?>>
	</form>
   </body>
</html>

<?php
	if ($showIndexPHP)
	{
		echo "<HR>";
		highlight_file("index.php");
	};

	if($showFunctionsPHP)
	{
		echo "<HR>";
		highlight_file("functions.php");
	};

?>
