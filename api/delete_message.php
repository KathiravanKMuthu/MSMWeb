<?php
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	// include database and object files
	require_once '../model/database.php';
	include_once '../model/msm_messages.php';
	 
	// instantiate database and MSMMessages object
	$database = new Database();
	$db = $database->getConnection();
	 
	// initialize object
	$message = new MSMMessages($db);

	// check posted data
	if(!isset($_POST['id']))
	{
		echo '{';
			echo '"error": "Provide valid inputs."';
	    echo '}';
		return;
	}

	// get posted data
	$id = $_POST['id'];

	// query MSMMessagess
	if($message->deleteMessage($id))
	{
		echo '{';
			echo '"message": "Message is deleted successfully."';
		echo '}';
	}
	else{
		echo '{';
			echo '"error": "Unable to delete the message."';
		echo '}';
	}
?>