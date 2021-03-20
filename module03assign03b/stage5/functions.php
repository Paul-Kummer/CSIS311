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
		
		$multiDimArr[$numOfConversion] = array(
			"convertDate" => $dateAtom, 
			"conversionString" => $conversion, 
			"numFeet" => $feetToMeter, 
			"numMeters" => $meterToFeet, 
			"numConversions" => $numOfConversion);

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

	function ButtonizeHistory($mdaHist)
	{
		$numOfButtons = 0;

		foreach ($mdaHist as $key => $value) 
		{
			$key++; // must be incremented, otherwise it will evaluate false
			$buttonName = $value["conversionString"];
			$convertTime = $value["convertDate"];
			if ($numOfButtons % 1 == 0)
			{
				echo "<br>";
			}
			
			echo <<< HERE
				<label for="$key">$convertTime</label>
				<button type="submit" name="History" value='$key'>$buttonName</button>
				<button type="submit" name="removeHist" value='$key'>Remove</button>
HERE;
			$numOfButtons++;
		}
	}
?>