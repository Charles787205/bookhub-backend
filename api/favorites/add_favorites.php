<?php

require_once __DIR__ . "/../../models/book.php";
require_once __DIR__ . "/../../models/favorites.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'));
  $user_id = $data->user_id;

  $book_title = $data->book_title;
  $book_id = $data->book_id;
  $book_image = $data->book_image;

  Favorites::addFavorites($user_id, $book_id, $book_title, $book_image);

  echo json_encode(["user_id" => $user_id, "book_id" => $book_id, "book_title" => $book_title, "book_image" => $book_image]);
}
