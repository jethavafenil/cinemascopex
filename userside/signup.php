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

if(isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailRun = mysqli_query($con, $checkEmailQuery);

    if(mysqli_num_rows($checkEmailRun) > 0) {
        echo "<script>alert('Email already exists. Please use a different email.');
              window.location.href='signup.php';</script>";
    } else {
        $query = "INSERT INTO `users`(`uname`, `pwd`, `email`) VALUES ('$uname','$pwd','$email')";
        $run = mysqli_query($con, $query);

        if($run){
            echo "<script>alert('Sign Up Successfully');
                  window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Sign Up failed. Please try again.');
                  window.location.href='signup.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Movies Watch Website</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <?php include "header.php"; ?>  
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5 mb-5">
                    <div class="card-header text-center">
                        <h4>Sign Up</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="uname" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="pwd" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Sign Up">
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Already have an account? <a href="login.php">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>