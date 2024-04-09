<?php
class Database
{
  private $host = "localhost";
  private $db_name = "bookhub_db";
  private $username = "root";
  private $password = "";
  public $conn;

  function  __construct()
  {
    $this->conn = null;
    $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
  }
}
