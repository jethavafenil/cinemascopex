<?php
include 'C:\xampp\htdocs\project81\config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in to add movies to your watchlist.'); window.location.href='login.php';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $movie_id = intval($_GET['id']);
    $user_id = $_SESSION['id'];

    // Check if the movie is already in the watchlist
    $sql_check = "SELECT * FROM watchlist WHERE user_id = ? AND movie_id = ?";
    $stmt_check = $con->prepare($sql_check);
    $stmt_check->bind_param("ii", $user_id, $movie_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('This movie is already in your watchlist.'); window.location.href='watchlist.php';</script>";
    } else {
        // Add the movie to the watchlist
        $sql_insert = "INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)";
        $stmt_insert = $con->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $user_id, $movie_id);

        if ($stmt_insert->execute()) {
            echo "<script>alert('Movie added to your watchlist!'); window.location.href='watchlist.php';</script>";
        } else {
            echo "<script>alert('Failed to add movie to watchlist. Please try again.'); window.history.back();</script>";
        }
    }

    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        $action = "Added to Watchlist";
    
        $sql_log_activity = "INSERT INTO user_activity (user_id, action, movie_id) VALUES (?, ?, ?)";
        $stmt_log_activity = $con->prepare($sql_log_activity);
        $stmt_log_activity->bind_param("isi", $user_id, $action, $movie_id);
        $stmt_log_activity->execute();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='movies.php';</script>";
}
?>