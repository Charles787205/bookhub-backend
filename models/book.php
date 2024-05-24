<?php
require_once __DIR__ . "/../database.php";
class Book
{
  public $id, $title, $image;

  public static function getBooks()
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM books";
    $result = $conn->query($query);
    $books = [];
    while ($book = $result->fetch_object('Book')) {
      array_push($books, $book);
    }
    $conn->close();
    return $books;
  }
  public static function getBookById($bookId)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM books WHERE id = ?";
    $sql = $conn->prepare($query);
    $sql->bind_param('s', $bookId);
    $sql->execute();
    $result = $sql->get_result();
    $book = $result->fetch_object('Book');
    $conn->close();
    return $book;
  }
  public static function createBook(Book $book)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "INSERT INTO books (id, title, image) VALUES (?,?,?)";
    $sql = $conn->prepare($query);
    $sql->bind_param('sss', $book->id, $book->title, $book->image);
    if (!$insertedBook = self::getBookById($book->id)) {
      if ($sql->execute()) {
        $insertedBook = self::getBookById($book->id);
        $conn->close();
        return $insertedBook;
      } else {
        $conn->close();
        return false;
      }
    }
  }
  public static function isBookSaved($id)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM books WHERE id = ?";
    $sql = $conn->prepare($query);
    $sql->bind_param('s', $id);
    $sql->execute();
    $result = $sql->get_result();
    $book = $result->fetch_object('Book');
    $conn->close();
    if ($book) {
      return true;
    } else {
      return false;
    }
  }
  public static function getBookByRequestId($request_id)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT  * FROM books WHERE id = (SELECT book_id FROM borrow_request WHERE id = ?)";
    $sql = $conn->prepare($query);
    $sql->bind_param('s', $request_id);
    $sql->execute();
    $result = $sql->get_result();
    $book = $result->fetch_object('Book');
    $conn->close();
    return $book;
  }

  public function rate($rating, $user_id)
  {
    $db = new Database();
    $conn = $db->conn;
    if ($this->id != null) {

      $query = "INSERT INTO book_rating (book_id, rating, user_id) VALUES (?,?,?)";
      $sql = $conn->prepare($query);
      $sql->bind_param('ssi', $this->id, $rating, $user_id);
      $sql->execute();
      $conn->close();
    }
  }

  public static function getRating($book_id)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT AVG(rating) as rating FROM book_rating WHERE book_id = ?";
    $sql = $conn->prepare($query);
    $sql->bind_param('s', $book_id);
    $sql->execute();
    $result = $sql->get_result();
    $rating = $result->fetch_object();
    $conn->close();
    return $rating;
  }
}
