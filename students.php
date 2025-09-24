<?php 
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit();
}
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    <a class="navbar-brand fw-bold"><i class="fa-solid fa-user-graduate"></i> Student Management</a>
    <div class="ms-auto d-flex gap-2">
      <a href="index.php" class="btn btn-light btn-sm"><i class="fa-solid fa-arrow-left"></i> Back</a>
      <a href="index.php?logout=1" class="btn btn-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
  </div>
</nav>

<div class="container py-4">

  <!-- Add Student Form -->
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title mb-3"><i class="fa-solid fa-plus"></i> Add New Student</h5>
      <form method="post" class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" placeholder="Enter name" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" placeholder="Enter phone">
        </div>
        <div class="col-md-2">
          <label class="form-label">Department</label>
          <input type="text" name="department" class="form-control" placeholder="Enter department">
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" name="add_student" class="btn btn-success w-100"><i class="fa-solid fa-plus"></i> Add</button>
        </div>
      </form>
    </div>
  </div>

  <!-- PHP CRUD -->
  <div class="mb-3">
    <?php
    if (isset($_POST['add_student'])) {
        $name = $_POST['name']; 
        $email = $_POST['email'];
        $phone = $_POST['phone']; 
        $department = $_POST['department'];
        $conn->query("INSERT INTO students (name, email, phone, department) 
                      VALUES ('$name','$email','$phone','$department')");
        echo "<div class='alert alert-success'>✅ Student Added!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }
    if (isset($_POST['update_student'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];
        $conn->query("UPDATE students SET name='$name', email='$email', phone='$phone', department='$department' WHERE id=$id");
        echo "<div class='alert alert-success'>✅ Student Updated!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }
    if (isset($_POST['delete_student'])) {
        $del_id = $_POST['del_id'];
        $conn->query("DELETE FROM students WHERE id=$del_id");
        echo "<div class='alert alert-danger'>🗑️ Student Deleted!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }
    ?>
  </div>

  <!-- Display Students Table -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title mb-3"><i class="fa-solid fa-table"></i> All Students</h5>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Department</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $res = $conn->query("SELECT * FROM students");
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
                  <input type='text' name='phone' class='form-control form-control-sm' value='{$row['phone']}'>
              </td>
              <td>
                  <input type='text' name='department' class='form-control form-control-sm' value='{$row['department']}'>
              </td>
              <td>
                  <button type='submit' name='update_student' class='btn btn-sm btn-success'><i class='fa-solid fa-check'></i> Update</button>
                </form>
              </td>
              <td>
                <form method='post' onsubmit=\"return confirm('Are you sure you want to delete this student?');\">
                  <input type='hidden' name='del_id' value='{$row['id']}'>
                  <button type='submit' name='delete_student' class='btn btn-sm btn-danger'><i class='fa-solid fa-trash'></i> Delete</button>
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

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
