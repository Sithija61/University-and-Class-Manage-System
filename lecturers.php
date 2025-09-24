<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lecturer Management</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
    }

    h2 {
      font-weight: 700;
      color: #fff;
      text-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .card {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(12px);
      border: none;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .card .card-title {
      font-weight: 600;
      color: #fff;
    }

    .form-control, .form-select {
      background: rgba(255,255,255,0.2);
      border: none;
      color: black;
    }

    .form-control::placeholder {
      color: black;
    }

    .form-control:focus {
      background: rgba(255,255,255,0.3);
      color: #ff0d0dff;
      box-shadow: none;
    }

    .btn-primary {
      background-color: #ffd369;
      border: none;
      color: #000;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #ffc107;
      transform: translateY(-2px);
    }

    .btn-success {
      background: #28a745;
      border: none;
      color: #fff;
      font-weight: 600;
    }

    .btn-success:hover {
      background: #1e7e34;
    }

    .btn-danger {
      background: #dc3545;
      border: none;
      color: #fff;
      font-weight: 600;
    }

    .btn-danger:hover {
      background: #b02a37;
    }

    table {
      color: #fff;
    }

    .table thead th {
      background-color: rgba(255,255,255,0.2) !important;
      color: #ffd369;
      border: none;
    }

    .table tbody tr {
      transition: 0.3s;
    }

    .table tbody tr:hover {
      background-color: rgba(255,255,255,0.1);
    }

    .badge.bg-primary {
      background-color: #ffd369 !important;
      color: #000;
      font-size: 0.85rem;
      border-radius: 30px;
      padding: 6px 12px;
    }

    .btn-sm {
      border-radius: 30px;
      font-weight: 600;
    }

    .alert {
      backdrop-filter: blur(5px);
      border-radius: 12px;
      font-weight: 500;
    }

    .table-responsive {
      border-radius: 15px;
      overflow: hidden;
    }

    .navbar { background:#2e3a59; }
    .navbar-brand, .nav-link { color:#fff !important; }
    .navbar-brand:hover, .nav-link:hover { color:#d1d1d1 !important; }
  </style>
</head>
<body>
  <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
  <a class="navbar-brand fw-bold">👨‍🏫 Lecturer Management</a>
    <div class="ms-auto d-flex gap-2">
      <a href="index.php" class="btn btn-light btn-sm"><i class="fa-solid fa-arrow-left"></i> Back</a>
      <a href="index.php?logout=1" class="btn btn-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
  </div>
</nav>
 <br><br><br>

  <!-- ADD LECTURER FORM -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <h4 class="card-title mb-3">Add New Lecturer</h4>
      <form method="post" class="row g-3">
        <div class="col-md-4">
          <input type="text" name="name" class="form-control" placeholder="Full Name" required>
        </div>
        <div class="col-md-4">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-3">
          <input type="text" name="faculty" class="form-control" placeholder="Faculty" required>
        </div>
        <div class="col-md-1">
          <button type="submit" name="add_lecturer" class="btn btn-primary w-100">Add</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table Card -->
  <div class="card shadow-lg">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Faculty</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $res = $conn->query("SELECT * FROM lecturers");
            while($row = $res->fetch_assoc()) {
              echo "<tr>
              <td>{$row['id']}</td>
              <td>
                <form method='post' class='d-flex gap-2'>
                  <input type='hidden' name='id' value='{$row['id']}'>
                  <input type='text' name='name' class='form-control form-control-sm' value='{$row['name']}' required>
              </td>
              <td>
                  <input type='email' name='email' class='form-control form-control-sm' value='{$row['email']}' required>
              </td>
              <td>
                  <input type='text' name='faculty' class='form-control form-control-sm' value='{$row['faculty']}' required>
              </td>
              <td>
                  <button type='submit' name='update_lecturer' class='btn btn-sm btn-success'>Update</button>
                </form>
              </td>
              <td>
                <form method='post' onsubmit=\"return confirm('Are you sure you want to delete this lecturer?');\">
                  <input type='hidden' name='del_id' value='{$row['id']}'>
                  <button type='submit' name='delete_lecturer' class='btn btn-sm btn-danger'>Delete</button>
                </form>
              </td>
              </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Feedback Messages -->
  <div class="mt-3">
    <?php
    // ADD Lecturer
    if (isset($_POST['add_lecturer'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $faculty = $_POST['faculty'];
        $conn->query("INSERT INTO lecturers (name, email, faculty) VALUES ('$name', '$email', '$faculty')");
        echo "<div class='alert alert-primary'>✅ New Lecturer Added!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }

    // Update Lecturer (all fields)
    if (isset($_POST['update_lecturer'])) {
        $id = $_POST['id']; 
        $name = $_POST['name'];
        $email = $_POST['email'];
        $faculty = $_POST['faculty'];
        $conn->query("UPDATE lecturers SET name='$name', email='$email', faculty='$faculty' WHERE id=$id");
        echo "<div class='alert alert-success'>✅ Lecturer Updated!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }

    // Delete Lecturer
    if (isset($_POST['delete_lecturer'])) {
        $del_id = $_POST['del_id'];
        $conn->query("DELETE FROM lecturers WHERE id=$del_id");
        echo "<div class='alert alert-danger'>🗑️ Lecturer Deleted!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }
    ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
