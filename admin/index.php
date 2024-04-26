<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>BookHub</title>
</head>

<body>
  <?php include_once __DIR__ . "/components/navbar.php"; ?>

  <div class="container w-full flex justify-content-center">

    <div class="col">

      <h1>Pending Requests</h1>
      <table class="table  table-striped-columns">
        <tr>
          <th>Book</th>
          <th>User</th>
          <th>Duration</th>
          <th>Status</th>
          <th style="width:300px">Action</th>
        </tr>
        <?php
        require_once __DIR__ . "/../models/book_request.php";
        $requests = BookRequest::getPendingRequests();
        foreach ($requests as $request) :
        ?>
          <tr>
            <td><?= $request->book->title ?></td>
            <td><?= $request->user->getFullName() ?></td>
            <td><?= $request->duration_no . " " . $request->duration_unit ?></td>
            <td><?= $request->status ?></td>
            <td style=" display:flex; gap:10px;">
              <form action="/api/request/update_request.php" method="post" class="col">
                <input type="hidden" name="request_id" value="<?= $request->id ?>">

                <input type="hidden" name="status" value="approved">
                <button class="btn btn-primary" style="width:100%;">Approve</button>
              </form>
              <form action="/api/request/update_request.php" method="post" class="col">
                <input type="hidden" name="request_id" value="<?= $request->id ?>">
                <input type="hidden" name="status" value="rejected">
                <button class="btn btn-danger" style="width:100%;">Reject</button>
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