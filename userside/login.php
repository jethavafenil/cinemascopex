<?php
include('C:\xampp\htdocs\project81\config.php');

// Redirect to index.php if the user is already logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM users WHERE uname = ? AND pwd = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $uname, $pwd);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loginsuccessful'] = 1;
        $_SESSION['id'] = $row['id'];
        $_SESSION['uname'] = $uname;
        echo "<script>alert('Signin Successfully'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Signin failed. Check your username and password'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Movies Watch Website</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include "header.php";?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5 mb-5">
                    <div class="card-header text-center">
                        <h4>Sign In</h4>
                    </div>
                    <div class="card-body">
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <input type="text" name="uname" class="form-control" placeholder="Username" required>   
                            </div>
                            <div class="form-group">
                                <input type="password" name="pwd" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <div class="form-group text-center">
                                <a href="signup.php">Don't have an account? Sign Up</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <?php include "footer.php";?>
</body>
</html>