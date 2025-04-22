<?php
include('C:\xampp\htdocs\project81\config.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM movies WHERE id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Movie Deleted Successfully');window.location.href='movie.php';</script>";
    } else {
        echo "<script>alert('Movie Not Deleted');window.location.href='movie.php';</script>";
    }
}
else {
    echo "<script>alert('Go To Movie Page For Delete Movie');window.location.href='movie.php';</script>";
    exit();
}
?>