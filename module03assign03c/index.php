<?php session_start() ?>

<!DOCTYPE PHP>

<?php
$path = "http://puff.mnstate.edu/~cx3645kg/private/module03assign03b/stage5/index.php";
include "functions.php";

extract($_SESSION);
extract($_REQUEST);
$_SESSION['meterToFeet'] = $meters;
$_SESSION['feetToMeter'] = $feet;
$_SESSION['conversion'] = "";
$_SESSION['toggleVal'] = $toggle;
$_SESSION['showIndexPHP'] = $persistIndexView;
$_SESSION['showFunctionsPHP'] = $persistFuncView;
$_SESSION['multiDimArray'];
$_SESSION['numOfConversion'] = 0;

if($removeHist) // delete a previous conversion from history
{
	$removeHist--;
	unset($_SESSION['multiDimArray'][$removeHist]);

}

if ($History) // put values in from previous conversion
{
	$History--; // php kept evaluating 0 as false, so the index has to be decremented after it was incremented
	$_SESSION['conversion'] = $_SESSION['multiDimArray'][$History]["conversionString"]; 
	$_SESSION['feetToMeter'] = $_SESSION['multiDimArray'][$History]["numFeet"];
	$_SESSION['meterToFeet'] = $_SESSION['multiDimArray'][$History]["numMeters"]; 
}

else
{
	if ($convertButton == "Convert Meters!")
	{
		$_SESSION['feetToMeter'] = ConvertMeterToFeet($_SESSION['meterToFeet']); // This is feet
		$_SESSION['conversion'] = $_SESSION['meterToFeet'] . " Meters = " . $_SESSION['feetToMeter'] . " Feet" . " ( Number of Conversions: ". ($_SESSION['numOfConversion'] + 1) . ")";
		DataToArray($_SESSION['conversion'], $_SESSION['feetToMeter'], $_SESSION['meterToFeet'], $_SESSION['numOfConversion'], $_SESSION['multiDimArray']);
	}

	elseif($convertButton == "Convert Feet!")
	{
		$_SESSION['meterToFeet'] = ConvertFeetToMeter($_SESSION['feetToMeter']); // This is meters
		$conversion = $feetToMeter . " Feet = " . $_SESSION['feetToMeter'] . " Meters" . " ( Number of Conversions: ". ($_SESSION['numOfConversion'] + 1) . ")";
		DataToArray($_SESSION['conversion'], $_SESSION['feetToMeter'], $_SESSION['meterToFeet'], $_SESSION['numOfConversion'], $_SESSION['multiDimArray']);
		
	}

	else
	{
		if(!$_SESSION['toggleVal'])
		{
			$_SESSION['meterToFeet'] = 0;
			$_SESSION['feetToMeter'] = 0;
			$_SESSION['conversion'] = "No Conversion Done Yet";
		}

		else
		{
			$_SESSION['conversion'] = "-" . $_SESSION['toggleVal'] . "-";
		};
	}
}



if ($_SESSION['toggleVal'] == "Show index Code")
{
	ToggleBool($_SESSION['showIndexPHP']);
}

elseif($_SESSION['toggleVal'] == "Show functions Code")
{
	ToggleBool($_SESSION['showFunctionsPHP']);
}

else
{
	$_SESSION['showIndexPHP'] = false;
	$_SESSION['showFunctionsPHP'] = false;
};
?>

<html>
   <head>
	  <title>Unit Conversion</title>
	  <link rel="stylesheet" type="text/css" href="http://puff.mnstate.edu/~cx3645kg/private/module03assign03c/conversion.css">
   </head>

   <div class="header">
		<h2>
			<?php
				echo $_SESSION['conversion'];
			?>
		</h2>
	</div>

   <body>
	   
	<div class="convertColumn">
		<form action=<?php echo $path?> method="POST">
			<fieldset>
				<legend>Conversions: 1m = 3.28084ft || 1ft = 0.3048m</legend>
				<p><strong>Meters: </strong><input type="text" name="meters" value="<?php echo $_SESSION['meterToFeet'];?>">
				<input type="submit" name="convertButton" value="Convert Meters!"></p>
				<p><strong>Feet: </strong><input type="text" name="feet" value="<?php echo $_SESSION['feetToMeter'];?>">
				<input type="submit" name="convertButton" value="Convert Feet!"></p>
				<p><label>User Must Click Button Otherwise Convert Meters is Selected</label></p>
			</fieldset>
		</form>

		<div class="navLinks">
			<form action=<?php echo $path?> method="POST">
				<button type="navButton" formaction="http://puff.mnstate.edu/~cx3645kg/private/index.html">Main Index</button>
				<input type="submit" class="button" name="toggle" value="Show index Code">
				<input type="submit" class="button" name="toggle" value="Show functions Code">
			</form>
		</div>
		
	</div>



	<div class="row">
		<div class="columnHistory">
			<h1>Conversion History</h1>
			<form action=<?php echo $path?> method="POST">
				<?php
					ButtonizeHistory($_SESSION['multiDimArray']);
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
