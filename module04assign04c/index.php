<?php session_start() ?>

<!DOCTYPE PHP>

<?php

	$path = "http://puff.mnstate.edu/~cx3645kg/private/module04assign04c/index.php";
	include "functions.php";
	extract($_SESSION);
	extract($_REQUEST);

	$_SESSION['toggleVal'] = $toggle; //switches dark mode, show index source, or show function source
	$_SESSION['data'] = $data; //holds data from custom quries
	$_SESSION['dispOut'] = "<tb>query output will go here ------>"; //data that gets outputed from query results
	$_SESSION['form'] = $defaultForm; //the form that will be displayed to the user
	$_SESSION['sp'] = $sp; //the stored procedure to be used
	$_SESSION['Submit'] = $Submit; //value of submit button pressed
	$noSP = false; //test if there was a stored procedure entered
	$noToggle = false; //test if there was a toggle button pressed
	$noSubmit = false; //test if there was a submit button pressed
	$notification = "-Ready To Start-"; //text to display what is happening to user
	//the default form on the main page
	$defaultForm = <<< HERE
	<form action=$path method="POST">
	<label for="sp">Select a stored procedure:</label>
	<select name="sp" id="spSelect">
		<option value="Select" selected disabled hidden>Select</option>
		<option value="addRoute">Add Route</option>
		<option value="delRoute">Delete Route</option>
		<option value="findRtName">Find Route By Name/ID</option>
		<option value="findRtRate">Find Route By Rating</option>
		<option value="findRtGrade">Find Route By Grade</option>
		<option value="writeQuery">Write Own Query</option>
	</select>
	<br><br><input type="submit" class="button" name="Submit" value="Submit">
	</form>
HERE;


	//generate a form based on the stored procedure selected
	switch ($_SESSION['sp'])
	{
		//form for adding a new route
		case "addRoute": 
			$_SESSION['form'] = <<< HERE
			<form action=$path method="POST">
				<label for="rtName">Route Name:</label>
				<input type="text" name="rtName" value="">
				<label for="rtClass">Class:</label>
				<input type="number" id="rtClass" name="rtClass" min="1" max="5" step="1">
				<label for="rtGrade">Grade:</label>
				<input type="number" id="rtGrade" name="rtGrade" min="0" max="15" step="1">
				<label for="rtType">Type:</label>
				<select name="rtType" id="rtType" >
					<option value="Select" selected disabled hidden>Select</option>
					<option value="Sport">Sport</option>
					<option value="Trad">Trad Route</option>
					<option value="Top Rope">Top Rope</option>
					<option value="Mixed">Mixed</option>
				</select>
				<br><label for="rtRate">Route Rating (0-4):</label>
				<input type="range" id="rtRate" name="rtRate" min="0" max="4">
				<br><br><input type="submit" class="button" name="Submit" value="Add Route">
				<input type="submit" class="button" name="Submit" value="back">
			</form>
HERE;
			$notification = "-Adding a Route-";
		break;

		//form for deleting a route
		case "delRoute":
			$_SESSION['form'] = <<< HERE
			<form action=$path method="POST">
				<label for="rtName">Route Name:</label>
				<input type="text" name="rtName" placeholder="Route Name">
				<br><br><input type="submit" class="button" name="Submit" value="Delete Route">
				<input type="submit" class="button" name="Submit" value="back">
			</form>
HERE;
			$notification = "-Deleting a Route-";
		break;

		//form for finding a route based on name or route id
		case "findRtName":
			$_SESSION['form'] = <<< HERE
			<form action=$path method="POST">
				<label for="rtName">Route Name:</label>
				<input type="text" name="rtName" placeholder="Quetico">
				<br><br><input type="submit" class="button" name="Submit" value="Find Route">
				<input type="submit" class="button" name="Submit" value="back">
				<br><br><br><label>Enter a Full/Partial Name. Nothing will select all</label>
			</form>
HERE;
			$notification = "-Get Routes By Name or ID-";
		break;

		//form for finding all routes with a specified rating
		case "findRtRate":
			$_SESSION['form'] = <<< HERE
			<form action=$path method="POST">
				<label for="rtRate">Routes At Rating:</label>
				<input type="number" name="rtRate" max="4" min="0" placeholder="between 0-4" >
				<br><br><input type="submit" class="button" name="Submit" value="Search Rating">
				<input type="submit" class="button" name="Submit" value="back">
			</form>
HERE;
			$notification = "-Get Routes By Rating-";
		break;
			
		//form for finding all routes up to a maximum grade
		case "findRtGrade":
			$_SESSION['form'] = <<< HERE
			<form action=$path method="POST">
				<label for="rtGrade">Maximum Route Grade:</label>
				<input type="number" name="rtGrade" max="15" min="0" placeholder="between 0-15" >
				<br><br><input type="submit" class="button" name="Submit" value="Search Grade">
				<input type="submit" class="button" name="Submit" value="back">
			</form>
HERE;
			$notification = "-Get Routes By Max Grade-";
		break;

		//form for writing a custom query to the database
		case "writeQuery":
			$_SESSION['form'] = <<< HERE
			<form action=$path method="POST">
				<label>Write A Custom Query (Example: SELECT * FROM ROUTE;)</label>
				<br><label>Enter Query Below</label>
				<textarea id="textField" name="data"></textarea>
				<br><br><input type="submit" class="button" name="Submit" value="Execute Query">
				<input type="submit" class="button" name="Submit" value="back">
			</form>
HERE;
			$notification = "-Custom Query-";
		break;

		//display the whole table to the database output
		case "Select":
			$notification = "-Nothing Selected-";
			$_SESSION['form'] = $defaultForm;
		break;

		//set the form to the default form and trigger the variable saying no stored procedure selected
		default:
			$_SESSION['form'] = $defaultForm;
			$notification = "-Awaiting Input-";
			$noSP = true;
		break;
	};


	//check for toggling views and switch bool if selected
	switch ($_SESSION['toggleVal'])
	{
		case "Index Code":
			ToggleBool($_SESSION['showIndexPHP']);
			$notification = "-Toggle Show Index-";
		break;

		case "Functions Code":
			ToggleBool($_SESSION['showFunctionsPHP']);
			$notification = "-Toggle Show Functions-";
		break;

		case "Dark Mode":
			ToggleBool($_SESSION['dMode']);
			$notification = "-Toggle Dark Mode-";
		break;

		default:
			$noToggle = true;
		break;
	}

	//execute quries from the stored procedure forms
	switch ($_SESSION['Submit'])
	{
		//call the stored procedure, "call getRouteByRating('number');"
		case "Search Rating":
			$paramString = "'".$_REQUEST['rtRate']."'";
			executeSP($_SESSION['dispOut'], "getRouteByRating", $paramString);
			$notification = "-Executing Route By Rating Search-";
		break;

		//call the stored procecdure, "call getRoutesAtMaxDifficulty('number');"
		case "Search Grade":
			$paramString = "'".$_REQUEST['rtGrade']."'";
			executeSP($_SESSION['dispOut'], "getRoutesAtMaxDifficulty", $paramString);
			$notification = "-Executing Route By Max Grade Search-";
		break;

		//call the stored procecdure, "call getLikeName('name/id');"
		case "Find Route":
			$tmpName = str_replace("'", "\'", $_REQUEST['rtName']);
			$paramString = "'".$tmpName."'";
			executeSP($_SESSION['dispOut'], "getLikeName", $paramString);
			$notification = "-Executing Route By Name Search-";
		break;

		//call the stored procecdure, "call deleteRoute('exact name/id');"
		case "Delete Route":
			$tmpName = str_replace("'", "\'", $_REQUEST['rtName']);
			$paramString = "'".$tmpName."'";
			executeSP($_SESSION['dispOut'], "deleteRoute", $paramString);
			executeSP($_SESSION['dispOut'], "viewAll", "null");
			$notification = "-Executing Delete Route-";
		break;

		//call the stored procecdure, "call addRoute(number,number,'name','type',number);"
		case "Add Route":
			$tmpName = str_replace("'", "\'", $_REQUEST['rtName']);
			$paramString = $_REQUEST['rtClass'].",".$_REQUEST['rtGrade'].",'".$tmpName."','".$_REQUEST['rtType']."',".$_REQUEST['rtRate'];
			executeSP($_SESSION['dispOut'], "addRoute", $paramString);
			executeSP($_SESSION['dispOut'], "viewAll", "null");
			$notification = "-Excuting Add Route-";
		break;

		//send query "data;"
		case "Execute Query":
			executeSP($_SESSION['dispOut'], "writeQuery", $_SESSION['data']);
			$notification = "-Executing Custom Query-";
		break;

		//send "select * from ROUTE;"
		case "View Table":
			executeSP($_SESSION['dispOut'], "viewAll", "null");
			$notification = "-Showing Full Table-";
		break;

		//clear the session and start a new session
		case "Clear":
			session_Destroy();
			session_start();
			$_SESSION['form'] = $defaultForm;
			$notification = "-Cleared Session, New Session Started-";
		break;

		//return to default form
		case "back":
			$notification = "-Going Back-";
			$_SESSION['form'] = $defaultForm;
		break;

		//no submit was performed
		default:
			$noSubmit = true;
		break;
	};

	//no form was generated or button clicked. default values
	if($noSP && $noToggle && $noSubmit)
	{
		$_SESSION['form'] = $defaultForm;
		$notification = "-Awaiting Input-";
	}

	//turn on dark mode if the button is clicked
	if ($_SESSION['dMode'])
	{
		$styleSheet = "http://puff.mnstate.edu/~cx3645kg/private/module04assign04c/assign4cDark.css";
	}

	else
	{
		$styleSheet = "http://puff.mnstate.edu/~cx3645kg/private/module04assign04c/assign4c.css";
	}
	
?>

<html>
   <head>
	  <title>Paul's ROUTE Database On Puff</title>
	  <link rel="stylesheet" type="text/css" href=<?php echo $styleSheet ?>>
   </head>

	<!-- this is where the action notifications go -->
   <div class="header">
		<h2>
			<?php
				echo $notification;
			?>
		</h2>
	</div>

   <body>
	   
	<!-- this is where the generated forms go -->
	<div class="selectBox">
		<?php
			echo $_SESSION['form'];
		?>

		<div class="navLinks">
			<form action=<?php echo $path?> method="POST">
				<button type="navButton" formaction="http://puff.mnstate.edu/~cx3645kg/private/index.html">Main Index</button>
				<input type="submit" class="button" name="toggle" value="Index Code">
				<input type="submit" class="button" name="toggle" value="Functions Code">
				<input type="submit" class="button" name="toggle" value="Dark Mode">
				<input type="submit" class="button" name="Submit" value="Clear">
				<input type="submit" class="button" name="Submit" value="View Table">
			</form>
		</div>
		
	</div>

	<!-- this will be the output of database goes -->
	<div class="row">
		<div class="columnHistory"> 
			<h1>Database Output</h1>
			<table id="ROUTE">
				<?php
					echo $_SESSION['dispOut'];
				?>
			</table>
		</div>
	</div>
   </body>
</html>

<?php
	//show the user the index code or functions code when toggled
	if ($_SESSION['showIndexPHP'])
	{
		echo "<HR>";
		highlight_file("index.php");
	};

	if($_SESSION['showFunctionsPHP'])
	{
		echo "<HR>";
		highlight_file("functions.php");
	};
?>