<?php
class Card
{
	private $suit;
	private $value;
	private $showCard;

	function __construct($tmpSuit, $tmpValue)
	{
		$this->suit = $tmpSuit;
		$this->value = $tmpValue;
		$this->showCard = false;
	}

	function setSuit($tmpSuit)
	{
		$this->suit = $tmpSuit;
	}

	function setValue($tmpValue)
	{
		$this->value = $tmpValue;
	}

	function getSuit()
	{
		return $this->suit;
	}

	function getfullSuitName()
	{
		switch($this->suit)
		{
			case "H":
				return "Hearts";
			case "D":
				return "Diamonds";
			case "S":
				return "Spades";
			case "C":
				return "Clubs";
		}
	}

	function getValue()
	{
		return $this->value;
	}

	function getFullValueName()
	{
		switch($this->value)
		{
			case "1":
				return "Ace";
			case "7":
				return "Seven";
			case "8":
				return "Eight";
			case "9":
				return "Nine";
			case "10":
				return "Ten";
			case "11":
				return "Jack";
			case "12":
				return "Queen";
			case "13":
				return "King";
		}
	}

	function printCard()
	{
		$cardName = "".$this->getFullValueName() . ' of ' . $this->getfullSuitName()."";
		return $cardName;
	}

	function flipCard()
	{
		$this->showCard = $this->showCard?false:true;
	}

	function showCard()
	{
		$this->showCard = true;
	}

	function hideCard()
	{
		$this->showCard = false;
	}

	function isSpecial()
	{
		switch($this->getValue())
		{
			case "7": 
				return true;
			case "11":
				return true;
			case "1":
				return true;
			default:
				return false;
		}
	}

	function getImg()
	{
		if($this->showCard)
		{
			$suit = $this->getSuit();
			$value = $this->getValue();
			return 'http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/fronts/'.$suit.$value.'.svg';
		}
	
		else
		{
			return 'http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/backs/astronaut.svg';
		}
	}
}
?>