<?php
require_once __DIR__ . "/../../models/book_request.php";
require_once __DIR__ . "/../../models/book.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'));
  $userId = $data->user_id;
  $duration_unit = $data->duration_unit;
  $duration_no = $data->duration_no;
  $book_title = $data->book_title;
  $bookId = $data->book_id;
  $book_image = $data->book_image;
  $book = new Book();

  $book->id = $bookId;
  $book->title = $book_title;
  $book->image = $book_image;

  $request = BookRequest::createRequest($userId, $book, $duration_no, $duration_unit);
  if ($request) {
    echo json_encode($request);
  } else {
    echo json_encode(['error' => 'Request not created']);
  }
}
