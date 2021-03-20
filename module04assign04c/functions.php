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

	function executeSP(&$outString, $storedProcedure, $parameter)
	{
		//php file that stores connection info and passwords, stored seperatley so the views don't expose my password
		include "dbInfo.php";

		$conn = mysqli_connect("localhost",$username,$password,$dbname);
		$sql = '';
		$outString = '';

		//problem with the database connection occured
		if ($conn->connect_error) 
		{
			$outString = "!!! ERROR !!!";
			die("!!! Connection failed: " . $conn->connect_error . "!!!");
		}

		//successfully connected to database
		else
		{
			//peform a custom query using param input
			if ($storedProcedure == "writeQuery")
			{
				$sql = $parameter;
			}
			
			//show everything in the table
			else if($storedProcedure == "viewAll")
			{
				$sql = "select * from ROUTE;";
			}
			
			//call stored procedures with param input
			else
			{
				$sql = "call $storedProcedure($parameter);";
			}
	
			$result = mysqli_query($conn,$sql);
		}

		//create rows to be outputted into a table
		//concatenate the field names
		$outString .= '<tr>';
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
		$conn->close();
	}
?>