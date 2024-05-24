<?php
require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/book.php";

class Favorites
{

  public $book, $user_id, $book_id, $id;

  public static function getFavoritesByUserId($userId)
  {
    $db = new Database();
    $conn = $db->conn;
    $query = "SELECT * FROM favorites WHERE user_id = $userId";
    $result = $conn->query($query);
    $books = [];
    while ($favorite = $result->fetch_object('Favorites')) {
      $books[] = Book::getBookById($favorite->book_id);
    }
    $conn->close();
    return $books;
  }

  public static function addFavorites($userId, $bookId, $title, $image)
  {
    $db = new Database();
    $book = new Book();
    $book->id = $bookId;
    $book->title = $title;
    $book->image = $image;
    Book::createBook($book);
    $conn = $db->conn;
    $query = "INSERT INTO favorites (user_id, book_id) VALUES (?,?)";
    $sql = $conn->prepare($query);
    $sql->bind_param('is', $userId, $bookId);
    $sql->execute();
    $conn->close();
  }
}
