<?php
require_once __DIR__ . "/../../models/user.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $data = json_decode(file_get_contents("php://input"), true);
  $email = $data['email'];
  $password = $data['password'];
  $first_name = $data['first_name'];
  $middle_name = $data['middle_name'];
  $last_name = $data['last_name'];
  $user = new User();
  $user->setUser($first_name, $middle_name, $last_name, $email, $password);
  $result = User::registerUser($user);
  echo json_encode($result);
}
