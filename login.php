<?php

// Start or resume session, and create: $_SESSION[] array
session_start(); 
// include the class that handles database connections
require "database.php";

if ( !empty($_POST)) { // if $_POST filled then process the form
	// initialize $_POST variables
	$username = $_POST['username']; // username is email address
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	$labelError = "";
		
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM customers WHERE email = ? AND password_hash = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$passwordhash));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data) { // if successful login set session variables
		// echo "success!";
		$_SESSION['id'] = $data['id'];
		
		Database::disconnect();
		header("Location: customers.php ");
		// javascript below is necessary for system to work on github
		// echo "<script type='text/javascript'> document.location = 'fr_assignments.php'; </script>";
		exit();
	}
	else { // display error message
		Database::disconnect();
		$labelError = "Incorrect username/password";
	}

	

} 
// if $_POST NOT filled then display login form, below.
?>

<html>
        <meta charset='UTF-8'>
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
<h3>Log In</h3>
<form class="form-horizontal" action="login.php" method="post">
	
	
	<p><?php echo $errorMessage; ?></p>
	<div class="control-group">
		<div class="controls">
			<label class="control-label">Username (email):</label>
			<div>	<input name ="username" type="text" placeholder="example@email.com"></div>
          </div>
		<h1> </h1>
		<div class="controls">
				<label class="control-label">Password: </label>
			<div><input name ="password" type="Password" required></div>
		</div>
		<h1> </h1>
		<div class="controls">
		<div>	<button type="submit" class="btn btn-success">Log In</button>
			<a href="join.php" class="btn btn-info">sign Up </a></div>
		</div>
	</div>
</form>
</html>