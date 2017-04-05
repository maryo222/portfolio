<?php
require 'includes/config.php';
if (loggedIn()) {
	redirect('dashboard.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // define variables and set to empty values
    $username = $email = $password = '';
    // Add data from form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = strtolower($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

	if($_POST['username'] === '' || $_POST['password'] === '' || $_POST['email'] === '') {
		addMessage("Registration was not successful");
		}
	else {	    
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['password'] = $_POST['password'];
		addUser($dbh, $username, $email, $hashPassword);
		addMessage("You have been registered!");
		redirect("index.php");
	}
}

?>

	<div class="container">

	  <div class="row">
	    <div class="col-md-12">
	          </div>
	  </div>

	  <div class="row">
	    <div class="col-md-8 col-md-offset-2">
	      <div class="panel panel-default">
	        <div class="panel-heading">Register</div>
	        <div class="panel-body">
	          <form class="form-horizontal" role="form" method="POST" action="register.php">

	            <div class="form-group">
	              <label for="username" class="col-md-4 control-label">Username</label>

	              <div class="col-md-6">
	                <input id="username" type="text" class="form-control" name="username" value="" required="" autofocus="">
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="email" class="col-md-4 control-label">E-Mail Address</label>

	              <div class="col-md-6">
	                <input id="email" type="email" class="form-control" name="email" value="" required="">
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="password" class="col-md-4 control-label">Password</label>

	              <div class="col-md-6">
	                <input id="password" type="password" class="form-control" name="password" required="">
	              </div>
	            </div>

<!-- 	            <div class="form-group">
	              <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

	              <div class="col-md-6">
	                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required="">
	              </div>
	            </div> -->

	            <div class="form-group">
	              <div class="col-md-6 col-md-offset-4">
	                <button type="submit" class="btn btn-primary">
	                  Register
	                </button>
	              </div>
	            </div>
	          </form>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

<?php 
    require 'partials/footer.php';
?>