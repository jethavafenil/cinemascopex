<?php
session_start();
include('C:\xampp\htdocs\project81\config.php');

if (isset($_SESSION['loginsuccesful'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];

    $query = "SELECT * FROM admins WHERE uname = '$uname' AND pwd = '$pwd'";
    $run = mysqli_query($con, $query);

    if (mysqli_num_rows($run) > 0) {
        $_SESSION['loginsuccesful'] = 1;
        $_SESSION['uname'] = $uname;
        echo "<script>alert('Signin Successfully');
              window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Signin failed. Check your username and password');
              window.location.href='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Movies Watch Website</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sign.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5 mb-5">
                    <div class="card-header">
                        <h3 class="text-center">Sign In</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="uname">Username</label>
                                <input type="text" class="form-control" id="uname" name="uname" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="pwd" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Sign In</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="register.php">Don't have an account? Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>