<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
require_once '../model/database.php';
include_once '../model/msm_messages.php';
 
// instantiate database and MSMMessages object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$messages = new MSMMessages($db);


if(!$_GET || !$_GET['id'])
{
	echo '{';
		echo '"error": "ID value is empty."';
    echo '}';
	return; 
}

$id = $_GET['id'];	
 
// query MSMMessagess
$stmt = $messages->getMessage($id);

// MSMMessagess array
$message=null;

while ($row = $stmt->fetch_assoc()){
	// extract row
	// this will make $row['name'] to
	// just $name only
	extract($row);

	$message = array(
		"id" => $id,
		"title" => $title,
		"description" => html_entity_decode($description),
		"picture" => $picture,
		"message_status" => $message_status,
		"time_created" => $time_created,
		"time_delivered" => $time_delivered
	);

}

$database->closeConnection();

if($message == null)
{
	echo '{';
		echo '"error": "Invalid input."';
    echo '}';
	return; 
}

echo json_encode($message); 

?>