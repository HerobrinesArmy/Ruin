<?php

require 'classes/mysql.php';

//For debugging only
ini_set('display_errors',1); 
error_reporting(E_ALL);

session_start();
$sid = session_id();

$mysql = new mysql();

if($_POST && !empty($_POST['name']) && !empty($_POST['description'])) {
    
    $name=$_POST['name'];
    $description=$_POST['description'];
    $updated=$_POST['updated'];
    $username=$_SESSION['username'];

    $result = $mysql->new_rfc($name, $description, $updated, $username);
}
if(empty($_SESSION['username'])) {
    header("location: unauthorised.php");
}
?>
<!DOCTYPE HTML>
<html>

<link rel="stylesheet" type="text/css" href="style.css">

<head>
<title>Phoenix's Basic RFC Submitter</title>
</head>
<body>
    <?php  
        if(isset($_SESSION['username'])) {
            echo "<div id=user>Logged in as ".$_SESSION['username']." <a href=logout.php>Logout.</a></div>";
            if($_SESSION['admin'] == true) {
                echo "<div id=admin>Admin rights.</div>";
            }
       }
    ?>
    <div id="title">Ruin Submitter Page</div>
    <div id="submit-form">
        <form method="post" action="">  
            <label for="name">RFC Name (e.g. "Sending of Souls over Entropy"):</label> 
            <input id="input" type="text" name="name" placeholder="Name" required="required" autofocus="autofocus"/>
            <label for="description">Description:</label>
            <textarea id="textarea" name="description" placeholder="Your RFC description, minimum 100 chars" required="required" data-minlength="100"></textarea>
            <label for="updated">Updated RFC:</label>
            <input type="text" name="updated" placeholder="The name of the RFC updated by this, leave blank if none."/>
            <input id="submit-button" type="submit" value="Submit"/>  
            <?php 
                if(isset($result)) {
                    if($result) {
                        echo "<div id=notice>Submission successful!</div>";
                    }
                    else {
                        echo "<div id=notice>Submission unsuccessful!</div>";
                    }
                }
            ?> 
        </form>
    </div>
</body>
</html>
    </div>
</body>
</html>