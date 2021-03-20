<?php
function ConvertMeterToFeet ($meterConvert)
{
	$feetConversion = $meterConvert * 3.28084;
	return $feetConversion;
};

function ConvertFeetToMeter ($feetConvert)
{
	$meterConversion = $feetConvert / 3.28084;
	return $meterConversion;
};

function ToggleBool(&$boolVal)
{
	if($boolVal)
	{
		$boolVal = false;
	}

	else
	{
		$boolVal = true;
	}
};
?>
