

<?php
	session_start();
	require "database.php";
	$errorMessage = $_GET['errorMessage'];
	if($_POST) {

			$success = false;
			$username =  $_POST['username'];
			$email = $_POST['username'];
			$password = $_POST['password'];

            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customers (email,password_hash) values(?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($username,MD5($password)));
			Database::disconnect();
			header("Location: login.php"); // go back to login screen
    }
	
?>



<html>
	<meta charset='UTF-8'>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
<h3>Sign Up an Account</h3>
<form class="form-horizontal" action="join.php" method="post">
	
	
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
			<button type = "submit"  class="btn btn-success">Sign Up</button>
			<a href="login.php" class="btn btn-danger">Back</a>
		</div>
	</div>
</form>
</html>