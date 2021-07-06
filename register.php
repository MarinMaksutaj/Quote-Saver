<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php 
    session_start();
    // start the session at the beginning
?>
    
    <h3>Register</h3>
    <div class="register">
        <form action="controller.php" method="post">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <input class="buton" type="submit" name="register" value="Submit"><br><br>
        </form>
        <p id="message"> <b>
            <?php
                if (isset($_SESSION["error"])) {
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                }
            ?>
        </b></p>
    </div>
</body>
</html>