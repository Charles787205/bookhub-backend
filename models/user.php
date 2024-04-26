<?php
require_once __DIR__ . "/../database.php";

class User
{
  public $first_name, $middle_name, $last_name, $email, $password, $created_at;

  public function getFullName()
  {
    return ucfirst($this->first_name) . " " . ucfirst($this->middle_name) . " " . ucfirst($this->last_name);
  }
  public function setUser($first_name, $middle_name, $last_name, $email, $password)
  {
    $this->first_name = $first_name;
    $this->middle_name = $middle_name;
    $this->last_name = $last_name;
    $this->email = $email;
    $this->password = $password;
  }

  public static function registerUser(User $user)
  {
    $db = new Database();
    $conn = $db->conn;
    $user->password = md5($user->password);
    $query = "INSERT INTO users (first_name, middle_name, last_name, email, password) VALUES ('$user->first_name', '$user->middle_name', '$user->last_name', '$user->email', '$user->password')";
    if ($conn->execute_query($query)) {
      $insertedUserId = $conn->insert_id;
      error_log($insertedUserId);
      $insertedUser = self::getUserById($insertedUserId);
      $conn->close();
      return $insertedUser;
    } else {
      $conn->close();
      return false;
    }
  }

  public static function getUserById($userId)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM users WHERE id = $userId";
    error_log($query);
    $result = $conn->query($query);


    // Instantiate User object with fetched data
    $user = $result->fetch_object('User');
    $conn->close();
    return $user;
  }
  public static function loginUser($email, $password)
  {
    /**
     * returns user object if user exists, else returns false */
    $db = new Database();
    $conn = $db->conn;
    $password = md5($password);
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    if ($result = $conn->query($query)) {
      $user = $result->fetch_object('User');
      $conn->close();
      return $user;
    } else {
      $conn->close();
      return false;
    }
  }
  public static function getUser($email)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $conn->close();
    return $result;
  }
}
