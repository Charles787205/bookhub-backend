<?php
require_once __DIR__ . "/../../models/user.php";

header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $data = json_decode(file_get_contents("php://input"), true);
  $email = $data['email'];
  $password = $data['password'];
  $user = User::loginUser($email, $password);
  if ($user) {
    echo json_encode($user);
  } else {
    echo json_encode("null");
  }
}
