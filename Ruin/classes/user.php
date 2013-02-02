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

		if(isset($result)) {
			if($result == "Username taken.") {
				return $result;
			}
			else if($result) {
				//header("location: index.php");
				return "YAY";
			} 
		}
	}
}
?>