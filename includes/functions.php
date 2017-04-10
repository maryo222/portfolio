<?php

/**
 * Connect to the database function
 * @param string $host 
 * @param string $database 
 * @param string $user 
 * @param string $pass 
 * @return boolean
 */
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

/** retrieve project from database
 * Description
 * @param string $dbh 
 * @return result
 */
function getProject($dbh) {
	$sth = $dbh->prepare("SELECT * FROM projects");
	$sth->execute();

	$result = $sth->fetchAll();
	return $result;
}

/**
 * function adds the content of thr feedback form to database
 * @param string $dbh 
 * @param string $title 
 * @param string $image_url 
 * @param string $content 
 * @param string $link 
 * @return boolean
 */
function addProject($dbh, $title, $image_url, $content, $link) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("INSERT INTO projects (title, image_url, content, link, created_at, updated_at, user_id) VALUES (:title, :image_url, :content, :link, NOW(), NOW(), :user_id)");
	// bind the $name to the SQL statement
	$sth->bindParam(':title', $title, PDO::PARAM_STR);
	// bind the $email to the SQL statement
	$sth->bindParam(':image_url', $image_url, PDO::PARAM_STR);
	// bind the $feedback to the SQL statement
	$sth->bindParam(':content', $content, PDO::PARAM_STR);
		// bind the $feedback to the SQL statement
	$sth->bindParam(':link', $link, PDO::PARAM_STR);

	$sth->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
	// execute the statement 
	$success = $sth->execute();

	return $success;
}

/**
 * Deletes project from database
 * @param int $id 
 * @param string $dbh 
 * @return type
 */
function deleteProject($id, $dbh) {
	// prepare statement that will be executed
	$result = $dbh->prepare("DELETE FROM projects WHERE id= :id LIMIT 1");
	$result->bindParam(':id', $id);
	$result->execute();
}

/**
 * Redirect function that can be used multiple times
 * @param type $url 
 * @return url
 */
function redirect($url) {
	header('Location: ' . $url);
	die();
}

/**
 * Edit project, retrives project and takes it throught to new page
 * @param int $id 
 * @param string $dbh 
 * @return boolean
 */
function editProject($id, $dbh) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("SELECT * FROM projects WHERE id = :id LIMIT 1");
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	$sth->execute();

	$result = $sth->fetch();
	return $result;
}

/**
 * Updates info in the database by binding information
 * @param int $id 
 * @param string $dbh 
 * @param string $title 
 * @param string $image_url 
 * @param string $content 
 * @param string $link 
 * @return boolean
 */
function updateProject($id, $dbh, $title, $image_url, $content, $link) {
	$sth = $dbh->prepare("UPDATE projects SET title = :title, image_url = :image_url, content = :content, link = :link WHERE id = :id LIMIT 1");
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

/**
 * Add user to the database
 * @param string $dbh 
 * @param string $username 
 * @param string $email 
 * @param string $password 
 * @return boolean
 */
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

/**
 * Checks if you are logged in
 * @return boolean
 */
function loggedIn() {
	return !empty($_SESSION['username']);
}

/**
 * Adds message
 * @param string $type 
 * @param string $message 
 * @return type
 */
function addMessage($type, $message) {
  $_SESSION['flash'][$type][] = $message;
}

/**
 * Show message with errors or success
 * @param type|null $type 
 * @return type
 */
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

/**
 * Retrieve user from database
 * @param string $dbh 
 * @param string $username 
 * @return boolean
 */
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

/**
 * Passes single project throught to a new page
 * @param int $id 
 * @param string $dbh 
 * @return type
 */
function singleProject($id, $dbh) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("SELECT * FROM projects WHERE id = :id LIMIT 1");
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	$sth->execute();

	$result = $sth->fetch();
	return $result;
}

/**
 * Sets gravatar, checks for existing account
 * @param type $email 
 * @param type|int $s 
 * @param type|string $d 
 * @param type|string $r 
 * @param type|bool $img 
 * @param type|array $atts 
 * @return url
 */
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

/**
 * escapes hacking abilities
 * @param string $value 
 * @return type
 */
function e($value) {
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function userOwns($id) {
	if (loggedIn() && $_SESSION['id'] == $id) {
		return true;
	}
	return false;
}

