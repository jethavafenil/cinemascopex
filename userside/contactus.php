<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'C:\xampp\htdocs\project81\config.php';

if (!isset($_SESSION['id'])) {
    echo "<script>alert('User not sign in'); window.location.href='login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Cinemascope</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center text-white">Contact Us</h1>
        <p class="text-center text-white">We'd love to hear from you! Please fill out the form below to get in touch with us.</p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST">
                    <div class="form-group">
                        <label for="name" class="text-white">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="text-white">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message" class="text-white">Message</label>
                        <textarea class="form-control" id="message" name="mes" rows="5" required></textarea>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mes = $_POST['mes'];
    $query = "INSERT INTO `contact` (`name`, `email`, `mes`) VALUES ('$name', '$email', '$mes')";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "<script>Swal.fire({
          title: 'Request Submitted!',
          text: 'We will work on your request',
          icon: 'success'
        });</script>";
    } else {
        echo "<script>Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!'
        });</script>";
    }
}
?>