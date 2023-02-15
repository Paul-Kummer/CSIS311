<?php
	function outputDBToTable(&$outString, $result)
	{
		//create rows to be outputted into a table
		//concatenate the field names
		$outString .= '<table id="ROUTE"><tr>';
		while ($field = mysqli_fetch_field($result))
		{
			$outString = $outString . '<th>' . $field->name . '</th>';
		}
		$outString .=  '</tr>';
		
		//concatenate the data
		while ($row = mysqli_fetch_assoc($result))
		{
			$outString .= '<tr>';
			foreach ($row as $col=>$val)
			{
				$outString =  $outString . '<td>' . $val . '</td>';
			}
			$outString .= '</tr>';
		}
		$outString .= '</table>';
	}

	function executeSP(&$outString, $storedProcedure, $parameter)
	{
		include "dbInfo.php";

		$conn = mysqli_connect("localhost",$username,$password,$dbname);
		$sql = '';
		$outString = '';

		//problem with the database connection occured
		if ($conn->connect_error) 
		{
			$_SESSION['dispOut'] = "!!! ERROR !!!";
			die("!!! Connection failed: " . $conn->connect_error . "!!!");
		}

		//successfully connected to database
		else
		{
			switch ($storedProcedure)
			{
				//used to check if code is getting to a breakpoint
				case "test":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
				break;

				//peform a custom query using param input
				case "addTurn":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
				break;

				case "newUser":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
				break;

				case "startGame":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
				break;

				case "endGame":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
				break;

				case "getUserID":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_row($result);
					$outString =  $row[0];
				break;

				case "getGameID":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_row($result);
					$outString =  $row[0];
				break;

				case "showCurGame":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
					outputDBToTable($outString, $result);
				break;

				//check if the password is valid
				case "validPassword":
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_row($result);
					$outString =  $row[0];
				break;

				//call the stored procedure with parameter
				default:
					$sql = "call $storedProcedure($parameter);";
					$result = mysqli_query($conn,$sql);
					outputDBToTable($outString, $result);
				break;
			}
		}
		$conn->close();
	}

	function validatePass($user, $uPassword)
	{
		include "dbInfo.php";

		$conn = mysqli_connect("localhost",$username,$password,$dbname);
		$table = 'USER';
		$sql = 'call validPass("'.$user.'","'.$uPassword.'");';

		//problem with the database connection occured
		if ($conn->connect_error) 
		{
			$_SESSION['dispOut'] = "!!! ERROR !!!";
			die("!!! Connection failed: " . $conn->connect_error . "!!!");
		}

		//successfully connected to database
		else
		{
			$result = mysqli_query($conn,$sql);
			$row = mysqli_fetch_row($result);
			$outString =  $row[0];
		}

		return $outString;
	}
?>