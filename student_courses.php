<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student–Course Management</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg">
  <div class="container">
  <a class="navbar-brand fw-bold">🎓 Student–Course Management</a>
    <div class="ms-auto d-flex gap-2">
      <a href="index.php" class="btn btn-light btn-sm"><i class="fa-solid fa-arrow-left"></i> Back</a>
      <a href="index.php?logout=1" class="btn btn-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
  </div>
</nav>
 <br><br><br>

<div class="container py-4">

  <!-- Enroll Student Form -->
  <div class="card shadow-lg mb-4">
    <div class="card-body">
      <h5 class="card-title mb-3">➕ Enroll Student to Course</h5>
      <form method="post" class="row g-3">
        <div class="col-md-5">
          <label class="form-label">Student ID</label>
          <input type="number" name="student_id" class="form-control" placeholder="Enter Student ID" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Course</label>
          <select name="course_id" class="form-control" required>
            <option value="">Select Course</option>
            <?php
            $courses = $conn->query("SELECT course_id, course_name FROM courses");
            while ($c = $courses->fetch_assoc()) {
                echo "<option value='{$c['course_id']}'>{$c['course_name']} (ID: {$c['course_id']})</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" name="enroll" class="btn btn-success w-100">Enroll</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Feedback Messages -->
  <div class="mb-3">
    <?php
    // Enroll Student
    if (isset($_POST['enroll'])) {
        $student_id = $_POST['student_id']; 
        $course_id = $_POST['course_id'];
        $check_student = $conn->query("SELECT * FROM students WHERE id=$student_id");
        if($check_student->num_rows == 0){
            echo "<div class='alert alert-danger'>❌ Student ID not found!</div>";
        } else {
            $conn->query("INSERT INTO student_courses (student_id, course_id) VALUES ($student_id,$course_id)");
            echo "<div class='alert alert-success'>✅ Student enrolled successfully!</div>";
            echo "<meta http-equiv='refresh' content='1'>";
        }
    }

    // Update Enrollment
    if (isset($_POST['update_enrollment'])) {
        $id = $_POST['enrollment_id']; 
        $new_course_id = $_POST['new_course_id'];
        $conn->query("UPDATE student_courses SET course_id=$new_course_id WHERE id=$id");
        echo "<div class='alert alert-success'>✅ Enrollment updated!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }

    // Delete Enrollment
    if (isset($_POST['delete_enrollment'])) {
        $id = $_POST['enrollment_id'];
        $conn->query("DELETE FROM student_courses WHERE id=$id");
        echo "<div class='alert alert-danger'>🗑️ Enrollment deleted!</div>";
        echo "<meta http-equiv='refresh' content='1'>";
    }
    ?>
  </div>

  <!-- Manage Enrollments Table -->
  <div class="card shadow-lg">
    <div class="card-body">
      <h5 class="card-title mb-3">⚙️ Manage Enrollments</h5>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th>Enrollment ID</th>
              <th>Student Name</th>
              <th>Student ID</th>
              <th>Course Name</th>
              <th>Course ID</th>
              <th>Update Course</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $res2 = $conn->query("
              SELECT sc.id AS enrollment_id, s.id AS student_id, s.name AS student_name, 
                     c.course_id, c.course_name
              FROM student_courses sc
              JOIN students s ON sc.student_id = s.id
              JOIN courses c ON sc.course_id = c.course_id
            ");
            while($row = $res2->fetch_assoc()) {
              echo "<tr>
              <td>{$row['enrollment_id']}</td>
              <td>{$row['student_name']}</td>
              <td>{$row['student_id']}</td>
              <td>{$row['course_name']}</td>
              <td>{$row['course_id']}</td>
              <td>
                <form method='post' class='d-flex gap-2'>
                  <input type='hidden' name='enrollment_id' value='{$row['enrollment_id']}'>
                  <select name='new_course_id' class='form-control form-control-sm' required>
                    <option value=''>Select Course</option>";
                    $courses2 = $conn->query("SELECT course_id, course_name FROM courses");
                    while ($c2 = $courses2->fetch_assoc()) {
                        $selected = $c2['course_id'] == $row['course_id'] ? "selected" : "";
                        echo "<option value='{$c2['course_id']}' $selected>{$c2['course_name']} (ID: {$c2['course_id']})</option>";
                    }
              echo "</select>
                  <button type='submit' name='update_enrollment' class='btn btn-sm btn-success'>Update</button>
                </form>
              </td>
              <td>
                <form method='post' onsubmit=\"return confirm('Are you sure you want to delete this enrollment?');\">
                  <input type='hidden' name='enrollment_id' value='{$row['enrollment_id']}'>
                  <button type='submit' name='delete_enrollment' class='btn btn-sm btn-danger'>Delete</button>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
