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
if(!isset($_POST['title']) || !isset($_POST['description']) || !isset($_FILES['picture']))
{
	echo '{';
		echo '"error": "Provide valid inputs."';
    echo '}';
	return;
}

// get posted data
$title = $_POST['title'];
$description = $_POST['description'];
$picture = $_FILES['picture']['name'] . '_' . time() . '.JPG';
$message_status = "DELIVERED";
$message_type = "IMAGE";
$message_payload = "";

$uploads_dir = '../views/images/';
$uploadfile = $uploads_dir . basename($picture);

if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) {
	// query MSMMessagess
	if($message->createMessage($title,$description,$picture,$message_payload,$message_type,$message_status))
	{
		echo '{';
			echo '"message": "Message is created successfully."';
		echo '}';
	}
	else{
		echo '{';
			echo '"error": "Unable to post message."';
		echo '}';
	}
} else {
    echo '{"error": "Possible file upload attack."}';
}
?>