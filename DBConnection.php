<?php
$db = parse_ini_file(dirname(__DIR__) . "/AdmissionTech-api/DbProperties.ini");
class DBConnection
{
  public $dbname;
  public $password;
  public $username;
  public $servername;
  public $con = null;
  public $userData = null;

  public  function __construct($db)
  {
    $this->username = $db['username'];
    $this->dbname =  $db['databasename'];
    $this->password = $db['password'];
    $this->servername = $db['servername'];
  }

  function getConnection()
  {
    $this->con = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    return $this->con;
  }
  function closeConnection()
  {
    return $this->con->close();
  }
  function getUserData($data)
  {
    foreach (getallheaders() as $name => $value) {
      if (strtoupper($name) == strtoupper($data)) {
        $this->userData =  $value;
      }
    }
    return $this->userData;
  }
}
