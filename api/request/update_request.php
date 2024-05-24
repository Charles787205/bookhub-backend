<?php
require_once __DIR__ . "/../../models/book_request.php";
require_once __DIR__ . "/../../models/borrowed_books.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $request_id = $_POST['request_id'];
  BookRequest::updateRequest($request_id, $_POST['status']);
  if ($_POST['status'] == 'approved') {
    $request = BookRequest::getRequestById($request_id);
    $borrowed_book = new BorrowedBooks();
    $borrowed_book->request_id = $request_id;
    $borrowed_book->book_id = $request->book_id;
    $borrowed_book->borrowed_at = date('Y-m-d');
    $borrowed_book->due_date = date('Y-m-d', strtotime(" + $request->duration_no $request->duration_unit"));

    BorrowedBooks::addBorrowedBooks($borrowed_book);
  }
  return header('Location: /bookhub/admin/index.php');
}
