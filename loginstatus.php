<?php
class Database
{   
    private $host = "localhost";
    private $db_name = "dblogin";
    private $username = "root";
    private $password = "";
    public $conn;
     
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
				$stmt = $auth_user->runQuery("SELECT user_type FROM users WHERE user_id=:user_id");
				$stmt->execute(array(":user_id"=>$user_id));
				
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($objResult["Status"] == "ADMIN")
			{
			header("location:admin_page.php");
			}
			else
			{
			header("location:user_page.php");
			}
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
}
?>