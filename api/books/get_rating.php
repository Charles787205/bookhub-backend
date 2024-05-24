<?php
require_once __DIR__ . "/../../models/book.php";


header('Content-Type: application/json');

$book_id = $_GET['book_id'];

$rating = Book::getRating($book_id);

echo json_encode($rating);
