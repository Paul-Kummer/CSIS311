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
		};
	};

	function DataToArray($conversion, $feetToMeter, $meterToFeet, &$numOfConversion, &$multiDimArr)
	{
		$dateAtom = date(DATE_ATOM);
		if(empty($numOfConversion))
		{
			$numOfConversion = 0;
		}
		
		$multiDimArr[$numOfConversion] = array($dateAtom, $conversion, $feetToMeter, $meterToFeet, $numOfConversion);
		$numOfConversion++;
	};

	function PassData($twoDimArray, $numOfConversions, $showIndexPHP, $showFunctionsPHP)
	{
		foreach ($twoDimArray as $key1 => $value1) 
		{
			foreach ($value1 as $key2 => $value2) 
			{
				echo <<< HERE
					<input type="hidden" name="twoDimArray[$key1][$key2]" value="$value2">
HERE;
			};
		};

		echo <<< HERE
			<input type="hidden" name="count" value= "$numOfConversions">
			<input type="hidden" name="persistIndexView" value= $showIndexPHP>
			<input type="hidden" name="persistFuncView" value = $showFunctionsPHP>
HERE;
	}
?>