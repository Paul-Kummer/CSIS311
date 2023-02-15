<?php
	include "cardClass.php";
	include "playerClass.php";
	session_start();
	include "functions.php";
	include "cardFunctions.php";
	include "dbFunctions.php";
	include "forms.php";
?>

<!DOCTYPE PHP>

<?php
	extract($_SESSION);
	extract($_REQUEST);

	$_SESSION['uName'] = $uName;
	$_SESSION['uPass'] = $uPass;
	$_SESSION['dispOut'] = "<tb>RULES and DATABASE INFORMATION is ouput here"; //data that gets outputed from query results
	$_SESSION['toggleVal'] = $toggle; //switches showing the source code
	$_SESSION['Submit'] = $Submit; //value of submit button pressed
	$_SESSION['playCard'] = $_REQUEST['playCard'];
	$_SESSION['Start'] = $Start; 
	$noCardPlay = true;
	$noToggle = false; //test if there was a toggle button pressed
	$noSubmit = false; //test if there was a submit button pressed
	$notification; //text to display what is happening to user
	$styleSheet = "http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/assign5a.css";
	$nullValue = null;
	$rules = "";
	$deckDraw = "deckDraw";
	$path = "http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/index.php";
			

	//ensure all variables have been enstantiated properly and the game can start
	if($_SESSION['Start'] == 'Start')
	{	
		//players exist and it is the humans turn
		if(isset($_SESSION['playerTurn']) && !$_SESSION['playerTurn']->isPC() && !playerWin($_SESSION['players'][0]))
		{
			//only human submits a play card, a deck draw should always be able to be played
			if(isset($_SESSION['playCard'])) //at this point, playCard should be the index of the card in the players hand
			{
				//the human draws a card from the deck
				if($_SESSION['playCard'] == $deckDraw)
				{
					//play a null card, causing cards to be added to hand
					playACard($_SESSION['playerTun'], $deckDraw);

					//send the turn to the db
					$paramString = "'".$_SESSION['gameID']."','".$_SESSION['turnNumber']."','".$_SESSION['uID']."','Deck Draw', null, null";
					executeSP($_SESSION['dispOut'], "addTurn", $paramString);

					//change players
					$_SESSION['playerTurn'] = $_SESSION['players'][0];

					//increment turn number
					$_SESSION['turnNumber']++;

					//prevent resubmission of a playcard
					$_SESSION['playCard'] = null;
					$_SESSION['playSpecial'] = false; //end special turn on deck draw;
				}

				//the human played a card from their hand
				elseif(intval($_SESSION['playCard']) < 32) //it's impossible to have 32 cards in your hand without losing
				{
					//convert the index number into the card object in the players hand
					$theCardIndex = intval($_SESSION['playCard']);
					$thePlayer = $_SESSION['players'][1];
					$theHand = $thePlayer->getHand();
					$theCard = $theHand[$theCardIndex];

					$validCardPlayed = playACard($_SESSION['players'][1], $theCard);

					//if the player played a valid card
					if($validCardPlayed) //if true, the play card is now curcard
					{
						//send the turn to the db
						$paramString = "'".$_SESSION['gameID']."','".$_SESSION['turnNumber']."','".$_SESSION['uID']."','".$_SESSION['curCard']->printCard()."','".$_SESSION['curCard']->getSuit()."','".$_SESSION['curCard']->getValue()."'";
						executeSP($_SESSION['dispOut'], "addTurn", $paramString);

						//check if the player played their last card
						if(!playerWin($_SESSION['players'][1]))
						{
	
							//change to the next player
							$nextPlayerIndex = array_search($_SESSION['players'][1], $_SESSION['players'])%2==0?1:0;
							$_SESSION['playerTurn'] = $_SESSION['players'][$nextPlayerIndex];
							$_SESSION['turnNumber']++;
							
							$_SESSION['playCard'] = null;
						}
	
						//the player won
						else
						{
							$_SESSION['endGame'] = true;

							//the human won the game
							$_SESSION['form'] = getForm("winForm");

							//save player loss to db
							executeSP($nullValue, "endGame", "'".$_SESSION['gameID']."','1'");
						}
					}
	
					else
					{
						$notification = "-An invalid card was selected-";
						$_SESSION['playCard'] = null;
					}
				}

				else
				{
					$notification = "-I don't know what happend-";
					$_SESSION['form'] = getForm("gameForm");
					$_SESSION['playCard'] = null;
				}
			}

			//no card selected
			else
			{
				$notification = "-Your Turn, select a card-";
			}
		}

		else
		{
			if($_SESSION['endGame'])
			{
				$notification = "-The Game Has Ended-";
	
				//reset the session variables
				resetGame();
			}
		}

		//it is the computers turn, should happen immediatly after the human unless they pick a bad card
		if(isset($_SESSION['players']) && $_SESSION['playerTurn']->isPC() && !playerWin($_SESSION['players'][1]))
		{
			//computer selects a card
			$pcCard = pcSelectCard();
			$validCardPlayed = playACard($_SESSION['players'][0], $pcCard); //this is true even with a deck draw, which has no access methods

			//computer plays a card
			if($validCardPlayed && ($pcCard != "deckDraw"))
			{
				//send the turn to the db
				$paramString = "'".$_SESSION['gameID']."','".$_SESSION['turnNumber']."','1','".$_SESSION['curCard']->printCard()."','".$_SESSION['curCard']->getSuit()."','".$_SESSION['curCard']->getValue()."'";
				executeSP($_SESSION['dispOut'], "addTurn", $paramString);

				//the computer doesn't play their last card
				if(!playerWin($_SESSION['playerTurn']))
				{
					//say what the computer played
					$notification = "-".$_SESSION['players'][0]->getName()." Played the ". $pcCard->printCard()."-";

					//change to the next player
					//$nextPlayerIndex = array_search($_SESSION['players'][0], $_SESSION['players'])%2==0?1:0;
					$_SESSION['playerTurn'] = $_SESSION['players'][1];

					//increment the turn
					$_SESSION['turnNumber']++;

					//load the game form for the next play
					$_SESSION['form'] = getForm("gameForm");
				}

				//the computer won, player lost
				else
				{
					$_SESSION['endGame'] = true;

					//load the lose page
					$_SESSION['form'] = getForm("loseForm");

					//save player loss to db
					executeSP($nullValue, "endGame", "'".$_SESSION['gameID']."','0'");

					//execute reset
					resetGame();
				}
			}

			elseif($validCardPlayed && ($pcCard == "deckDraw"))
			{
				//change player turn
				$_SESSION['playerTurn'] = $_SESSION['players'][1];

				//send the turn to the db
				$paramString = "'".$_SESSION['gameID']."','".$_SESSION['turnNumber']."','1','Deck Draw', null, null";
				executeSP($_SESSION['dispOut'], "addTurn", $paramString);

				//output
				$notification = "-".$_SESSION['players'][0]->getName()." drew from the deck-";
				$_SESSION['form'] = getForm("gameForm");
			}
			
			//computer played an invalid card, or has to draw
			else
			{
				//change the player turn
				$nextPlayerIndex = array_search($_SESSION['playersTurn'], $_SESSION['players'])%2==0?1:0;
				$_SESSION['playerTurn'] = $_SESSION['players'][$nextPlayerIndex];

				//send the turn to the db
				$paramString = "'".$_SESSION['gameID']."','".$_SESSION['turnNumber']."','1','Unknown','null','null'";
				executeSP($_SESSION['dispOut'], "addTurn", $paramString);

				//output
				$notification = "-".$_SESSION['players'][0]->getName()." couldn't pick a card and didn't play-";
				$_SESSION['form'] = getForm("gameForm");
			}
		}

		//start of game, or something went wrong
		else
		{
			if($_SESSION['endGame'])
			{
				$notification = "-The Game Has Ended-";
	
				//reset the session variables
				resetGame();
			}

			else
			{
				$_SESSION['form'] = getForm("gameForm");
			}
		}



		unset($_SESSION['playCard']); //reset the human selection to prevent accidental card play
		$noCardPlay = false;
	}












	//
	switch ($_SESSION['Submit'])
	{
		//
		case "resumeGame":
			if(empty($_SESSION['players']))
			{
				newGame();
				$notification = "-No Game Found, Starting New Game-";
				executeSP($nullValue, "startGame", "'".$_SESSION['uID']."'");
			}

			else
			{
				$notification = "-Resuming Last Game From Stored Session-";
			}
			
			$_SESSION['form'] = getForm("gameForm");
			$_SESSION['Submit'] = null;
			executeSP($_SESSION['gameID'], "getGameID", "'".$_SESSION['uID']."'");
			
		break;

		//
		case "newGame":
			$notification = "-New Game Started-";
			newGame();
			$_SESSION['form'] = getForm("gameForm");
			$_SESSION['Submit'] = null;

			$paramString = 
			//calls to the db
			executeSP($nullValue, "startGame", "'".$_SESSION['uID']."'");
			executeSP($_SESSION['gameID'], "getGameID", "'".$_SESSION['uID']."'");
			
		break;
			
		//verify the crediential were good or else bring back to login screen
		case "Login":
			$validPass = validatePass($_SESSION['uName'], $_SESSION['uPass']) == "1"?true:false;
			if($validPass)
			{
				$notification = "-Select an Option-";
				$_SESSION['form'] = getForm('userOptions');

				//get the user id from the db
				executeSP($_SESSION['uID'], "getUserID", "'".$_SESSION['uName']."'");
			}

			else
			{
				$notification = "-Invalid Password, Try Again-";
				$_SESSION['form'] = getForm('loginForm');
			}
		break;

		//User attempts to make a new user, Now passwords must be validated
		case "Create":

			if($_REQUEST['uPass'] == $_REQUEST['uPassTwo'])
			{
				$notification = "-Creating New User-";
				$paramString = '"'.$_SESSION['uName'].'","'.$_REQUEST['uPass'].'"';

				//add user to the db
				executeSP($notification, "newUser", $paramString);

				$_SESSION['form'] = getForm('loginForm');
			}

			//else, say password mismatch and keep on page
			else
			{
				$notification = "-Passwords do not match, try again-";
				$_SESSION['form'] = getForm('createUserForm');
			}
		break;

		//User want to make a new user and must enter username and password
		case "Create New User":
			$notification = "-Create a New User-";
			$_SESSION['form'] = getForm("createUserForm");	
		break;

		//clear the session and start a new session
		case "Logout & Reset":
			session_Destroy();
			$notification = "-Logged Out & Reset-";
			$_SESSION['form'] = getForm("loginForm");
			
		break;

		//
		default:
			$noSubmit = true;
		break;
	}
	
	//check for toggling views and switch bool if selected
	switch ($_SESSION['toggleVal'])
	{
		case "Show Code":
			$notification = "-Toggle Source Code View-";
			ToggleBool($_SESSION['showCode']);
		break;

		case "Show Rules":
			$notification = "-Showing Game Rules-";
			ToggleBool($_SESSION['showRules']);	
		break;

		default:
			$noToggle = true;
		break;
	}

	//no form was generated or button clicked. default values
	if($noToggle && $noSubmit && $noCardPlay)
	{
		$notification = "-Ready To Start-";
		$_SESSION['form'] = getForm("loginForm");
	}

	//show the rules
	if ($_SESSION['showRules'])
	{
		$rules = "".getForm("showRules")."";
	}

	executeSP($_SESSION['gameID'], "getGameID", "'".$_SESSION['uID']."'");
	executeSP($_SESSION['dispOut'], "showCurGame", "'".$_SESSION['gameID']."'");

?>



<html>
   <head>
	  <title>Şeptică: Card Game</title>
	  <link rel="stylesheet" type="text/css" href=<?php echo $styleSheet ?>>
   </head>

	<!-- this is where the notifications go -->
   <div class="header">
		<h2>
			<?php
				echo $notification;
			?>
		</h2>
	</div>

   <body>

		<!-- this is where the generated forms go -->
		<div class="row">
			<div class="selectBox">

				<?php
					echo $_SESSION['form'];
				?>

			</div>
		</div>

		<!-- this where the nav links go -->
		<div class="row">
			<div class="navLinks">
				<form action=<?php echo $path?> method="POST">
					<button type="navButton" formaction="http://puff.mnstate.edu/~cx3645kg/private/index.html">Main Index</button>
					<input type="submit" class="button" name="toggle" value="Show Rules">
					<input type="submit" class="button" name="toggle" value="Show Code">
					<input type="submit" class="button" name="Submit" value="Logout & Reset">
				</form>
			</div>
		</div>

		<!-- this is where database output goes -->
		<div class="row">
			<div class="columnHistory"> 
				<h1>Playing History</h1>
				<table id="ROUTE">
					<?php
						echo $rules."<br><br>";
						echo $_SESSION['dispOut'];
					?>
				</table>
			</div>
		</div>

   </body>
</html>

<?php
	//show the user the index code or functions code when toggled
	if ($_SESSION['showCode'])
	{
		echo "<HR>";
		highlight_file("index.php");
		echo "<HR>";
		highlight_file("forms.php");
		echo "<HR>";
		highlight_file("functions.php");
		echo "<HR>";
		highlight_file("cardFunctions.php");
		echo "<HR>";
		highlight_file("dbFunctions.php");
		echo "<HR>";
		highlight_file("playerClass.php");
		echo "<HR>";
		highlight_file("cardClass.php");
		echo "<HR>";
		highlight_file("assign5a.css");
	}




/*
		[SOURCES]
	Public Domain Playing Cards
*https://tekeye.uk/playing_cards/svg-playing-cards
?>