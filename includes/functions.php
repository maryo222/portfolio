<?php

function connectDatabase($host, $database, $user, $pass) {
	// connect to database
try {
	$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	return $dbh;
	}	
	catch (PDOException $e) {
	print('Error! ' . $e->getMessage() . '<br>');
	die();
	}
}

// retrieve project from database
function getProject($dbh) {
	$sth = $dbh->prepare("SELECT * FROM projects");
	$sth->execute();

	$result = $sth->fetchAll();
	return $result;
}



// this function adds the content of thr feedback form to database
function addProject($dbh, $title, $image_url, $content, $link) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("INSERT INTO projects (title, image_url, content, link, created_at, updated_at) VALUES (:title, :image_url, :content, :link, NOW(), NOW())");
	// bind the $name to the SQL statement
	$sth->bindParam(':title', $title, PDO::PARAM_STR);
	// bind the $email to the SQL statement
	$sth->bindParam(':image_url', $image_url, PDO::PARAM_STR);
	// bind the $feedback to the SQL statement
	$sth->bindParam(':content', $content, PDO::PARAM_STR);
		// bind the $feedback to the SQL statement
	$sth->bindParam(':link', $link, PDO::PARAM_STR);
	// execute the statement 
	$success = $sth->execute();

	return $success;
}