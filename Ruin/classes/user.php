<?php

require 'mysql.php';

class user {

	function validate_user($un, $pwd)
	{
		//Creates a new instance of MySQL class
		$mysql = new mysql();

		$ensure_credentials = $mysql->verify_Username_and_Pass($un, $pwd);

		if($ensure_credentials) {
			$_SESSION['status'] = 'authorised';
			header("location: submit.php");
		} else return "Wrong user/password combination.";

		if($mysql->verify_admin($un, $pwd)) {
			$_SESSION['admin'] = true;
		} else $_SESSION['admin'] = false;
	}

	function register_user($key, $un, $pwd)
	{
		$mysql = new mysql();

		$result = $mysql->new_user($key, $un, $pwd);

		return $result;

		// if(isset($result)) {
		// 	if($result) {
		// 		//return $result;
		// 		return $result;
		// 	}
		// 	elseif($result == "Invalid key.") {
		// 		//return $result;
		// 		return 2;
		// 	}
		// 	elseif($result == "Username taken.") {
		// 		//header("location: index.php");
		// 		return 4;
		// 	} 
		// }
	}

	function get_user_browser()
	{
	    $u_agent = $_SERVER['HTTP_USER_AGENT'];

	    if(preg_match('/MSIE/i',$u_agent))
	    {
	        $ub = "ie";
	    }
	    elseif(preg_match('/Firefox/i',$u_agent))
	    {
	        $ub = "firefox";
	    }
	    elseif(preg_match('/Safari/i',$u_agent))
	    {
	        $ub = "safari";
	    }
	    elseif(preg_match('/Chrome/i',$u_agent))
	    {
	        $ub = "chrome";
	    }
	    elseif(preg_match('/Flock/i',$u_agent))
	    {
	        $ub = "flock";
	    }
	    elseif(preg_match('/Opera/i',$u_agent))
	    {
	        $ub = "opera";
	    }

	    return $ub;
	}
}
?>