<?php 

require 'classes/user.php';
require 'includes/PasswordHash.php';

//Used for debugging, can remove.
ini_set('display_errors',1); 
error_reporting(E_ALL);

session_start();
$sid = session_id();

$user = new user();
$hasher = new PasswordHash(8, false);

if($user->get_user_browser() == "ie") {
    header("location: ie_reject.php");
}

//Comment this out if you need to test the login page whilst logged in.
if(isset($_SESSION['status'])) {
    header('location: submit.php');
}

if($_POST && !empty($_POST['username']) && !empty($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $hash = $hasher->HashPassword($password);
    
    $result = $user->validate_user($username, $password);

    if($result != "Wrong user/password combination.") {
        $_SESSION['username'] = $username;
    } 
}

?>

<!DOCTYPE HTML>
<html>

<link rel="stylesheet" type="text/css" href="style.css">

<head>
<title>Phoenix's Basic Login Page</title>
</head>

<body>
    <?php 
    if(isset($_SESSION['username'])) {
        echo "<div id=user>Logged in as ".$_SESSION['username']."  <a href=logout.php>Logout.</a></div>";
        if($_SESSION['admin'] == true) {
            echo "<div id=admin>Admin rights.</div>";
        }
    }
    else {

    }
    ?>
    <div id="title">Login Page</div>
  <div id="submit-form">
    <form method="post" action="">
        <label for="name">Username:</label> 
        <input id="input" type="text" name="username" placeholder="Username" required="required" autofocus="autofocus"/>
        <label for="description">Password:</label>
        <input id="input" type="password" name="password" placeholder="Password" required="required"/>
        <input id="submit-button" type="submit" value="Submit"/>
        <?php if(isset($result)) echo "<div id=notice>".$result."</div>"; ?> 
    </form>
  </div>

If you don't have an account, please request a registration key and then register <a href="register.php">here</a>.
</body>
</html>