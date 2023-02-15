<?php
	function createDeck()
	{
		$newDeck = array();
		$suits = array("H"=>"Hearts", 
					"D"=>"Diamonds", 
					"S"=>"Spades", 
					"C"=>"Clubs");

		$values = array("1"=>"Ace", 
					"7"=>"Seven", 
					"8"=>"Eight", 
					"9"=>"Nine", 
					"10"=>"Ten", 
					"11"=>"Jack", 
					"12"=>"Queen", 
					"13"=>"King");

		foreach($suits as $tmpSuit => $suitName)
		{
			foreach($values as $tmpVal =>$valueName)
			{
				$newDeck [] = new Card($tmpSuit, $tmpVal);
			}
		}

		shuffleCards($newDeck);
		return $newDeck;
	}

	//could just use the shuffle function for arrays
	function shuffleCards(&$cards)
	{
		$deckSize = count($cards);
		$count = 0;
		while ($count < 1000) //change this to larger number for more shuffling
		{
			$indexToMove = rand(0,$deckSize-1);
			$randomCard = $cards[$indexToMove];
			$cards[] = $randomCard;
			unset($cards[$indexToMove]);
			$cards = array_values($cards);
			$count++;
		}
	}

	function dealCards(&$mainDeck, &$player, $numOfCards)
	{
		$numOfCards = (int)$numOfCards;
		for ($x = 0; $x < $numOfCards; $x++)
		{
			$removedCard = array_pop($mainDeck);
			$player->addCard($removedCard);
		}
	}

	function placeCards(&$cardsToPlace, $unclickable=false)
	{
		$path = "http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/index.php";
		$stringOfCards = "";
		$ct = 0;

		if($unclickable)
		{
			foreach($cardsToPlace as $card)
			{
				$pathToImage = $card->getImg();
				$stringOfCards .= 	
									'<label>
										<img src="'.$pathToImage.'"></img>
									</label>';
			}
		}

		else
		{
			foreach($cardsToPlace as $card)
			{
				$pathToImage = $card->getImg();

				if($_SESSION['playerTurn']->isPC())
				{
					$stringOfCards .= 	'<form class="unplayablePlayerCards" action='.$path.' method="POST">
											<label>
												<img src="'.$pathToImage.'"></img>
											</label>
										</form>';
				}

				else
				{
					$stringOfCards .= 	'<form class="playerCards" action='.$path.' method="POST">
											<label>
												<input type="submit" value="cardSubmission">
												<img src="'.$pathToImage.'"></img>
											</label>
											<input type="hidden" name="playCard" value="'.$ct.'">
										</form>';
				}	
	
				$ct++;
			}
		}

		return $stringOfCards;
	}

	//return true if card is played, false if incorrect card played
	function playACard(&$player, &$cardToPlay) //pass by reference, NO STRINGS CAN BE PASSED THAT ARE NOT ASSIGNED TO A VARIABLE
	{
		$curCard = $_SESSION['curCard'];
		$curCardValue = $curCard->getValue();
		$curCardSuit = $curCard->getSuit();


		//the player is attempting to play a card
		if(isset($cardToPlay) && $cardToPlay != "deckDraw")
		{
			//$cardToPlay = $player->getHand()[intval($cardToPlay)]; //convert index into a card object
			$toPlayValue = $cardToPlay->getValue();
			$toPlaySuit = $cardToPlay->getSuit();

			//It is just a normal turn now, and the player has selected a card to play
			if($toPlaySuit == $curCardSuit || $toPlayValue == $curCardValue)
			{
				switchCurCard($cardToPlay, $player);

				unset($_SESSION['playCard']);
				return true;
			}
				
			else
			{
				unset($_SESSION['playCard']);
				return false;
			}
		}

		//the player played no card because they chose to pass or did not have a card to play
		elseif ($cardToPlay == "deckDraw")
		{	
			//reload the deck with played cards if the count of the main deck is less than 8
			if(count($_SESSION['mainDeck']) < 8)
			{
				$_SESSION['mainDeck'] = createDeck();
			}

			//player takes one penalty card because they didn't play a card
			dealCards($_SESSION['mainDeck'], $_SESSION['playerTurn'], 1);

			unset($_SESSION['playCard']);
			return true;
		}

		else
		{
			unset($_SESSION['playCard']);
			return false;
		}
	}

	function pcSelectCard()
	{
		$player = $_SESSION['playerTurn'];
		$curCard = $_SESSION['curCard'];

		$cardsInHand = $player->getHand();
		$currentSuit = $curCard->getSuit();
		$currentValue = $curCard->getValue();
		$strongSuit = $player->getStrongSuit();
		$strongValue = $player->getStrongValue();
		$cardChoices = array();
		$cardSelected;

		//Go through every card in hand and determine if could be played
		foreach($cardsInHand as $card)
		{
			$tmpSuit = $card->getSuit();
			$tmpValue = $card->getValue();


			if ($tmpSuit == $currentSuit || $tmpValue == $currentValue)
			{
				$cardChoices [] = $card;
			}	
		}	

		//If there is a card that can be played, choose one
		if(count($cardChoices) > 0)
		{
			//go through all possible choices and select a card
			foreach($cardChoices as $tmpCard)
			{
				if(is_a($tmpCard, 'Card'))
				{
					$numOfChoices = count($cardChoices);
					$tmpValue = $tmpCard->getValue();
					$tmpSuit = $tmpCard->getSuit();
	
					//select a card if it is the strong suit and value, no sevens
					if($tmpSuit == $strongSuit && $tmpValue == $strongValue)
					{
						$cardSelected = $tmpCard;
					}
	
					//select a card if it is the strong suit and no other cards selected, no sevens
					elseif($tmpSuit == $strongSuit || $tmpValue == $strongValue)
					{
						$cardSelected = isset($cardSelected)?$cardSelected:$tmpCard;
					}
	
					//randomly select a card from the choices, this could be a seven
					else
					{
						$indexToPick = rand(0,$numOfChoices-1);
						$cardSelected = isset($cardSelected)?$cardSelected:$cardChoices[$indexToPick];
					}
				}
			}	
		}

		//there were no possible plays, and pc will draw from deck
		else
		{
			$cardSelected = "deckDraw";
		}

		//return the selected card
		return $cardSelected;
	}


	function switchCurCard(&$newCard, &$curPlayer)
	{
		$curPlayer->removeCard($newCard);
		$_SESSSION['playedCards'] [] = $_SESSION['curCard'];
		$newCard->showCard();
		$_SESSION['curCard'] = $newCard;
	}
?>