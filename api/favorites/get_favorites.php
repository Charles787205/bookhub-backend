<?php

require_once __DIR__ . "/../../models/favorites.php";

header('Content-Type: application/json');


$userId = $_GET['user_id'];

$books = Favorites::getFavoritesByUserId($userId);

echo json_encode($books);
