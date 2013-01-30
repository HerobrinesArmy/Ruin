<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="root"; // Mysql password 
$db_name="RFC_Database"; // Database name 
$tbl_name="submitted_rfcs"; // Table name 

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// Get values from form 
$name=$_POST['name'];
$description=$_POST['description'];
$updated=$_POST['updated'];

// Insert data into mysql 
$sql="INSERT INTO $tbl_name(name, description, updated, submit_date)VALUES('$name', '$description', '$updated', now())";
$result=mysql_query($sql);

// if successfully insert data into database, displays message "Successful". 
if($result){
echo "Successful";
echo "<BR>";
echo "<a href='index.html'>Back to main page</a>";
}

else {
echo "ERROR";
}
?>