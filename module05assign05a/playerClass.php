<?php
class Player
{
	private $isComputer;
	private $name;
	private $id;
	private $currentHand;
	private $numOfSuits = array("H"=>"0","D"=>"0","S"=>"0","C"=>"0");
	private $numOfValues = array("1"=>"0","7"=>"0","8"=>"0","9"=>"0","10"=>"0","11"=>"0","12"=>"0","13"=>"0");

	function __construct($tmpName, $tmpID='1', $PC=true) //computer is always player one in the database
	{
		$this->name = $tmpName;
		$this->id = $tmpID;
		$this->isComputer = $PC;
		$this->currentHand = array();
	}

	function isPC()
	{
		return $this->isComputer;
	}

	function getName()
	{
		return $this->name;
	}

	function setName($newName)
	{
		$this->name = $newName;
	}

	function getID()
	{
		return $this->id;
	}

	function setID($newID)
	{
		$this->id = $newID;
	}

	function getHand()
	{
		return $this->currentHand;
	}

	function getStrongSuit()
	{
		$strongSuit = array_search(max(array_values($this->numOfSuits)), $this->numOfSuits);
		return $strongSuit;
	}

	function getStrongValue()
	{
		$strongValue = array_search(max(array_values($this->numOfValues)), $this->numOfValues);
		return $strongValue;
	}

	function addCard($card) //card must be a card object
	{
		if($this->isPC())
		{
			$card->hideCard();
		}

		else
		{
			$card->showCard();
		}
		$this->numOfSuits[$card->getSuit()]++;
		$this->numOfValues[$card->getValue()]++;
		$this->currentHand [] = $card;
	}

	//must remove a card that is in the hand
	function removeCard($card)
	{
		$this->numOfSuits[$card->getSuit()]--;
		$this->numOfValues[$card->getValue()]--;
		$indexOfCard = array_search($card, $this->currentHand);
		unset($this->currentHand[$indexOfCard]);
		$this->currentHand = array_values($this->currentHand);
	}
}
?>