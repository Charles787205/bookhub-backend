<?php
require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/book.php";
class BorrowedBooks
{

  public $request_id, $book_id, $borrowed_at, $returned_at, $status, $due_date, $book, $request, $id;

  public static function getBorrowedBooks()
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT borrowed_books.*, br.user_id, br.book_id FROM borrowed_books INNER JOIN borrow_request AS br ON borrowed_books.request_id = br.id WHERE returned_at IS NULL";
    $result = $conn->query($query);
    $borrowed_books = [];
    while ($borrowed_book = $result->fetch_object('BorrowedBooks')) {
      array_push($borrowed_books, $borrowed_book);
    }
    $conn->close();
    return $borrowed_books;
  }
  public static function getBorrowedBooksByUserId($userId)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT borrowed_books.* FROM borrowed_books
     LEFT JOIN borrow_request as br ON br.id = borrowed_books.request_id 
     WHERE br.user_id = $userId AND returned_at IS NULL";
    $result = $conn->query($query);
    $borrowed_books = [];
    while ($borrowed_book = $result->fetch_object('BorrowedBooks')) {
      array_push($borrowed_books, $borrowed_book);
    }
    $conn->close();
    return $borrowed_books;
  }
  public static function addBorrowedBooks(BorrowedBooks $borrowed_book)
  {

    $db = new Database();
    $conn = $db->conn;
    $query = "INSERT INTO borrowed_books (request_id, borrowed_at, due_date) VALUES (?,?,?)";
    $sql = $conn->prepare($query);
    $sql->bind_param('iss', $borrowed_book->request_id,  $borrowed_book->borrowed_at, $borrowed_book->due_date);
    $sql->execute();
    $conn->close();
  }
  public static function getReturnedBooksByUserId($userId)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT borrowed_books.* FROM borrowed_books
     INNER JOIN borrow_request as br ON br.id = borrowed_books.request_id 
     WHERE br.user_id = $userId AND returned_at IS NOT NULL";
    $result = $conn->query($query);
    $borrowed_books = [];
    while ($borrowed_book = $result->fetch_object('BorrowedBooks')) {
      array_push($borrowed_books, $borrowed_book);
    }
    $conn->close();
    return $borrowed_books;
  }
  public static function returnBook($id)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "UPDATE borrowed_books SET returned_at = CURRENT_TIMESTAMP WHERE id = $id";
    $conn->query($query);
    $conn->close();
  }
  public static function getReturnedBooks()
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT borrowed_books.*, br.user_id, br.book_id FROM borrowed_books INNER JOIN borrow_request AS br ON borrowed_books.request_id = br.id WHERE returned_at IS NOT NULL";
    $result = $conn->query($query);
    $borrowed_books = [];
    while ($borrowed_book = $result->fetch_object('BorrowedBooks')) {
      array_push($borrowed_books, $borrowed_book);
    }
    $conn->close();
    return $borrowed_books;
  }

  public static function getDueBooks($user_id)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT borrowed_books.*, br.user_id, br.book_id FROM borrowed_books INNER JOIN borrow_request AS br ON borrowed_books.request_id = br.id WHERE returned_at IS NULL AND br.user_id = $user_id";
    $result = $conn->query($query);
    $borrowed_books = [];
    while ($borrowed_book = $result->fetch_object('BorrowedBooks')) {
      array_push($borrowed_books, $borrowed_book);
    }
    $conn->close();
    return $borrowed_books;
  }
  public static function getDueCount($user_id)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT COUNT(*) as due_count FROM borrowed_books INNER JOIN borrow_request AS br ON borrowed_books.request_id = br.id WHERE returned_at IS NULL AND br.user_id = $user_id AND due_date <= CURRENT_TIMESTAMP";
    $result = $conn->query($query);
    $due_count = $result->fetch_object();
    $conn->close();
    return $due_count;
  }
}
