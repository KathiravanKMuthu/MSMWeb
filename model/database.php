<?php
require_once '../configurations/dbconfig.php';

class Database{
 
    // specify your own database credentials
    public $conn;
 
    // get the database connection
    public function getConnection(){
        $this->conn = null;
        try{
			$mysqli_connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$this->conn = $mysqli_connection;
        }catch(Exception $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
	
	    // get the database connection
    public function closeConnection(){
		if($this->conn)
			$this->conn->close();
    }
}
?>