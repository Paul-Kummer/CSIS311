
<!DOCTYPE PHP>

<?php
$path = "http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage5/index.php";
include "functions.php";
extract($_REQUEST);
$meterToFeet = $meters;
$feetToMeter = $feet;
$conversion = "";
$toggleVal = $toggle;
$showIndexPHP = $persistIndexView;
$showFunctionsPHP = $persistFuncView;
$multiDimArray = $twoDimArray;
$numOfConversion = $count;

if($removeHist)
{
	$removeHist--;
	unset($multiDimArray[$removeHist]);

}

if ($History)
{
	$History--; // php kept evaluating 0 as false, so the index has to be decremented after it was incremented
	$conversion = $multiDimArray[$History]["conversionString"]; 
	$feetToMeter = $multiDimArray[$History]["numFeet"];
	$meterToFeet = $multiDimArray[$History]["numMeters"]; 
}

else
{
	if ($convertButton == "Convert Meters!")
	{
		$feetToMeter = ConvertMeterToFeet($meterToFeet); // This is feet
		$conversion = $meterToFeet . " Meters = " . $feetToMeter . " Feet" . " ( Number of Conversions: ". ($numOfConversion + 1) . ")";
		DataToArray($conversion, $feetToMeter, $meterToFeet, $numOfConversion, $multiDimArray);
	}

	elseif($convertButton == "Convert Feet!")
	{
		$meterToFeet = ConvertFeetToMeter($feetToMeter); // This is meters
		$conversion = $feetToMeter . " Feet = " . $meterToFeet . " Meters" . " ( Number of Conversions: ". ($numOfConversion + 1) . ")";
		DataToArray($conversion, $feetToMeter, $meterToFeet, $numOfConversion, $multiDimArray);
		
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
	}
}



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
	  <link rel="stylesheet" type="text/css" href="http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage5/conversion.css">
   </head>

   <div class="header">
		<h2>
			<?php
				echo $conversion;
			?>
		</h2>
	</div>

   <body>
	   
	<div class="convertColumn">
		<form action=<?php echo $path?> method="POST">
			<fieldset>
				<legend>Conversions: 1m = 3.28084ft || 1ft = 0.3048m</legend>
				<p><strong>Meters: </strong><input type="text" name="meters" value="<?php echo $meterToFeet;?>">
				<input type="submit" name="convertButton" value="Convert Meters!"></p>
				<p><strong>Feet: </strong><input type="text" name="feet" value="<?php echo $feetToMeter;?>">
				<input type="submit" name="convertButton" value="Convert Feet!"></p>
				<p><label>User Must Click Button Otherwise Convert Meters is Selected</label></p>
				<?php PassData($multiDimArray, $numOfConversion, $showIndexPHP, $showFunctionsPHP) ?>
			</fieldset>
		</form>

		<div class="navLinks">
			<form action=<?php echo $path?> method="POST">
				<button type="navButton" formaction="http://puff.mnstate.edu/~cx3645kg/private/index.html">Main Index</button>
				<input type="submit" class="button" name="toggle" value="Show index Code">
				<input type="submit" class="button" name="toggle" value="Show functions Code">
				<input type="hidden" name="meters" value =<?php echo $meterToFeet?>>
				<input type="hidden" name="feet" value =<?php echo $feetToMeter?>>
				<?php PassData($multiDimArray, $numOfConversion, $showIndexPHP, $showFunctionsPHP) ?>
			</form>
		</div>
		
	</div>



	<div class="row">
		<div class="columnHistory">
			<h1>Conversion History</h1>
			<form action=<?php echo $path?> method="POST">
				<?php
					if(!empty($multiDimArray))
					{
						ButtonizeHistory($multiDimArray);
						PassData($multiDimArray, $numOfConversion, $showIndexPHP, $showFunctionsPHP);
					}
				?>
			</form>
		</div>
	</div>
	


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
