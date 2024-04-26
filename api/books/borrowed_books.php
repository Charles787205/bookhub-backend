<?php
require_once __DIR__ . "/../../models/borrowed_books.php";
require_once __DIR__ . "/../../models/book.php";

header('Content-Type: application/json');
if (isset($_GET['user_id'])) {
  $borrowed_books = BorrowedBooks::getBorrowedBooksByUserId($_GET['user_id']);
  $bbooks = [];
  foreach ($borrowed_books as $borrowed_book) {
    $book = Book::getBookByRequestId($borrowed_book->request_id);
    $borrowed_book->book = $book;
    array_push($bbooks, $borrowed_book);
  }

  return print(json_encode($bbooks));
}
