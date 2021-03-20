<!DOCTYPE php>
<!--
	This page will have a user guess a random number between 1 and 1000.
	The history of previous guesses will be stored.
-->

<?php
	extract($_REQUEST);
	$theNumber = $num;
	$guesses = $guessHist;
	$guessCount = $numGuesses;
	$output = "";

	function addGuess($toAdd, &$pastGuesses, &$guessCount)
	{
		
		if ($guessCount <= 1)
		{
			$pastGuesses = "";
		}

		$pastGuesses = strval($toAdd) . strval(" , ") . strval($pastGuesses);
		$guessCount++;
	}	

	function initializeValues(&$num, &$pastGuesses, &$guessCount)
	{
		$guessCount = 1;
		$pastGuesses = "When a guess is submitted, it will show up here. Make sure you guess between 1 and 1000!";
		$num = rand(1,1000);
	}

	function compareGuess($guess, $answer, &$output, &$pastGuesses, &$guessCount)
	{
		if($guess == $answer)
		{
			$formattedGuess = strval($guess) . ' (Correct)';
			addGuess($formattedGuess, $pastGuesses, $guessCount);
			$output = '<h1 style="color:green">You Guessed Correct!</h1>';
		}

		else
		{
			if($guess < $answer)
			{
				$formattedGuess = strval($guess) . ' (Low)';
				addGuess($formattedGuess, $pastGuesses, $guessCount);
				$output = '<h1 style="color:blue">You are too low</h1>';
			}

			if($guess > $answer)
			{
				$formattedGuess = strval($guess) . ' (High)';
				addGuess($formattedGuess, $pastGuesses, $guessCount);
				$output = '<h1 style="color:red">You are too High</h1>';
			}	
		}
	}
?>

<html>
	<head>
		<title>Random Number Game</title>
		<link rel="stylesheet" type="text/css" href="http://puff.mnstate.edu/~cx3645kg/private/module03assign03a/guessingGame.css">

	</head>
	<body>
		<div class="header">
			<h1>Random Number Game: (1-1000)</h1>
			<?php
				if($button=="Reset")
				{
					echo "<p>-Reset-</p>";
					initializeValues($theNumber, $guesses, $guessCount);
				}

				elseif($button=="Submit Guess")
				{
					echo "<p>-Guess number[".strval($guessCount)."] Entered-</p>";
					//addGuess($guess, $guesses, $guessCount);
					compareGuess($guess, $theNumber, $output, $guesses, $guessCount);
				}

				elseif($button==NULL)
				{
					echo "<p>-Initialized-</p>";
					initializeValues($theNumber, $guesses, $guessCount);	
				}

				else
				{
					echo "<p>!!! ERROR !!!</p>";
				}	
			?>
		</div>

		<div class="row">
			<div class="columnGuess">
				<form action="index.php" method="POST">		
						<input type="hidden" name="numGuesses" value = <?php echo $guessCount ?>>
						<input type="hidden" name="num" value = <?php echo $theNumber ?>>
						<input type="hidden" name="guessHist" value = "<?php echo $guesses ?>">
						<strong>Enter Guess:  </strong><input type="text" name="guess">
						<input type="submit" name="button" value="Submit Guess">
						<input type="submit" name="button" value="Reset">
				</form><br><br>

				<?php echo $output?>
			</div>

			<div class="columnHistory">
				<h1>Guesses</h1>
				<?php echo "<p class='guesses'>".$guesses."</p>";?>
			</div>
		</div>

		<div class="row">
			<div class="navLinks">
				<a href="http://puff.mnstate.edu/~cx3645kg/private/index.html">Main Index</a>
			</div>
		</div>

		<p> Programmed By: Paul Kummer </p>
	</body>
</html>

<?php
echo "<HR>";
highlight_file("index.php");
?>