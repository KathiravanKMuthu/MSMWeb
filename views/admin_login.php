<?php
require_once '../controller/admin_login_controller.php';

if(!isset($_SESSION)){
    session_start();
}

// Get the error message to display in this page
if (isset($_SESSION["error_message"]))
{
	$error_message = $_SESSION["error_message"];
	unset($_SESSION["error_message"]);
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$admin_login_controller = new AdminLoginController();
	$admin_login_controller->admin_login();

	// Get the error message to display in this page
	if (isset($_SESSION["error_message"]))
	{
		$error_message = $_SESSION["error_message"];
		header("location: admin_login.php");
	}
	else
	{
		header("location: messages.html");
	}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Morning Scriptures for VMM</title>
	<link rel="shortcut icon" href="images/favicon.ico">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
	<?php
	if( isset($error_message) ) { ?>
		   <div class="alert alert-danger homealert" role="alert" align="center">
			   <strong><?php echo $error_message ?></strong>          
		   </div>
	<br/>
	<?php } else { ?>
	<br/>
		<?php if( isset($info_message) ) { ?>
		   <div class="alert alert-success homealert" role="alert" align="center">
			   <strong><?php echo $info_message ?></strong>          
		   </div>
		<?php } else if (isset($warning_message)) { ?>
		   <div class="alert alert-danger homealert" role="alert" align="center" style="color:red;width:94%"><?php echo $warning_message ?>
			</div>
		<?php } ?>
	<br/>
	<?php } ?>
    <!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <div class="container">
        <div class="card card-container">
			<h4 align="center">Welcome VMM Admin !!!</h4>
            <img id="profile-img" class="profile-img-card" src="images/vmm.jpg" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" action="admin_login.php" method="post">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Login</button>
            </form><!-- /form -->
        </div><!-- /card-container -->
    </div><!-- /container -->
</body>
</html>
