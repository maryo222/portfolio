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

function deleteProject($id, $dbh) {
	// prepare statement that will be executed
	$result = $dbh->prepare("DELETE FROM projects WHERE id= :id");
	$result->bindParam(':id', $id);
	$result->execute();
}

function redirect($url) {
	header('Location: ' . $url);
	die();
}

function editProject($id, $dbh) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("SELECT * FROM projects WHERE id = :id");
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	$sth->execute();

	$result = $sth->fetch();
	return $result;
}

function updateProject($id, $dbh, $title, $image_url, $content, $link) {
	$sth = $dbh->prepare("UPDATE projects SET title = :title, image_url = :image_url, content = :content, link = :link WHERE id = :id");
	// bind the $id to the SQL statement
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	// bind the $name to the SQL statement
	$sth->bindParam(':title', $title, PDO::PARAM_STR);
	// bind the $email to the SQL statement
	$sth->bindParam(':image_url', $image_url, PDO::PARAM_STR);
	// bind the $feedback to the SQL statement
	$sth->bindParam(':content', $content, PDO::PARAM_STR);
		// bind the $feedback to the SQL statement
	$sth->bindParam(':link', $link, PDO::PARAM_STR);
	// execute the statement 
	$result = $sth->execute();
	return $result;
}

function addUser($dbh, $username, $email, $password) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
	$sth->bindParam(':username', $username, PDO::PARAM_STR);
	$sth->bindParam(':email', $email, PDO::PARAM_STR);
	$sth->bindParam(':password', $password, PDO::PARAM_STR);

	// execute the statement 
	$success = $sth->execute();
	return $success;
}

function loggedIn() {
	return !empty($_SESSION['username']);
}

function addMessage($type, $message) {
  $_SESSION['flash'][$type][] = $message;
}

function showMessage($type = null)
{
  $messages = '';
  if(!empty($_SESSION['flash'])) {
    foreach ($_SESSION['flash'] as $key => $message) {
      if(($type && $type === $key) || !$type) {
        foreach ($message as $k => $value) {
          unset($_SESSION['flash'][$key][$k]);
          $key = ($key == 'error') ? 'danger': $key;
          $messages .= '<div class="alert alert-' . $key . '">' . $value . '</div>' . "\n";
        }
      }
    }
  }
  return $messages;
}


function getUser($dbh, $username) {
	// prepare statement that will be executed
	$sth = $dbh->prepare('SELECT * FROM `users` WHERE username = :username OR email = :email');
	$sth->bindValue(':username', $username, PDO::PARAM_STR);
	$sth->bindValue(':email', $username, PDO::PARAM_STR);

	// execute the statement 
	$sth->execute();

	$row = $sth->fetch();

	if (!empty($row)) {
		return $row;
	}
	return false;
}

function singleProject($id, $dbh) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("SELECT * FROM projects WHERE id = :id");
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	$sth->execute();

	$result = $sth->fetch();
	return $result;
}

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

