<?php
// Check if the session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include 'C:\xampp\htdocs\project81\config.php';

if (isset($_GET['id'])) {
    $movie_id = intval($_GET['id']);

    // Validate movie ID
    if ($movie_id <= 0) {
        echo "<script>alert('Invalid movie ID.'); window.location.href='movies.php';</script>";
        exit();
    }

    // Fetch movie details
    $sql = "SELECT m_name, vid FROM movies WHERE id = $movie_id";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        echo "<script>alert('Movie not found.'); window.location.href='movies.php';</script>";
        exit();
    }

    
    // Track movie views
   $sql_check_views = "SELECT * FROM movie_views WHERE movie_id = '$movie_id'";
   $result_check_views = $con->query($sql_check_views);
   
   if ($result_check_views->num_rows > 0) {
       // Increment view count
       $sql_update_views = "UPDATE movie_views SET view_count = view_count + 1 WHERE movie_id = '$movie_id'";
       $con->query($sql_update_views);
   } else {
       // Insert new record
       $sql_insert_views = "INSERT INTO movie_views (movie_id, view_count) VALUES ('$movie_id', 1)";
       $con->query($sql_insert_views);
   }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='movies.php';</script>";
    exit();
}

if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
   // Check if the movie is already in the recently watched list
   $sql_check = "SELECT * FROM recently_watched WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
   $result_check = $con->query($sql_check);

   if ($result_check->num_rows > 0) {
       // If the movie exists, update the watched_at timestamp
       $sql_update = "UPDATE recently_watched SET watched_at = NOW() WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
       if (!$con->query($sql_update)) {
           echo "Error updating recently watched: " . $con->error;
       }
   } else {
       // If the movie doesn't exist, insert a new record
       $sql_insert = "INSERT INTO recently_watched (user_id, movie_id) VALUES ('$user_id', '$movie_id')";
       if (!$con->query($sql_insert)) {
           echo "Error inserting into recently watched: " . $con->error;
       }
   }

    $user_id = $_SESSION['id'];
    $action = "Watched Movie";

    $sql_log_activity = "INSERT INTO user_activity (user_id, action, movie_id) VALUES (?, ?, ?)";
    $stmt_log_activity = $con->prepare($sql_log_activity);
    $stmt_log_activity->bind_param("isi", $user_id, $action, $movie_id);
    $stmt_log_activity->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['m_name']); ?> - Watch Now</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="./userside/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="watch-movie-page">
        <div class="container">
            <?php 
             if(!isset($_SESSION["id"]))
             {
                echo '<a href="login.php">Login</a> for watch recently watched movies';
             }
            ?>
            <h1 class="text-center"><?php echo htmlspecialchars($movie['m_name']); ?></h1>
            <a href="movies.php" class="btn btn-secondary">Back to Movies</a>
            <div class="embed-responsive embed-responsive-16by9 mt-4">
                <video class="embed-responsive-item" controls>
                    <source src="<?php echo htmlspecialchars($movie['vid']); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>