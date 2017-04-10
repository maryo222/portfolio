<?php
session_start(); 

require 'includes/functions.php';

$host = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'portfolio';

// connecting database
$dbh = connectDatabase($host, $database, $user, $pass);


// this checks it is working ( displays as arrays)
// die(var_dump($projects));
