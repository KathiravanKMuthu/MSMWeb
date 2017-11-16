<?php
		
class AdminLoginController {
	
	function admin_login()
	{
		$error_message = "";
		
		// Check if username is empty
		$username = trim($_POST["username"]);
		if(empty($username)){
			$error_message = $error_message . 'Please provide valid User Name </br>';
		}
		
		// Check if password is empty
		$password = trim($_POST["password"]);
		if(empty($password)){
			$error_message = $error_message . 'Please provide valid password </br>';
		}

		// Validate credentials
		if(empty($error_message)){
			if(($username == "msmadmin") && ($password == "dqadmin")) {
				$_SESSION['username']=$username;
			} else{
				$error_message = $error_message . "Invalid credentials. Please enter the right one.<br/>";
			}
		}
		else{
			$_SESSION['error_message'] = $error_message;
		}
		return $username;
	}	
}
?>