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
 
// query MSMMessagess
$limit_count = isset($_GET['count']) ? (int)$_GET['count'] : 20;
$offset_count = isset($_GET['start']) ? (int)$_GET['start'] : 0;

$stmt = $messages->getAllDailyMessags($offset_count, $limit_count);

// MSMMessagess array
$messages_arr=array();

while ($row = $stmt->fetch_assoc()){
	// extract row
	// this will make $row['name'] to
	// just $name only
	extract($row);

	$MSMMessages_item=array(
		"id" => $id,
		"title" => $title,
		"description" => html_entity_decode($description),
		"picture" => $picture,
		"message_type" => $message_type,
		"message_status" => $message_status,
		"time_created" => $time_created,
		"time_delivered" => $time_delivered
	);

	array_push($messages_arr, $MSMMessages_item);
}

$database->closeConnection();

echo json_encode($messages_arr); 


?>