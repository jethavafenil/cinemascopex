<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginsuccesful'])) {
    echo "<script>alert('You need to login first');
          window.location.href='login.php';</script>";
    exit();
}
include('C:\xampp\htdocs\project81\config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center mt-3">
        <h3 class="display-6">Admin Panel</h3>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand d-lg" href="#">Hello, <?php echo htmlspecialchars($_SESSION['uname']); ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminlist.php">Admin List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="movie.php">Movie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category.php">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="analytics.php">Analytics</a>
                </li>
            </ul>
            <a class="nav-link logout-btn" href="logout.php">Logout</a>
        </div>
    </nav>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>