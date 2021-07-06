<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quote</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php
    session_start();
    if (isset($_SESSION["user"])) {
        echo "<h1>Add a Quote</h1>" . PHP_EOL;
        echo '<div class="container_quote">' . PHP_EOL;
        echo '<form action="controller.php" method="post">' . PHP_EOL;
        echo '<textarea name="quote" id="" cols="30" rows="10" placeholder="Enter new quote"></textarea><br><br>' . PHP_EOL;
        echo '<input type="text" name="author" placeholder="Author"><br><br>' . PHP_EOL;
        echo '<input class="buton" type="submit" value="Add Quote">' . PHP_EOL;
        echo '</form>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
    } else {
        echo "<p> You are not logged in and cannot add a quote </p>" . PHP_EOL;
    }
?>
</body>
</html>
