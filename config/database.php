<?php

class Dbconfig {
  protected $host = "localhost";
  protected $user = "Andrei";
  protected $pass = "123456";
  protected $name = "php_dev";

  public $conn = null;

  public function __construct(){
    // Creare conexiun
    $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
    // Verificare conexiune
    if ($this->conn->connect_error) {
      die('Connection failed: ' . $this->conn->connect_error);
    }
  }
}

?>
