<?php
class MSMMessages{
 
    // database connection and table name
    private $conn;
    private $table_name = "msm_messages";
	private $m_fields = "id, title, description, picture, message_status, time_created, time_delivered";
	
    // object properties
    public $id;
    public $title;
    public $description;
    public $picture;
    public $message_status;
    public $time_created;
    public $time_delivered;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read products
	function getAllMessages(){
		// select all query
		$query = "SELECT * FROM msm_messages ORDER BY id DESC";

		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
		$result_set = $stmt->get_result();
		$stmt->close();
		return $result_set;
	}
	
	function getMessage($id){
		// select all query
		$query = "SELECT * FROM msm_messages WHERE id = ? ORDER BY id DESC";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("i", $id);
	 
		// execute query
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		return $result;
	}
	
	function createMessage($title, $description, $picture, $message_status){
		// select all query
		$query = "INSERT INTO msm_messages(title, description, picture, message_status, time_delivered) VALUES(?,?,?,?,NOW())";
	 
		// prepare query statement
		//if($stmt = $this->conn->prepare($query))
		{
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param('ssss',$title,$description,$picture,$message_status);
			// execute query
			if($stmt->execute())
				return true;
		}
		
		echo (isset($stmt->error)) ? " | Error occurred : ". $stmt->error : "";	
		return false;
	}
}