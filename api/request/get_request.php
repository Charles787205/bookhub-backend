<?php
require_once __DIR__ . "/../../models/book_request.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['user_id'])) {
    $requests = BookRequest::getRequestsByUserId($_GET['user_id']);
  } elseif (isset($_GET['request_id'])) {
    $requests = BookRequest::getRequestById($_GET['request_id']);
  } else {
    $requests = BookRequest::getRequests();
  }
  echo json_encode($requests);
}
