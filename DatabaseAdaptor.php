<?php
// This class has a constructor to connect to a database. The given
// code assumes you have created a database named 'quotes' inside MariaDB.
//
// Call function startByScratch() to drop quotes if it exists and then create
// a new database named quotes and add the two tables (design done for you).
// The function startByScratch() is only used for testing code at the bottom.
// 

class DatabaseAdaptor {
  private $DB; // The instance variable used in every method below
  // Connect to an existing data based named 'first'
  public function __construct() {
    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $servername = $cleardb_url["host"];
    $username = $cleardb_url["user"];
    $password = $cleardb_url["pass"];
    $db = substr($cleardb_url["path"], 1);

    // Empty string with XAMPP install
    try {
        $this->DB = new PDO("mysql:dbname=$db;host=$servername", $username, $password);
        $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) {
        echo ('Error establishing Connection');
        exit ();
    }
  }
    
// This function exists only for testing purposes. Do not call it any other time.
public function startFromScratch() {
  //$stmt = $this->DB->prepare("DROP DATABASE IF EXISTS quotes;");
  //$stmt->execute();
       
  // This will fail unless you created database quotes inside MariaDB.
  $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $db_name = substr($cleardb_url["path"], 1);

  $stmt = $this->DB->prepare("use " . $db_name . ";");
  $stmt->execute();

  $stmt = $this->DB->prepare("DROP TABLE IF EXISTS quotations;");
  $stmt->execute();
  $stmt = $this->DB->prepare("DROP TABLE IF EXISTS users;");
  $stmt->execute();
        
  $update = " CREATE TABLE quotations ( " .
            " id int(20) NOT NULL AUTO_INCREMENT, added datetime, quote varchar(2000), " .
            " author varchar(100), rating int(11), flagged tinyint(1), PRIMARY KEY (id));";       
  $stmt = $this->DB->prepare($update);
  $stmt->execute();
                
  $update = "CREATE TABLE users ( ". 
            "id int(6) unsigned AUTO_INCREMENT, username varchar(64),
            password varchar(255), PRIMARY KEY (id) );";    
  $stmt = $this->DB->prepare($update);
  $stmt->execute(); 
}
    

// ^^^^^^^ Keep all code above for testing  ^^^^^^^^^


/////////////////////////////////////////////////////////////
// Complete these five straightfoward functions and run as a CLI application


    public function getAllQuotations() {
        $query = "SELECT * FROM quotations;";
        $stmt = $this->DB->prepare($query);
        $stmt->execute();
        $arr =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }
    
    public function getAllUsers(){
        $query = "SELECT * FROM users;";
        $stmt = $this->DB->prepare($query);
        $stmt->execute();
        $arr =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }
    
    public function addQuote($quote, $author) {
        $query = "INSERT INTO quotations (added, quote, author, rating, flagged) VALUES (now(), :quote, :author, 0, 0);";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(":quote" , $quote, PDO::PARAM_STR);
        $stmt->bindParam(":author", $author, PDO::PARAM_STR);
        $stmt->execute();
    }
    
    public function addUser($accountname, $psw){
        $query = "INSERT INTO users (username, password) VALUES ( :accountname, :psw );";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(":accountname" , $accountname, PDO::PARAM_STR);
        $stmt->bindParam(":psw", $psw, PDO::PARAM_STR);
        $stmt->execute();
    }   

    public function userExists($username) {
        $query = "SELECT * FROM users WHERE username = :username ;";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(":username" , $username, PDO::PARAM_STR);
        $stmt->execute();
        $arr =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($arr) {
            return true;
        }
        return false;
    }
    public function verifyCredentials($accountName, $psw){
        $query = "SELECT password FROM users WHERE username = :accountName ;";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(":accountName" , $accountName, PDO::PARAM_STR);
        $stmt->execute();
        $arr =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0 ; $i < count ($arr) ; $i++) {
            if (password_verify($psw, $arr[$i]["password"])) {
                return true;
            }
        }
        return false;
    }

    public function incrementQuote($id) {
        $query = "UPDATE quotations SET rating = rating + 1 WHERE id = :id ;";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(":id" , $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function decrementQuote($id) {
        $query = "UPDATE quotations SET rating = rating - 1 WHERE id = :id ;";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(":id" , $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteQuote($id) {
        $query = "DELETE FROM quotations WHERE id= :id ;";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(":id" , $id, PDO::PARAM_INT);
        $stmt->execute();
    }

}  // End class DatabaseAdaptor


?>
