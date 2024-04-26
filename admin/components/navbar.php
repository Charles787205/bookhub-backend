<?php
$uri = $_SERVER['REQUEST_URI'];
?>
<nav class="navbar navbar-expand-lg ">
  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li><a class="nav-item nav-link <?= str_contains($uri, "index") ? "active" : "" ?>" href="/admin/index.php">Requests</a></li>
    <li><a class="nav-item nav-link <?= str_contains($uri, "borrowed_books") ? "active" : "" ?>"" href=" /admin/borrowed_books.php">Borrowed Books</a></li>
    <li><a class="nav-item nav-link <?= str_contains($uri, "returned_books") ? "active" : "" ?>" href="/admin/returned_books.php">Returned Books</a></li>
  </ul>
</nav>