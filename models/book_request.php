<?php
require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/book.php";
require_once __DIR__ . "/user.php";
class BookRequest
{
  public $request_at, $status, $user_id, $book_id, $id, $user;
  public Book $book;
  public static function getRequests()
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM borrow_request";
    $result = $conn->query($query);
    $requests = [];
    while ($request = $result->fetch_object('BookRequest')) {
      array_push($requests, $request);
    }

    $conn->close();
    foreach ($requests as $request) {
      $request->user = User::getUserById($request->user_id);
    }
    foreach ($requests as $request) {
      $request->book = Book::getBookById($request->book_id);
    }
    return $requests;
  }
  public static function getRequestsByUserId($user_id)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM borrow_request WHERE user_id = $user_id";
    $result = $conn->query($query);
    $requests = [];
    while ($request = $result->fetch_object('BookRequest')) {
      array_push($requests, $request);
    }
    foreach ($requests as $request) {
      $request->user = User::getUserById($request->user_id);
    }
    foreach ($requests as $request) {
      $request->book = Book::getBookById($request->book_id);
    }
    $conn->close();
    return $requests;
  }
  public static function getRequestById($requestId)
  {
    $db = new Database();
    $conn = $db->conn;

    $query = "SELECT * FROM borrow_request WHERE id = $requestId";
    $result = $conn->query($query);
    $request = $result->fetch_object('BookRequest');
    $conn->close();
    return $request;
  }
  public static function createRequest($userId, Book $book, $duration_no, $duration_unit)
  {
    $db = new Database();
    $conn = $db->conn;
    if (Book::isBookSaved($book->id) == false) {
      Book::createBook($book);
    }
    $query = "INSERT INTO borrow_request (user_id, book_id, duration_no, duration_unit) VALUES (?,?,?,?)";
    $sql = $conn->prepare($query);
    $sql->bind_param('isis', $userId, $book->id, $duration_no, $duration_unit);

    if ($sql->execute()) {
      $insertedRequestId = $sql->insert_id;
      $insertedRequest = self::getRequestById($insertedRequestId);
      $conn->close();
      return $insertedRequest;
    } else {
      $conn->close();
      return false;
    }
  }
  public static function updateRequest($requestId, $status)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "UPDATE borrow_request SET status = '$status' WHERE id = $requestId";
    if ($conn->query($query)) {
      $updatedRequest = self::getRequestById($requestId);
      $conn->close();
      return $updatedRequest;
    } else {
      $conn->close();
      return false;
    }
  }
  public static function getPendingRequests()
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM borrow_request WHERE status = 'pending'";
    $result = $conn->query($query);
    $requests = [];
    while ($request = $result->fetch_object('BookRequest')) {
      array_push($requests, $request);
    }
    foreach ($requests as $request) {
      $request->user = User::getUserById($request->user_id);
    }
    foreach ($requests as $request) {
      $request->book = Book::getBookById($request->book_id);
    }
    $conn->close();
    return $requests;
  }
}
