<?php
include('C:\xampp\htdocs\project81\config.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Delete associated records in the movie_categories table
        $sql1 = "DELETE FROM movie_categories WHERE category_id='$id'";
        mysqli_query($con, $sql1);

        // Delete the category
        $sql2 = "DELETE FROM category WHERE id='$id'";
        if(mysqli_query($con, $sql2)) {
            // Commit the transaction
            mysqli_commit($con);
            echo "<script>alert('Category Deleted Successfully');window.location.href='category.php';</script>";
        } else {
            // Rollback the transaction if the category deletion fails
            mysqli_rollback($con);
            echo "<script>alert('Category Not Deleted');window.location.href='category.php';</script>";
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of any error
        mysqli_rollback($con);
        echo "<script>alert('An error occurred. Category Not Deleted');window.location.href='category.php';</script>";
    }
} else {
    echo "<script>alert('Go To Category Page For Delete Category');window.location.href='category.php';</script>";
}
?>