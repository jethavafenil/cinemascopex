<?php
include 'C:\xampp\htdocs\project81\config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM movies WHERE id = $id";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();

        // Fetch associated categories
        $sql_categories = "SELECT c_name FROM category 
                           INNER JOIN movie_categories ON category.id = movie_categories.category_id 
                           WHERE movie_categories.movie_id = $id";
        $result_categories = $con->query($sql_categories);
        $categories = [];
        while ($row_category = $result_categories->fetch_assoc()) {
            $categories[] = $row_category['c_name'];
        }
        $categories_str = implode(", ", $categories);

        // Fetch reviews and ratings
        $sql_reviews = "SELECT reviews.*, users.uname FROM reviews JOIN users ON reviews.user_id = users.id WHERE movie_id = $id";
        $result_reviews = $con->query($sql_reviews);

        // Calculate average rating
        $sql_avg_rating = "SELECT AVG(rating) as avg_rating FROM reviews WHERE movie_id = $id";
        $result_avg_rating = $con->query($sql_avg_rating);
        $avg_rating = $result_avg_rating->fetch_assoc()['avg_rating'];
    } else {
        echo "Movie not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Check if the movie is already in the user's watchlist
$in_watchlist = false;
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $sql_watchlist = "SELECT * FROM watchlist WHERE user_id = ? AND movie_id = ?";
    $stmt_watchlist = $con->prepare($sql_watchlist);
    $stmt_watchlist->bind_param("ii", $user_id, $id);
    $stmt_watchlist->execute();
    $result_watchlist = $stmt_watchlist->get_result();
    if ($result_watchlist->num_rows > 0) {
        $in_watchlist = true;
    }
    $stmt_watchlist->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['m_name']); ?> - Movie Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./userside/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="movie-detail-page">
        <div class="container">
            <h1 class="text-center"><?php echo htmlspecialchars($movie['m_name']); ?></h1>
            <div class="row mt-4">
                <div class="col-md-6">
                    <img src="../thumb/<?php echo htmlspecialchars($movie['img']); ?>" class="img-fluid mdim" alt="<?php echo htmlspecialchars($movie['m_name']); ?>">
                </div>
                <div class="col-md-6">
                    <h2>Description</h2>
                    <p><?php echo htmlspecialchars($movie['m_des']); ?></p>
                    <h2>Details</h2>
                    <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                    <p><strong>Language:</strong> <?php echo htmlspecialchars($movie['lang']); ?></p>
                    <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['date']); ?></p>
                    <p><strong>Categories:</strong> <?php echo htmlspecialchars($categories_str); ?></p>
                    <p><strong>Average Rating:</strong> <?php echo round($avg_rating, 1); ?> / 5</p>
                    <a href="watch_movie.php?id=<?php echo htmlspecialchars($movie['id']); ?>" class="btn btn-primary">Watch Now</a>
                    <a href="movies.php" class="btn btn-secondary">Back to Movies</a>
                    <?php if (isset($_SESSION['id'])): ?>
                        <?php if ($in_watchlist): ?>
                            <form action="remove_from_watchlist.php" method="POST" class="d-inline">
                                <input type="hidden" name="movie_id" value="<?php echo $id; ?>">
                                <button type="submit" class="btn btn-danger">Remove from Watchlist</button>
                            </form>
                        <?php else: ?>
                            <a href="add_to_watchlist.php?id=<?php echo htmlspecialchars($movie['id']); ?>" class="btn btn-info">Add to watchlist</a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(!isset($_SESSION['id'])): ?>
                        <p class="mt-2">Please <a href="login.php">login</a> to add to watchlist.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Social Sharing Buttons -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3>Share this movie</h3>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://yourwebsite.com/movie_detail.php?id=' . $id); ?>" target="_blank" class="btn btn-primary">
                        <i class="fab fa-facebook-f"></i> Share on Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://yourwebsite.com/movie_detail.php?id=' . $id); ?>&text=<?php echo urlencode('Check out this movie: ' . $movie['m_name']); ?>" target="_blank" class="btn btn-info">
                        <i class="fab fa-twitter"></i> Share on Twitter
                    </a>
                    <a href="https://www.instagram.com/?url=<?php echo urlencode('http://yourwebsite.com/movie_detail.php?id=' . $id); ?>" target="_blank" class="btn btn-danger">
                        <i class="fab fa-instagram"></i> Share on Instagram
                    </a>
                </div>
            </div>

            <!-- Reviews and Review Form -->
            <div class="row mt-5">
                <!-- User Reviews -->
                <div class="col-md-8">
                    <h3>User Reviews</h3>
                    <?php if ($result_reviews->num_rows > 0): ?>
                        <?php while ($review = $result_reviews->fetch_assoc()): ?>
                            <div class="review">
                                <h5><?php echo htmlspecialchars($review['uname']); ?></h5>
                                <p><strong>Rating:</strong> <?php echo $review['rating']; ?> / 5</p>
                                <p><?php echo htmlspecialchars($review['review']); ?></p>
                                <p><small class="text-muted">Posted on <?php echo $review['created_at']; ?></small></p>
                            </div>
                            <hr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No reviews yet. Be the first to leave a review!</p>
                    <?php endif; ?>
                </div>

                <!-- Review Form -->
                <div class="col-md-4">
                    <h3>Leave a Review</h3>
                    <?php if (isset($_SESSION['id'])): ?>
                        <form action="submit_review.php" method="POST">
                            <input type="hidden" name="movie_id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select name="rating" id="rating" class="form-control" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="review">Review</label>
                                <textarea name="review" id="review" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    <?php else: ?>
                        <p>Please <a href="login.php">login</a> to leave a review.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>