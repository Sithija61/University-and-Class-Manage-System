<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Management</title>
  <!-- Bootstrap 5 CSS -->
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
  <a class="navbar-brand fw-bold"><i class="fa-solid fa-book-open"></i> Course Management</a>
    <div class="ms-auto d-flex gap-2">
      <a href="index.php" class="btn btn-light btn-sm"><i class="fa-solid fa-arrow-left"></i> Back</a>
      <a href="index.php?logout=1" class="btn btn-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
  </div>
</nav>
 <br><br><br>

<div class="container py-5">

  <!-- ADD COURSE FORM -->
  <div class="card shadow mb-5">
    <div class="card-body">
      <h4 class="card-title mb-4"><i class="fa-solid fa-circle-plus"></i> Add New Course</h4>
      <form method="post" class="row g-3">
        <div class="col-md-4">
          <input type="text" name="course_name" class="form-control" placeholder="Course Name" required>
        </div>
        <div class="col-md-2">
          <input type="number" name="credit_hours" class="form-control" placeholder="Credit Hours" min="0" required>
        </div>
        <div class="col-md-4">
          <select name="lecturer_id" class="form-select" required>
            <option value="">Select Lecturer</option>
            <?php
            $lecturers = $conn->query("SELECT * FROM lecturers");
            while ($lect = $lecturers->fetch_assoc()) {
                echo "<option value='{$lect['id']}'>{$lect['name']} ({$lect['faculty']})</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" name="add_course" class="btn btn-primary w-100"><i class="fa-solid fa-plus"></i> Add</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table Card -->
  <div class="card shadow-lg">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th>Course ID</th>
              <th>Course Name</th>
              <th>Credit Hours</th>
              <th>Lecturer</th>
              <th>Update Credit Hours</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $res = $conn->query("SELECT courses.course_id, courses.course_name, courses.credit_hours, lecturers.name as lecturer_name 
              FROM courses 
              LEFT JOIN lecturers ON courses.lecturer_id=lecturers.id");
            while($row = $res->fetch_assoc()) {
              echo "<tr>
              <td>{$row['course_id']}</td>
              <td>{$row['course_name']}</td>
              <td><span class='badge bg-primary'>{$row['credit_hours']} hrs</span></td>
              <td>{$row['lecturer_name']}</td>
              <td>
                <form method='post' class='d-flex gap-2'>
                  <input type='hidden' name='id' value='{$row['course_id']}'>
                  <input type='number' name='new_credits' class='form-control form-control-sm' placeholder='New Hours' min='0'>
                  <button type='submit' name='update_credits' class='btn btn-sm btn-success'><i class='fa-solid fa-check'></i></button>
                </form>
              </td>
              <td>
                <form method='post' onsubmit=\"return confirm('Are you sure you want to delete this course?');\">
                  <input type='hidden' name='del_id' value='{$row['course_id']}'>
                  <button type='submit' name='delete_course' class='btn btn-sm btn-danger'><i class='fa-solid fa-trash'></i></button>
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
    // ADD Course
    if (isset($_POST['add_course'])) {
        $course_name = $_POST['course_name'];
        $credit_hours = $_POST['credit_hours'];
        $lecturer_id = $_POST['lecturer_id'];
        $conn->query("INSERT INTO courses (course_name, credit_hours, lecturer_id) VALUES ('$course_name', $credit_hours, $lecturer_id)");
        echo "<div class='alert alert-primary text-center'>✅ New Course Added!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }

    // Update Credit Hours
    if (isset($_POST['update_credits'])) {
        $id = $_POST['id']; 
        $new_credits = $_POST['new_credits'];
        $conn->query("UPDATE courses SET credit_hours=$new_credits WHERE course_id=$id");
        echo "<div class='alert alert-success text-center'>✅ Credit Hours Updated!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }

    // Delete Course
    if (isset($_POST['delete_course'])) {
        $del_id = $_POST['del_id'];
        $conn->query("DELETE FROM courses WHERE course_id=$del_id");
        echo "<div class='alert alert-danger text-center'>🗑️ Course Deleted!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }
    ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
