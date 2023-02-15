<?php
	function ToggleBool(&$boolVal)
	{
		$boolVal = $boolVal?false:true;
	}

	function newGame()
	{
		$computerNames = array("Alan Turing", "Bill Gates", "Hedy Lamarr", "Tim Berners-Lee", "Brendan Eich", "Mark Zuckerburg", "Guido Van Rassum", "Carl Sassenrath", "Larry Page", "Elon Musk", "Barbara Liskov");

		shuffle($computerNames);
		$PC = new Player($computerNames[0]);
		$User = new Player($_SESSION['uName'], $_SESSION['uID'], false);
		$mainDeck = createDeck();
		$_SESSION['players'] = array($PC, $User);

		$_SESSION['mainDeck'] = $mainDeck;
		foreach($_SESSION['players'] as $player)
		{
			dealCards($_SESSION['mainDeck'], $player, (int)5);
		}

		$_SESSION['playerTurn'] = $_SESSION['players'][rand(0,1)];
		$_SESSION['curCard'] = array_pop($_SESSION['mainDeck']);
		$_SESSION['curCard']->showCard();

		$_SESSION['turnNumber'] = 0;
		$_SESSION['Start'] = "";
	}

	function playerWin(&$tmpPlayer)
	{
		if(count($tmpPlayer->getHand()) <= 0)
		{
			return true;
		}

		else
		{
			return false;
		}
	}

	function resetGame()
	{
		$_SESSION['gameID'] = null;
		$_SESSION['endGame'] = false;
		$_SESSION['playerTurn'] = null;
		$_SESSION['curCard'] = null;
		$_SESSION['playSpecial'] = false;
		$_SESSION['changeSuits'] = false;
		$_SESSION['skipPlayer'] = false;
		$_SESSION['cardsToAdd'] = 0;
		$_SESSION['turnNumber'] = 0;
		$_SESSION['Start'] = "";
		$_SESSION['players'] = null;
		$_SESSION['mainDeck'] = null;
		$_SESSION['playedCards'] = null;
	}
?>