<?php
function getForm($formToGet)
{
    $path = 'http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/index.php';
    $uName = $_SESSION['uName'];
    $uPass = $_SESSION['uPass'];
    $theRules =  
    '<p style="color:darkblue">
        <strong style="color:yellow">Please Note: This does not follow the traditional rules, futher development is needed</strong><br><br>
        These are the rules<br><br>
        The player must play the same suit or value of the card in the middle.<br>
        The first player to play all their cards wins.<br>
        If you cannot play a card, you must draw a card from the deck in the middle.<br>
        The deck is endless, but starts with every suit of values "Ace, King, Queen, Jack, 10, 9, 8, 7".<br>
    </p>';

    switch($formToGet)
    {
        //let the user log in
        case "loginForm":
            $loginForm = '
                '.$theRules.'
                <p>
                    <br><br>
                    <h1>Welcome To Şeptică</h1>
                    <br>Please login or create a new user to begin
                </p>
                <form class="page" action='.$path.' method="POST">
                    <label for="uName">User Name:</label>
                    <input type="text" name="uName" value="'.$uName.'" placeholder="User Name or ID">
                    <label for="uPass">Password:</label>
                    <input type="password" name="uPass" value="'.$uPass.'" placeholder="Enter Password">
                    <br><br><input type="submit" class="button" name="Submit" value="Login">
                    <input type="submit" class="button" name="Submit" value="Create New User">
                </form><br><br>
                <p style="color:yellow">
                    Turn information will be displayed below playing field along with the code and rules when the toggle button is clicked<br><br><br>
                    <br>|
                    <br>|
                    <br>|
                    <br>\ | /
                    <br>\|/
                    <br>|
                </p>';

            return $loginForm;
        break;

        //create a new user
        case "createUserForm":
            $creatUserForm = <<< HERE
                <form class="page" action=$path method="POST">
                    <label for="uName">User Name:</label>
                    <input type="text" name="uName" value="$uName" placeholder="Enter User Name">
                    <label for="uPass">Enter Password:</label>
                    <input type="password" name="uPass" value="$uPass" placeholder="Enter Password">
                    <label for="uPassTwo">Verify Password:</label>
                    <input type="password" name="uPassTwo" placeholder="Re-Enter Password">
                    <br><br><input type="submit" class="button" name="Submit" value="Create">
                    <input type="submit" class="button" name="Submit" value="Back">
                </form>
HERE;

              return $creatUserForm;      
        break;

        //where the user goes after selecting an option
        case "gameForm":
            $fakePerson = $_SESSION['players'][0]->getHand();
            $realPerson = $_SESSION['players'][1]->getHand();

            if($_SESSION['turnNumber'] == 0 )
            {
                $gameForm =                           
                            '<form class="uOptions" action='.$path.' method="POST">
                            <button type="submit" name="Start" value="Start">Begin</button>
                            </form>';

                $_SESSION['turnNumber']++;
            }

            else
            {
                if($_SESSION['playerTurn']->isPC())
                {
                    $turnImg = "http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/others/upArrow.svg";
                }
    
                else
                {
                    $turnImg = "http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/others/downArrow.svg";
                }
            
    
                $gameForm =
    
                        "<form class='pcCards' action=".$path." method='POST'>"
                    .       placeCards($fakePerson, true)
                    .   "<label style='color:orange'>[ <strong style='color:yellow'>".$_SESSION['players'][0]->getName()."</strong> ]</label>"
                    .   "</form>"
    
                    .   "<form class='drawCards' action=".$path." method='POST'>"
                    .       "<label style='color:yellow'>Draw Deck</label>"
                    .       '<label id="clickableCard">
                                <input type="submit" name="clickCard" value="deckDraw">
                                <img src="http://puff.mnstate.edu/~cx3645kg/private/module05assign05a/backs/astronaut.svg"></img>
                            </label>'
                    .       '<label>
                                <img src="'.$_SESSION['curCard']->getImg().'"></img>
                            </label>'
                    .       "<label style='color:yellow'>Current Card</label>"
                    .       '<input type="hidden" name="playCard" value="deckDraw">'
                    .   "</form>"
                    .   '<div class="usersCards">'
                    .       placeCards($realPerson)
                    .   "<label style='color:orange'>[ <strong style='color:yellow'> ".$_SESSION['players'][1]->getName()."</strong> ]</label>"
                    .   '</div>';
            }

            return $gameForm;
        break;

        //where the user goes after logging in
        case "userOptions":
            $optionsForm =
                    '<form class="uOptions" action='.$path.' method="POST">
                       <button type="submit" name="Submit" value="newGame">New Game</button>
                       <button type="submit" name="Submit" value="resumeGame">Resume Game</button>
                    </form>';

            return $optionsForm;
        break;

        case "winForm":
            $optionsForm =
                    '
                    <h1 style="color:blue">Congratulations, You Won!</h1>
                    <form class="uOptions" action='.$path.' method="POST">
                       <button type="submit" name="Submit" value="newGame">New Game</button>
                    </form>';

            return $optionsForm;
        break;

        case "loseForm":
            $optionsForm =
                    '
                    <h1 style="color:red">You Lost :(</h1>
                    <form class="uOptions" action='.$path.' method="POST">
                       <button type="submit" name="Submit" value="newGame">New Game</button>
                    </form>';

            return $optionsForm;
        break;

        case "showRules":
            return $theRules;
        break;
    }
}
?>