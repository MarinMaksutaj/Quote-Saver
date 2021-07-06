<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="showQuotes()">
<?php 
    session_start();
?>
<h1>Quotation Service</h1>

<?php 
    if (isset($_SESSION["user"])) {
		echo "<div class='container' style='border:0; background-color:#EBEBD3;'>" . PHP_EOL;
		echo "<a href='./addQuote.php'><button class='buton'>Add Quote</button></a> <br><br>" . PHP_EOL;
		echo "<form action='controller.php' method='post'>" . PHP_EOL;
		echo "<input class='buton' type='submit' value='Logout' name='logout'> </form>" . PHP_EOL;
		echo "<br> &nbsp <b> Hello " . htmlspecialchars($_SESSION["user"]) . "</b>" . PHP_EOL;
		echo "<hr>" . PHP_EOL;
		echo "</div>" . PHP_EOL;
	} else {
		echo "<div class='container' style='border:0; background-color:#EBEBD3;'>" . PHP_EOL;
		echo "&nbsp;" . PHP_EOL;
		echo "<a href='./register.php'><button class='buton'>Register</button></a> &nbsp;" . PHP_EOL;
		echo "<a href='./login.php'><button class='buton'>Login</button></a> &nbsp;" . PHP_EOL;
		echo "<hr>" . PHP_EOL;
		echo "</div>" . PHP_EOL;
	}
?>
<div id="quotes"></div>

<script>
var element = document.getElementById("quotes");
function showQuotes() {
	// retreives all quotations
	  var ajax = new XMLHttpRequest();
			ajax.open("GET", "controller.php?todo=getQuotes", true);
			ajax.send();
			ajax.onreadystatechange = function () {
				if (ajax.readyState == 4 && ajax.status == 200) {
				var quotes = ajax.responseText;
				document.getElementById("quotes").innerHTML = quotes;
				}
			}

} // End function showQuotes

</script>

</body>
</html>