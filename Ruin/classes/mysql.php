<?php

/*
Handles all things to do with the MySQL database. Functions correspond to actions such as checking the username and password, and checking
if a valid registration key has been used.
*/

require 'includes/constants.php';

class mysql {

	//Variable to hold MySQL connection.
	private $conn;

	/* Constructor for this class. Instances of this class connect to a MySQL database, using the details in
	constants.php */
	function __construct()
	{
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die('There was a problem connecting.');
	}

	function new_user($key, $un, $pwd)
	{
		$query = "UPDATE members
		 		SET username = ?, password = ?
		 		WHERE register_key = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('sss', $un, $pwd, $key);
				$stmt->execute();

				if($stmt->fetch()) {
					$stmt->close();
					return true;
				}
			}
	}

	/* Function to check given username and password against the table in the database given by constants.php
	returns true if successful */
	function verify_Username_and_Pass($un, $pwd)
	{
		//MySQL query checking to see if there is a record matching the username and password given.
		$query = "SELECT * 
				FROM members
				WHERE username = ? AND password = ?
				LIMIT 1";

		/* Pepares the query and stores it in $stmt, then replaces '?' in $query with variables $un and $pwd
		'ss' means that there are 2 strings to put into $query ($un and $pwd) */
		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ss', $un, $pwd);
			$stmt->execute();

			//Sends the MySQL script to the server and if username and password match a record, the connection is closed and true is returned.
			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
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
			$stmt->execute();

			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
		}
	}
}
?>