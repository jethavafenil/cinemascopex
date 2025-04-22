<?php
include('C:\xampp\htdocs\project81\config.php');
include('C:\xampp\htdocs\project81\adminside\moviefetch.php');
include('header.php');

// Handle search and sort
$search_query = isset($_GET['query']) ? $_GET['query'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

// Fetch total watchlist entries
$total_watchlist_query = "SELECT COUNT(*) as total_watchlist FROM watchlist";
$total_watchlist_result = mysqli_query($con, $total_watchlist_query);
$total_watchlist = mysqli_fetch_assoc($total_watchlist_result)['total_watchlist'];

// Get the current page number from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$moviesPerPage = 10; // Number of movies to display per page

// Calculate the offset for the SQL query
$offset = ($page - 1) * $moviesPerPage;

// Build the SQL query for movies with pagination
$movie_query = "SELECT * FROM movies WHERE m_name LIKE '%$search_query%' ORDER BY $sort_by $order LIMIT $moviesPerPage OFFSET $offset";
$movie_result = mysqli_query($con, $movie_query);

// Fetch total counts for dashboard overview
$total_movies_query = "SELECT COUNT(*) as total_movies FROM movies";
$total_movies_result = mysqli_query($con, $total_movies_query);
$total_movies = mysqli_fetch_assoc($total_movies_result)['total_movies'];

$total_categories_query = "SELECT COUNT(*) as total_categories FROM category";
$total_categories_result = mysqli_query($con, $total_categories_query);
$total_categories = mysqli_fetch_assoc($total_categories_result)['total_categories'];

$total_admins_query = "SELECT COUNT(*) as total_admins FROM admins"; // Assuming your admin table is named 'admins'
$total_admins_result = mysqli_query($con, $total_admins_query);
$total_admins = mysqli_fetch_assoc($total_admins_result)['total_admins'];

// Calculate the total number of pages
$totalPages = ceil($total_movies / $moviesPerPage);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Admin Panel</h2>

    <!-- Dashboard Overview -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Movies</h5>
                    <p class="card-text"><?php echo $total_movies; ?></p>
                    <a href="movie.php" class="btn btn-light btn-sm btn-block">See More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text"><?php echo $total_categories; ?></p>
                    <a href="category.php" class="btn btn-light btn-sm btn-block">See More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Admins</h5>
                    <p class="card-text"><?php echo $total_admins; ?></p>
                    <a href="adminlist.php" class="btn btn-light btn-sm btn-block">See More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Watchlist Entries</h5>
                    <p class="card-text"><?php echo $total_watchlist; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="index.php">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" placeholder="Search for movies..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 text-right">
            <a href="addmovie.php" class="btn btn-success">Add Movie</a>
        </div>
    </div>

    <!-- Movies Section -->
    <div class="mb-5">
        <h3 class="text-center mb-4">Movies</h3>
        <div class="row">
            <?php
            if (mysqli_num_rows($movie_result) > 0) {
                while ($row = mysqli_fetch_assoc($movie_result)) {
                    // Fetch associated categories
                    $movie_id = $row['id'];
                    $query_categories = "SELECT c_name FROM category 
                                         INNER JOIN movie_categories ON category.id = movie_categories.category_id 
                                         WHERE movie_categories.movie_id='$movie_id'";
                    $result_categories = mysqli_query($con, $query_categories);
                    $categories = [];
                    while ($row_category = mysqli_fetch_assoc($result_categories)) {
                        $categories[] = $row_category['c_name'];
                    }
                    $categories_str = implode(", ", $categories);

                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card h-100 shadow-sm">';
                    echo '<img src="../thumb/' . htmlspecialchars($row['img']) . '" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['m_name']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($row['m_des']) . '</p>';
                    echo '<p class="card-text"><small class="text-muted">Categories: ' . htmlspecialchars($categories_str) . '</small></p>';
                    echo '<div class="mt-auto">';
                    echo '<a href="editmovie.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
                    echo '<a href="deletemovie.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a> ';
                    echo '<a href="viewmovie.php?id=' . $row['id'] . '" class="btn btn-info btn-sm">View</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-md-12">';
                echo '<p class="text-center">No movies found</p>';
                echo '</div>';
            }
            ?>
        </div>
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

    <!-- Categories Section -->
    <div class="mb-5">
        <h3 class="text-center mb-4">Categories</h3>
        <div class="row">
            <?php
            $category_query = "SELECT * FROM category";
            $category_result = mysqli_query($con, $category_query);

            if (mysqli_num_rows($category_result) > 0) {
                while ($category_row = mysqli_fetch_assoc($category_result)) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card h-100 shadow-sm">';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<h5 class="card-title">' . htmlspecialchars($category_row['c_name']) . '</h5>';
                    echo '<div class="mt-auto">';
                    echo '<a href="viewposts.php?id=' . $category_row['id'] . '" class="btn btn-info btn-sm">View Posts</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-md-12">';
                echo '<p class="text-center">No categories found</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>