
<?php
//////////////////////////////////////////
//
//	db.class.inc.php
//
//	Class to create easy to use
//	interface with the database
//
//	By David Slater
//	June 2009
//
//////////////////////////////////////////
class db {
	////////////////Private Variables//////////
	private $link; //mysql database link
	private $host;	//hostname for the database
	private $database; //database name
	private $username; //username to connect to the database
	private $password; //password of the username
	////////////////Public Functions///////////
	public function __construct($host,$database,$username,$password) {
		$this->open($host,$database,$username,$password);
	}
	public function __destruct() {
		$this->close();
	}
	//open()
	//$host - hostname
	//$port - mysql port
	//$database - name of the database
	//$username - username to connect to the database with
	//$password - password of the username
	//$port - mysql port, defaults to 3306
	//opens a connect to the database
	public function open($host,$database,$username,$password,$port = 3306) {
		//Connects to database.
		try {
			$this->link = new PDO("mysql:host=$host;dbname=$database",$username,$password,
					array(PDO::ATTR_PERSISTENT => true));
                        
                        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->host = $host;
			$this->database = $database;
			$this->username = $username;
			$this->password = $password;
                        
		}
		catch(PDOException $e) {
                    echo "couldn't create db<BR>";
			echo $e->getMessage();
		}
	}
	//close()
	//closes database connection
	public function close() {
		$this->link = null;
	}


	//getLink
	//returns the mysql resource link
	public function get_link() {
		return $this->link;
	}

    

        public function get_query_result($query_string, $query_array=null) {
            $statement = $this->get_link()->prepare($query_string, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $statement->execute($query_array);
            $result = $statement->fetchAll();
            return $result;

        }


        public function get_update_result($query_string, $query_params=null) {
            // Update queries should probably only update one record. This will ensure 
            // only one record gets updated in case of a malformed query.
            $query_string .= " LIMIT 1"; 
            $statement = $this->get_link()->prepare($query_string, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $result = $statement->execute($query_params);
            return $result;
        }

        public function get_insert_result($query_string, $query_array=null) {

            $statement = $this->get_link()->prepare($query_string, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt = $statement->execute($query_array);
            $result =  $this->get_link()->lastInsertId();
            return $result;
        }

        public function errorInfo() {
            return $this->get_link()->errorInfo();
        }




}
?>
