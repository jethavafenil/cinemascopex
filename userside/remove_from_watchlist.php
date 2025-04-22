<?php
include 'C:\xampp\htdocs\project81\config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in to remove movies from your watchlist.'); window.location.href='login.php';</script>";
    exit();
}

if (isset($_POST['movie_id'])) {
    $movie_id = intval($_POST['movie_id']);
    $user_id = $_SESSION['id'];

    // Remove the movie from the watchlist
    $sql_delete = "DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $user_id, $movie_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Movie removed from your watchlist!'); window.location.href='watchlist.php';</script>";
    } else {
        echo "<script>alert('Failed to remove movie from watchlist. Please try again.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='watchlist.php';</script>";
}
?>