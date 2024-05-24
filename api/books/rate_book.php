<?php
require_once __DIR__ . "/../../models/book.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->book_id) && isset($data->user_id) && isset($data->rating)) {
    $book = Book::getBookById($data->book_id);
    if ($book) {
      $book->rate($data->user_id, $data->rating);
      echo json_encode(["message" => "Rating added successfully"]);
    } else {
      echo json_encode(["message" => "Book not found"]);
    }
  } else {
    echo json_encode(["message" => "All fields are required"]);
  }
}
