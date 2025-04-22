<?php
include('C:\xampp\htdocs\project81\config.php');
$id = $_GET['id'];
$query = "DELETE FROM admins WHERE id = '$id'";
$run = mysqli_query($con, $query);
if ($run) {
    echo "<script>alert('Admin Deleted Successfully');
          window.location.href='adminlist.php';</script>";
} else {
    echo "<script>alert('Admin Deletion failed');
          window.location.href='adminlist.php';</script>";
}   
?>