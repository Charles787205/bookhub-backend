<?php require_once __DIR__ . "/../models/borrowed_books.php";
require_once __DIR__ . "/../models/user.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $borrowed_book_id = $_POST['borrowed_book_id'];
  $status = $_POST['status'];
  BorrowedBooks::returnBook($borrowed_book_id);
  header('Location: /bookhub/admin/borrowed_books.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>BookHub </title>
</head>

<body>

  <?php include_once __DIR__ . "/components/navbar.php"; ?>
  <div class="container w-full flex justify-content-center">

    <div class="col">

      <h1>Borrowed Books</h1>
      <table class="table  table-striped-columns">
        <tr>
          <th>Book</th>
          <th>User</th>
          <th>Borrowed At</th>
          <th>Status</th>
          <th>Due Date</th>
          <th>Time Remaining</th>
          <th>Action</th>
        </tr>
        <?php

        $borrowed_books = BorrowedBooks::getBorrowedBooks();

        foreach ($borrowed_books as $borrowed_book) :
          $borrowed_book->book = Book::getBookByRequestId($borrowed_book->request_id);
          $borrowed_book->user = User::getUserById($borrowed_book->user_id);
          $remaining_date_interval = date_diff(date_create(), date_create($borrowed_book->due_date));
        ?>
          <tr>
            <td><?= $borrowed_book->book->title ?></td>
            <td><?= $borrowed_book->user->getFullName() ?></td>
            <td><?= date_format(date_create($borrowed_book->borrowed_at), "Y-m-d") ?></td>
            <td><?=
                $remaining_date_interval->format('%R%a') < 0 ? 'Overdue' : 'Pending'
                ?></td>

            <td><?= date_format(date_create($borrowed_book->due_date), "Y-m-d") ?></td>
            <td style="color:<?= $remaining_date_interval->format('%R%a') < 0 ? 'red' : 'green' ?>;">
              <?= $remaining_date_interval->format('%R%a days') ?></td>

            <td style=" display:flex; gap:10px;">
              <form action="/bookhub/admin/borrowed_books.php" method="post" class="col">
                <input type="hidden" name="borrowed_book_id" value="<?= $borrowed_book->id ?>">

                <input type="hidden" name="status" value="return">
                <button class="btn btn-primary" style="width:100%;">Return</button>
              </form>

            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>