<?php
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

	function rFile($filePath, &$outputStr)
	{
		if (!empty($filePath))
		{
			$curFile = fopen($filePath, "r") or die ($outputStr = "-Unable to read the file selected- : " . $filePath);
			while(!feof($curFile))
			{
				$outputStr .= fgets($curFile) . "<br>";
			}
			fclose($curFile);
		}
		
		else
		{
			$outputStr = "- The File Is Empty -";
		}
	}

	function wFile($filePath, $dataToWrite, &$outputStr)
	{
		$curFile = fopen($filePath, "w") or die ($outputStr = "-Unable to write to the file selected- : " . $filePath);
		fwrite($curFile, $dataToWrite);
		fclose($curFile);
		rFile($filePath, $outputStr);
	}

	function aFile($filePath, $dataToAppend, &$outputStr)
	{
		$curFile = fopen($filePath, "a") or die ($outputStr = "-Unable to append to the file selected- : " . $filePath);
		fwrite($curFile, $dataToAppend);
		fclose($curFile);
		rFile($filePath, $outputStr);
	}

?>