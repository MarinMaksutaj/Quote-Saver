<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this code absorbs. This is the C in MVC, the Controller.
//

session_start (); 

require_once './DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();

if (isset ( $_GET ['todo'] ) && $_GET ['todo'] === 'getQuotes') {
    $arr = $theDBA->getAllQuotations();
    unset($_GET ['todo']);
    echo getQuotesAsHTML ( $arr );
} else if (isset ( $_POST ['author']) && isset($_POST['quote'] ))  {
    $theDBA->addQuote(htmlspecialchars($_POST["quote"]), htmlspecialchars($_POST["author"]));
    header ( "Location: view.php" ); 
} else if (isset($_POST["ID"])) {
    if (isset($_POST["update"]) && $_POST["update"] == "decrease") {
        $theDBA->decrementQuote($_POST["ID"]);
    } else if (isset($_POST["update"]) && $_POST["update"] == "increase") {
        $theDBA->incrementQuote($_POST["ID"]);
    } else if(isset($_POST["update"]) && $_POST["update"] == "delete") {
        $theDBA->deleteQuote($_POST["ID"]);
    } 
    header ( "Location: view.php" );
} else if (isset ( $_POST ['register'] )) {
    if ($theDBA->userExists($_POST["username"])) {
        $_SESSION["error"] = "Account name taken";
        header ( "Location: register.php" );
    } else {
        $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $theDBA->addUser($_POST["username"], $hash);
        header ( "Location: view.php" );
    }
} else if (isset ( $_POST ['login'] )) {
    if ($theDBA->verifyCredentials($_POST["username"], $_POST["password"])) {
        $_SESSION["user"] = $_POST["username"];
        header ( "Location: view.php" );
    } else {
        $_SESSION["error"] = "Invalid Account/Password";
        header ( "Location: login.php" );
    }
} else if (isset($_POST['logout'])) {
    unset($_SESSION["user"]);
    header ( "Location: view.php" );
}

function getQuotesAsHTML($arr) {
 
    $result = '';
    $rating = array_column($arr, 'rating');
    array_multisort($rating, SORT_DESC, $arr);
    foreach ($arr as $quote) {
        $result .= '<div class="container">';
        $result .= '"' . $quote ['quote'] . '"';
        $result .= "<br>";
        $result .= '<p class="author">  &nbsp;&nbsp;--' . $quote['author'] . '<br> </p>';
        $result .= '<form action="controller.php" method="post">';
        $result .= '<input type="hidden" name="ID" value="' . $quote['id'] . '">&nbsp;&nbsp;&nbsp;';
        $result .= '<button class="buton" name="update" value="increase">+</button>';
        $result .= '&nbsp;<span id="rating"> ' . (string) $quote["rating"] . '</span>&nbsp;&nbsp;';
        $result .= '<button class="buton" name="update" value="decrease">-</button>&nbsp;&nbsp;';
        if (isset($_SESSION["user"])) {
            $result .= '<button class="buton" name="update" value="delete">Delete</button>';
        }
        $result .= '</form>';
        $result .= '</div>';
        
    }
    
    return $result;
}
?>