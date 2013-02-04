<?php

//For debugging only
ini_set('display_errors',1); 
error_reporting(E_ALL);

require 'includes/PasswordHash.php';
require 'classes/user.php';

$user = new user();
$hasher = new PasswordHash(8, false);

if($user->get_user_browser() == "ie") {
    header("location: ie_reject.php");
}

if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['key'])) {

    $username = $_POST['username'];
    $key = $_POST['key'];
    $password = $_POST["password"];

    // Passwords should never be longer than 72 characters to prevent DoS attacks
    if(strlen($password) > 72) { 
        die('Password must be 72 characters or less'); 
    }

    //The $hash variable will contain the hash of the password
    $hash = $hasher->HashPassword($password);

    if (strlen($hash) >= 20) { 
        $result = $user->register_user($key, $username, $hash);
    }
}
?>

<!DOCTYPE HTML>
<html>

<link rel="stylesheet" type="text/css" href="style.css">

<head>
<title>Phoenix's Basic Registration Page</title>
</head>

<body>
    <div id="title">Registration Page</div>
        <div id="submit-form">
            <form method="post" action="">
                <label for="updated">Registration Key:</label>
                <input type="text" name="key" placeholder="The key given to you"/>
                <label for="name">Username:</label> 
                <input id="input" type="text" name="username" placeholder="Username" required="required" autofocus="autofocus"/>
                <label for="description">Password:</label>
                <input id="input" type="password" name="password" placeholder="Password" required="required"/>
                <input id="submit-button" type="submit" value="Submit"/> 
                <?php if(isset($result)) echo "<div id=notice>".$result."</div>"; ?> 
            </form>
      </div>
If you don't have a key, you cannot register, please request one from Phoenix, awesome271828, Dilbertfan, LupusMalus or Kitcat490.
</body>
</html>