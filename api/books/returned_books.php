<?php
require_once __DIR__ . "/../../models/borrowed_books.php";

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'));
  $requestId = $data->request_id;
  $return_date = $data->return_date;
  $fine = $data->fine;
  //$returned_book = BorrowedBooks::returnBook($requestId, $return_date, $fine);
  //if ($returned_book) {
  //  echo json_encode($returned_book);
  //} else {
  //  echo json_encode(['error' => 'Book not returned']);
  //}
} else {
  if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $returned_books = BorrowedBooks::getReturnedBooksByUserId($user_id);
    foreach ($returned_books as $borrowed_book) {
      $book = Book::getBookByRequestId($borrowed_book->request_id);
      $borrowed_book->book = $book;
    }
    echo json_encode($returned_books);
  }
}
