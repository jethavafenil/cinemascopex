<?php
include('C:\xampp\htdocs\project81\config.php');

if(isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];

    $query="INSERT INTO `admins`(`uname`, `pwd`, `email`) VALUES ('$uname','$pwd','$email')";
    $run=mysqli_query($con,$query);

    if($run){
        echo "<script>alert('Sign Up Successfully');
              window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Sign Up failed. Check your username and password');
              window.location.href='register.php';</script>";
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
            <div class="col-md-6">
                <div class="card mt-5 mb-5">
                    <div class="card-header">
                        <h3 class="text-center">Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="uname">Username</label>
                                <input type="text" class="form-control" id="uname" name="uname" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="pwd" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Sign Up</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php">Already have an account? Sign In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>