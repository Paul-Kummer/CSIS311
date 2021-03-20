<?php session_start() ?>

<!DOCTYPE PHP>

<?php
	$path = "http://puff.mnstate.edu/~cx3645kg/private/module03assign03d/index.php";
	include "functions.php";

	extract($_SESSION);
	extract($_REQUEST);

	$filePath = "testFile.txt"; //path of the test file 
	$notification = ""; //displays what is happening to user
	$_SESSION['toggleVal'] = $toggle; //determines if the source code should be displayed
	$_SESSION['data'] = $data; //data that gets inserted into the file
	$_SESSION['dispOut']; //data to be displayed to user from file operations, made persisten so code view toggles do not overwrite the view


	//reads the file and stores each line in $_SESSION['dispOut']
	if ($_REQUEST['op'] == "read")
	{
		rFile($filePath, $_SESSION['dispOut']);
		$notification = "-File Read-";
	}

	//writes the file info from $_SESSION['data'] and then calls rFile()
	elseif ($_REQUEST['op'] == "write")
	{
		wFile($filePath, $_SESSION['data'], $_SESSION['dispOut']);
		$notification = "-File Wrote-";
	}

	//appends the file info from $_SESSION['data'] and then calls rFile()
	elseif ($_REQUEST['op'] == "append")
	{
		aFile($filePath, $_SESSION['data'], $_SESSION['dispOut']);
		$notification = "-File Appended-";
	}

	//check if the show code buttons clicked
	else
	{
		//initialize values
		if(!$_SESSION['toggleVal'])
		{
			$notification = "-Ready To Start-";
			$_SESSION['dispOut'] = '';
		}
	}


	//shows index code
	if ($_SESSION['toggleVal'] == "Show index Code")
	{
		ToggleBool($_SESSION['showIndexPHP']);
		$notification = "-Toggled Index Code View-";
	}

	//show functions code
	if($_SESSION['toggleVal'] == "Show functions Code")
	{
		ToggleBool($_SESSION['showFunctionsPHP']);
		$notification = "-Toggled Functions Code View-";
	}
?>

<html>
   <head>
	  <title>Test Read/Write/Append</title>
	  <link rel="stylesheet" type="text/css" href="http://puff.mnstate.edu/~cx3645kg/private/module03assign03d/assign3d.css">
   </head>

   <div class="header">
		<h2>
			<?php
				echo $notification;
			?>
		</h2>
	</div>

   <body>
	   
	<div class="selectBox">
		<form action=<?php echo $path?> method="POST">
			<label for="op">Select an operation:</label>
			<select name="op" id="opSelect">
				<option value="Select" selected disabled hidden>Select</option>
				<option value="read">Read</option>
				<option value="write">Write</option>
				<option value="append">Append</option>
			</select>
			<label>testText.txt is used for operations</label>
			<br><label>Text for operation selected (if applicable)</label>
			<textarea id="textField" name="data"></textarea>
			<br><br><input type="submit" class="button" name="Submit" value="Submit">
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
		<div class="columnHistory"> <!-- this will be the output of the files -->
			<h1>File Output</h1>
			<p>
				<?php
					echo $_SESSION['dispOut'];
				?>
			</p>
		</div>
	</div>
   </body>
</html>

<?php
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
