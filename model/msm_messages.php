<?php
require_once '../configurations/app_config.php';

class MSMMessages{
 
    // database connection and table name
    private $conn;
    private $table_name = "msm_messages";
	private $m_fields = "id, title, description, picture, message_payload, message_type, message_status, time_created, time_delivered";
	
    // object properties
    public $id;
    public $title;
    public $description;
    public $picture;
    public $message_type;
    public $message_status;
    public $time_created;
    public $time_delivered;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
		
	public function sendPushNotification($title, $message_type)
	{
		$content = array(
			"en" => $title
		);
		
		$heading_msg = "You got a new message from ". CLIENT_DISP_NAME;
		if($message_type == "VIDEO")
		{
			$heading_msg = "You got a Video message from ". CLIENT_DISP_NAME;
		}
		else if($message_type == "EVENT")
		{
			$heading_msg = "You got an event notification from ". CLIENT_DISP_NAME;
		}

		$heading = array(
			"en" => $heading_msg
		);
		
		$fields = array(
			'app_id' => "e078180f-bd0d-422e-b87d-0287113db9fd",
			'included_segments' => array('Active Users'),
			'data' => array("key" => "VMM"),
			'contents' => $content,
            'headings' => $heading
		);
		
		$fields = json_encode($fields);
    		//print("\nJSON sent:\n");
    		//print($fields);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic NTVlYjVlMWItYjQ3Yy00MDdmLTk2OGUtNWFiNmQzNTQ0MGI4'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	
	function createMessage($title, $description, $picture, $message_payload, $message_type, $message_status){
		// select all query
		$query = "INSERT INTO msm_messages(title, description, picture, message_payload, message_type, message_status, time_delivered) VALUES(?,?,?,?,?,?,NOW())";
	 
		// prepare query statement
		//if($stmt = $this->conn->prepare($query))
		{
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param('ssssss',$title,$description,$picture,$message_payload,$message_type,$message_status);
			// execute query
			if($stmt->execute())
			{
				$response = $this->sendPushNotification($title, $message_type);
				//$return["allresponses"] = $response;
				//$return = json_encode( $return);
				
				//print("\n\nJSON received:\n");
				//print($return);
				//print("\n");
				return true;
			}
		}
		
		echo (isset($stmt->error)) ? " | Error occurred : ". $stmt->error : "";	
		return false;
	}
	
	// read products
	function getAllMessages($offset=0, $limit=10){
		// select all query
		$query = "SELECT * FROM msm_messages ORDER BY id DESC LIMIT " . $offset . ", " . $limit;

		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
		$result_set = $stmt->get_result();
		$stmt->close();

		return $result_set;
	}

	public function getAllMessagesByType($msg_type, $offset=0, $limit=10)
	{
		// select all by message type
		$query = "SELECT * FROM msm_messages WHERE message_type = ? ORDER BY id DESC LIMIT " . $offset . ", " . $limit;

		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 	$stmt->bind_param("s", $msg_type);

		// execute query
		$stmt->execute();
		$result_set = $stmt->get_result();
		$stmt->close();
		return $result_set;
	}
	
	function getAllDailyMessags($offset=0, $limit=10)
	{
		return $this->getAllMessagesByType('IMAGE', $offset, $limit);
	}

	function getAllVideoMessages($offset=0, $limit=10)
	{
		return $this->getAllMessagesByType('VIDEO', $offset, $limit);
	}

	function getAllEvents($offset=0, $limit=10)
	{
		return $this->getAllMessagesByType('EVENT', $offset, $limit);
	}

	function getMessage($id){
		// select all query
		$query = "SELECT * FROM msm_messages WHERE id = ?";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("i", $id);
	 
		// execute query
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		return $result;
	}

}