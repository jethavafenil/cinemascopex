<?php
include 'C:\xampp\htdocs\project81\config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in to view your watchlist.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];

// Fetch movies in the user's watchlist
$sql = "SELECT movies.* FROM movies 
        JOIN watchlist ON movies.id = watchlist.movie_id 
        WHERE watchlist.user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

include('header.php');
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">My Watchlist</h2>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card h-100 shadow-sm">';
                echo '<img src="../thumb/' . htmlspecialchars($row['img']) . '" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">';
                echo '<div class="card-body d-flex flex-column">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['m_name']) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars(substr($row['m_des'], 0, 100)) . '...</p>';
                echo '<div class="mt-auto">';
                echo '<a href="movie_detail.php?id=' . $row['id'] . '" class="btn btn-info btn-sm">Read More</a> ';
                echo '<a href="watch_movie.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Watch Now</a>';
                echo '<form action="remove_from_watchlist.php" method="POST" class="mt-2">';
                echo '<input type="hidden" name="movie_id" value="' . $row['id'] . '">';
                echo '<button type="submit" class="btn btn-danger btn-sm">Remove from Watchlist</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12">';
            echo '<p class="text-center text-muted">Your watchlist is empty. Start adding movies now!</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>