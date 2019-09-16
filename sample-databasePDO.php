<?php
// Singleton to connect db.
class ConnectDb {
  // Hold the class instance.
  private static $instance = null;
  private $conn;
  private $db_host = 'localhost';
  private $db_user = 'db user-name';
  private $db_pass = 'db password';
  private $db_name = 'db name';
   
  // The db connection is established in the private constructor.
  private function __construct()
  {
    $this->conn = new PDO("mysql:host={$this->db_host};
    dbname={$this->db_user}", $this->user,$this->db_pass,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  }
  
  public static function getInstance()
  {
    if(!self::$instance)
    {
      self::$instance = new ConnectDb();
    }
   
    return self::$instance;
  }
  
  public function getConnection()
  {
    return $this->conn;
  }
}
