<?php
session_start();
include 'db.php';

// Handle login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // md5 hashed password
    $res = $conn->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");
    if ($res->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Educational institution Management System - Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg,#6a11cb 0%,#2575fc 100%);
        min-height: 100vh;
        margin: 0;
    }

    /* Login Card */
    .login-container {
        width: 400px;
        margin: 120px auto;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(20px);
        padding: 35px;
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        color: #fff;
    }
    .login-container h3 {
        text-align:center;
        margin-bottom:25px;
        font-weight:700;
    }
    .login-container input[type=text],
    .login-container input[type=password] {
        width:100%;
        padding:12px;
        margin:8px 0;
        border:none;
        border-radius:8px;
        background: rgba(255,255,255,0.2);
        color:#fff;
    }
    .login-container input[type=text]::placeholder,
    .login-container input[type=password]::placeholder {
        color: #e0e0e0;
    }
    .login-container input[type=submit] {
        width:100%;
        padding:12px;
        background:#4e73df;
        color:#fff;
        border:none;
        border-radius:8px;
        font-weight:600;
        transition:0.3s;
    }
    .login-container input[type=submit]:hover {
        background:#2e59d9;
        transform: scale(1.02);
    }

    /* Sidebar */
    .sidebar {
        height: 100vh;
        width: 250px;
        position: fixed;
        top: 0; left: 0;
        background: #1f1c2c;
        background: linear-gradient(135deg, #1f1c2c 0%, #928dab 100%);
        padding-top: 30px;
        color: #fff;
    }
    .sidebar h2 {
        text-align: center;
        font-size: 1.7rem;
        font-weight: 700;
        margin-bottom: 30px;
    }
    .sidebar a {
        display: flex;
        align-items:center;
        color: #cfd8dc;
        padding: 15px 20px;
        text-decoration: none;
        margin-bottom: 8px;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .sidebar a i {
        margin-right: 10px;
        font-size: 18px;
    }
    .sidebar a:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
        transform: translateX(5px);
    }

    /* Main content */
    .main-content {
        margin-left: 260px;
        padding: 40px;
    }

    header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #fff;
        text-align:center;
    }

    /* Dashboard cards */
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 25px;
        margin-top: 40px;
    }
    .card {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        padding: 25px 20px;
        text-align: center;
        box-shadow: 0 4px 25px rgba(0,0,0,0.15);
        transition: all 0.3s;
        color:#fff;
    }
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 35px rgba(0,0,0,0.3);
    }
    .card i {
        font-size: 45px;
        margin-bottom: 15px;
        color: #ffd369;
    }
    .card h3 {
        font-size: 1.4rem;
        margin-bottom: 10px;
    }
    .card p {
        font-size: 0.95rem;
        margin-bottom: 15px;
    }
    .card a {
        text-decoration: none;
        display: inline-block;
        background: #ffd369;
        color: #000;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 500;
        transition: 0.3s;
    }
    .card a:hover {
        background: #ffc107;
        transform: translateY(-2px);
    }

    /* Footer */
    footer {
        text-align: center;
        padding: 20px 10px;
        margin-top: 40px;
        color: #fff;
    }
    footer a {
        color: #ffd369;
        text-decoration: none;
    }

    .logout {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #e74c3c;
        color: #fff;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 5px;
        z-index:999;
        transition:0.3s;
    }
    .logout:hover { background:#c0392b; }

    @media(max-width:768px) {
        .sidebar { width: 100%; height: auto; position: relative; }
        .main-content { margin-left: 0; padding: 20px; }
    }
</style>
</head>
<body>

<?php if (!isset($_SESSION['admin'])): ?>
    <!-- Login Form -->
    <div class="login-container">
        <h3>Welcome To Educational institution Manage System</h3>
        <?php if (isset($error)) echo "<p style='color:#ffd369;text-align:center;'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
    </div>

<?php else: ?>
    <!-- Admin Panel -->
    <a href="?logout=true" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>

    <div class="sidebar">
        <h2>SVUM Academy</h2>
        <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="students.php"><i class="fa-solid fa-user-graduate"></i> Students</a>
        <a href="lecturers.php"><i class="fa-solid fa-chalkboard-user"></i> Lecturers</a>
        <a href="courses.php"><i class="fa-solid fa-book-open"></i> Courses</a>
        <a href="student_courses.php"><i class="fa-solid fa-link"></i> Enrollments</a>
    </div>

    <div class="main-content">
        <header>
            <h1>SVUM Academy Management System</h1>
        </header>

        <div class="dashboard-cards">
            <div class="card">
                <i class="fa-solid fa-user-graduate"></i>
                <h3>Students</h3>
                <p>Manage students: add, view, update, delete</p>
                <a href="students.php">Go to Students</a>
            </div>
            <div class="card">
                <i class="fa-solid fa-chalkboard-user"></i>
                <h3>Lecturers</h3>
                <p>Manage lecturers: add, view, update, delete</p>
                <a href="lecturers.php">Go to Lecturers</a>
            </div>
            <div class="card">
                <i class="fa-solid fa-book-open"></i>
                <h3>Courses</h3>
                <p>Manage courses: add, view, update, delete</p>
                <a href="courses.php">Go to Courses</a>
            </div>
            <div class="card">
                <i class="fa-solid fa-link"></i>
                <h3>Enrollments</h3>
                <p>Enroll students and manage enrollments</p>
                <a href="student_courses.php">Go to Enrollments</a>
            </div>
        </div>

        <footer>
            &copy; <?php echo date("Y"); ?> University Management System | Developed by 
            <a href="#">Sithija Vidusara</a>
        </footer>
    </div>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
