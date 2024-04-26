<?php
require_once __DIR__ . "/../../models/borrowed_books.php";
require_once __DIR__ . "/../../models/book.php";

header('Content-Type: application/json');
if (isset($_GET['user_id'])) {
  $dueCount = BorrowedBooks::getDueCount($_GET['user_id']);



  return print(json_encode($dueCount));
}
