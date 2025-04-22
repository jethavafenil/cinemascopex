<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'header.php';
include 'C:\xampp\htdocs\project81\config.php';
include('C:\xampp\htdocs\project81\adminside\moviefetch.php');

// Handle search and sort
$search_query = isset($_GET['query']) ? $_GET['query'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

// Get the current page number from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$moviesPerPage = 10; // Number of movies to display per page

// Calculate the offset for the SQL query
$offset = ($page - 1) * $moviesPerPage;

// Build the SQL query for movies with pagination
$movie_query = "SELECT * FROM movies WHERE m_name LIKE '%$search_query%' ORDER BY $sort_by $order LIMIT $moviesPerPage OFFSET $offset";
$movie_result = mysqli_query($con, $movie_query);

// Fetch total counts for pagination
$total_movies_query = "SELECT COUNT(*) as total_movies FROM movies";
$total_movies_result = mysqli_query($con, $total_movies_query);
$total_movies = mysqli_fetch_assoc($total_movies_result)['total_movies'];

// Calculate the total number of pages
$totalPages = ceil($total_movies / $moviesPerPage);

// Fetch trending movies
$sql_trending = "SELECT 
                    movies.id, 
                    movies.m_name, 
                    movies.img, 
                    AVG(reviews.rating) AS avg_rating, 
                    COUNT(reviews.id) AS total_reviews
                FROM 
                    movies
                LEFT JOIN 
                    reviews ON movies.id = reviews.movie_id
                GROUP BY 
                    movies.id
                ORDER BY 
                    total_reviews DESC, avg_rating DESC
                LIMIT 5";
$result_trending = $con->query($sql_trending);

// Fetch recently watched movies for logged-in users
$recently_watched = [];
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $sql_recently_watched = "SELECT movies.* FROM recently_watched 
                             JOIN movies ON recently_watched.movie_id = movies.id 
                             WHERE recently_watched.user_id = '$user_id' 
                             ORDER BY recently_watched.watched_at DESC LIMIT 5";
    $result_recently_watched = $con->query($sql_recently_watched);
}
?>

<div class="container mt-5">
    <!-- Hero Section -->
    <div class="jumbotron text-center text-white bg-dark hero-section">
        <h1 class="display-4">Welcome to Cinemascope</h1>
        <p class="lead">Your ultimate destination for watching movies online</p>
        <hr class="my-4">
        <p>Explore our vast collection of movies from Hollywood, Bollywood, and more.</p>
        <a class="btn btn-primary btn-lg" href="movies.php" role="button">Browse Movies</a>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-12">
            <input type="text" id="movieSearch" class="form-control" placeholder="Search by movie title">
        </div>
    </div> 

     <!-- Featured Movies Section -->
     <div class="row" id="moviesGrid">
        <div class="col-12">
            <h2 class="text-white">Featured Movies</h2>
        </div>
        <?php
        if ($movie_result->num_rows > 0) {
            while ($row = $movie_result->fetch_assoc()) {
                // Fetch associated categories
                $movie_id = $row['id'];
                $query_categories = "SELECT c_name FROM category 
                                     INNER JOIN movie_categories ON category.id = movie_categories.category_id 
                                     WHERE movie_categories.movie_id='$movie_id'";
                $result_categories = $con->query($query_categories);
                $categories = [];
                while ($row_category = $result_categories->fetch_assoc()) {
                    $categories[] = $row_category['c_name'];
                }
                $categories_str = implode(", ", $categories);

                $imagePath = "../thumb/" . $row["img"];
                if (!file_exists($imagePath)) {
                    $imagePath = '../thumb/aboutus.jpeg'; // Default image if the file doesn't exist
                }

                echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 movie-card" data-title="' . $row["m_name"] . '" data-category="' . $categories_str . '">';
                echo '<div class="card bg-dark text-white">';
                echo '<img src="' . $imagePath . '" class="card-img-top" alt="' . htmlspecialchars($row["m_name"]) . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row["m_name"]) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars(substr($row["m_des"], 0, 100)) . '...</p>';
                echo '<p class="card-text"><small class="text-muted">Categories: ' . htmlspecialchars($categories_str) . '</small></p>';
                echo '<a href="movie_detail.php?id=' . $row["id"] . '" class="btn btn-info mr-2">Read More</a>';
                echo '<a href="watch_movie.php?id=' . $row["id"] . '" class="btn btn-primary">Watch Now</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12">';
            echo '<p class="text-center text-white">No featured movies found.</p>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Trending Movies Section -->
    <div class="col-12">
            <h2 class="text-white">Trending Movies</h2>
    </div>
    <div class="row mb-4">
        <?php if ($result_trending->num_rows > 0): ?>
            <?php while ($movie = $result_trending->fetch_assoc()): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 movie-card">
                    <div class="card bg-dark text-white">
                        <img src="../thumb/<?php echo htmlspecialchars($movie['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($movie['m_name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($movie['m_name']); ?></h5>
                            <p><strong>Average Rating:</strong> <?php echo round($movie['avg_rating'], 1); ?> / 5</p>
                            <p><strong>Total Reviews:</strong> <?php echo $movie['total_reviews']; ?></p>
                            <a href="movie_detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-white">No trending movies available.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recently Watched Movies Section -->
    <?php if (isset($_SESSION['id']) && $result_recently_watched->num_rows > 0): ?>
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-white">Recently Watched Movies</h2>
            </div>
            <?php while ($movie = $result_recently_watched->fetch_assoc()): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 movie-card">
                    <div class="card bg-dark text-white">
                        <img src="../thumb/<?php echo htmlspecialchars($movie['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($movie['m_name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($movie['m_name']); ?></h5>
                            <a href="movie_detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    <?php
    if(!isset($_SESSION['id']) || $result_recently_watched->num_rows == 0) {
        // Display a message if there are no recently watched movies or if the user is not logged in
        echo '<div class="col-12">';
        if(isset($_SESSION['id'])) {
            echo '<p class="text-center text-white">No recently watched movies available.</p>';
        } else {
            echo '<p class="text-center text-white">Please <a href="login.php">login</a> to see your recently watched movies.</p>';
        }
        echo '</div>';
    }
    ?>

     <!-- Pagination Links -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Search functionality
        $('#movieSearch').on('input', function() {
            var searchQuery = $(this).val().toLowerCase();
            $('#moviesGrid .movie-card').each(function() {
                var title = $(this).data('title').toLowerCase();
                if (title.includes(searchQuery)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
</body>
</html>