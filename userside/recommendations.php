<?php
include('C:\xampp\htdocs\project81\config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

// Fetch movies from the user's watchlist
$sql_watchlist = "SELECT movie_id FROM watchlist WHERE user_id = ?";
$stmt_watchlist = $con->prepare($sql_watchlist);
$stmt_watchlist->bind_param("i", $user_id);
$stmt_watchlist->execute();
$result_watchlist = $stmt_watchlist->get_result();

$watchlist_movie_ids = [];
while ($row = $result_watchlist->fetch_assoc()) {
    $watchlist_movie_ids[] = $row['movie_id'];
}
$stmt_watchlist->close();

// Fetch recommended movies based on the watchlist
if (!empty($watchlist_movie_ids)) {
    $placeholders = implode(',', array_fill(0, count($watchlist_movie_ids), '?'));
    $types = str_repeat('i', count($watchlist_movie_ids));
    $sql_recommendations = "SELECT * FROM movies WHERE id NOT IN ($placeholders) ORDER BY RAND() LIMIT 10";
    $stmt_recommendations = $con->prepare($sql_recommendations);
    $stmt_recommendations->bind_param($types, ...$watchlist_movie_ids);
} else {
    // If the watchlist is empty, recommend random popular movies
    $sql_recommendations = "SELECT * FROM movies ORDER BY RAND() LIMIT 10";
    $stmt_recommendations = $con->prepare($sql_recommendations);
}

$stmt_recommendations->execute();
$result_recommendations = $stmt_recommendations->get_result();
$stmt_recommendations->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended Movies</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./userside/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Recommended Movies</h2>
        <div class="row">
            <?php
            if ($result_recommendations->num_rows > 0) {
                while ($row = $result_recommendations->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card h-100 shadow-sm">';
                    echo '<img src="../thumb/' . htmlspecialchars($row['img']) . '" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['m_name']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($row['m_des']) . '</p>';
                    echo '<div class="mt-auto">';
                    echo '<a href="movie_detail.php?id=' . $row['id'] . '" class="btn btn-info btn-sm">Read More</a> ';
                    echo '<a href="watch_movie.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Watch Now</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-md-12">';
                echo '<p class="text-center">No recommendations available.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>