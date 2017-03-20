<?php

require 'includes/functions.php';

$host = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'portfolio';

// connecting database
$dbh = connectDatabase($host, $database, $user, $pass);
$projects = getProject($dbh);
// die(var_dump($projects));
