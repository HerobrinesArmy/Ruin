<?php

/*
Handles all things to do with the MySQL database. Functions correspond to actions such as checking the username and password, and checking
if a valid registration key has been used.
*/

require 'includes/constants.php';

class mysql {

	//Variable to hold MySQL connection.
	private $conn;

	#Constructor for this class. Instances of this class connect to a MySQL database, using the details in
	#constants.php
	function __construct()
	{
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die('There was a problem connecting.');
	}

	#Function to create a new user. It checks first if the username is valid, then if the key is valid. If both are valid
	#it then creates the user and redirects them to index.php so that they can use their shiny new account.
	function new_user($key, $un, $pwd)
	{
		if($this->check_user_exists($un)) {
			return "Username taken.";
		}
		elseif(!$this->verify_key($key)) {
			return "Invalid key.";
		}
		else {
			$query = "UPDATE members
		 			SET username = ?, password = ?
		 			WHERE register_key = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('sss', $un, $pwd, $key);

				if($stmt->execute()) {
					$stmt->close();
					header('location: index.php');
				}
			}
		}
	}

	#Used to verify keys inputted by the user.
	function verify_key($key)
	{
		$query = "SELECT *
				FROM members
				WHERE register_key = ?
				LIMIT 1";

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('s', $key);
			$stmt->execute();

			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
		}
	}

	#Function to check given username and password against the table in the database given by constants.php
	#returns true if successful.
	function verify_Username_and_Pass($un, $pwd)
	{
		//MySQL query checking to see if there is a record matching the username and password given.
		$query = "SELECT * 
				FROM members
				WHERE username = ? AND password = ?
				LIMIT 1";

		#Prepares the query and stores it in $stmt, then replaces '?' in $query with variables $un and $pwd
		#'ss' means that there are 2 strings to put into $query ($un and $pwd) also executes the query.
		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ss', $un, $pwd);
			$stmt->execute();

			//Fetches the result of the query from the server and if username and password match a record, the connection is closed and true is returned.
			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
		}

	}
	
	function check_user_exists($un)
	{
		$query = "SELECT * 
				FROM members
				WHERE username = ?
				LIMIT 1";
		
		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('s', $un);
			$stmt->execute();

			if($stmt->fetch()) {
				$stmt->close();
				return true;
			} else return false;
		}
	}

	function verify_admin($un, $pwd)
	{
		$query = "SELECT * 
				FROM members
				WHERE username = ? AND password = ? AND admin = 1
				LIMIT 1";

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ss', $un, $pwd);
			$stmt->execute();

			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
		}
	}

	function new_rfc($nm, $desc, $upd, $un)
	{
		$query = "INSERT INTO submitted_rfcs(name, description, updated, username, submit_date)
				VALUES(?, ?, ?, ?, now())";

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ssss', $nm, $desc, $upd, $un);

			if($stmt->execute()) {
				$stmt->close();
				return true;
			}
		}
	}
}
?>