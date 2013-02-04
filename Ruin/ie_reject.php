<?php

require 'classes/user.php';

$user = new user();

if($user->get_user_browser() != 'ie') {
	header('location: index.php');
}

?>
<html>
No.
</html>