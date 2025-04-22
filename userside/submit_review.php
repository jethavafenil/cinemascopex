<?php
include('C:\xampp\htdocs\project81\config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['id'];
    $movie_id = $_POST['movie_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $sql = "INSERT INTO reviews (user_id, movie_id, rating, review) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iiis", $user_id, $movie_id, $rating, $review);

    if ($stmt->execute()) {
        header('Location: movie_detail.php?id=' . $movie_id);
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request.";
}
?>