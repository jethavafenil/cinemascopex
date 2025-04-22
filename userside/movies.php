<?php
include 'C:\xampp\htdocs\project81\config.php';

// Handle search, category filter, and sorting
$search_query = isset($_GET['query']) ? $_GET['query'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

// Pagination setup
$moviesPerPage = 10; // Number of movies per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $moviesPerPage;

// Build the SQL query for movies
$where_conditions = [];
if (!empty($search_query)) {
    $where_conditions[] = "m_name LIKE '%" . $con->real_escape_string($search_query) . "%'";
}
if ($category !== 'all') {
    $where_conditions[] = "id IN (SELECT movie_id FROM movie_categories WHERE category_id = '$category')";
}
$where_sql = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

$movie_query = "SELECT * FROM movies $where_sql ORDER BY $sort_by $order LIMIT $moviesPerPage OFFSET $offset";
$movie_result = $con->query($movie_query);

// Fetch total movie count for pagination
$total_movies_query = "SELECT COUNT(*) as total_movies FROM movies $where_sql";
$total_movies_result = $con->query($total_movies_query);
$total_movies = $total_movies_result->fetch_assoc()['total_movies'];
$totalPages = ceil($total_movies / $moviesPerPage);

// Fetch categories for the filter dropdown
$sql_categories = "SELECT * FROM category";
$result_categories = $con->query($sql_categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies - Cinemascope</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="movies-page">
        <div class="container">
            <!-- Advanced Search Section -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <input type="text" id="movieSearch" class="form-control" placeholder="Search by title" value="<?php echo htmlspecialchars($search_query); ?>">
                </div>
                <div class="col-md-3">
                    <select id="categoryFilter" class="form-control">
                        <option value="all">All Categories</option>
                        <?php while ($row = $result_categories->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>" <?php echo ($category == $row['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['c_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="sortFilter" class="form-control">
                        <option value="id" <?php echo ($sort_by == 'id') ? 'selected' : ''; ?>>Latest</option>
                        <option value="m_name" <?php echo ($sort_by == 'm_name') ? 'selected' : ''; ?>>Name</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button id="applyFilters" class="btn btn-primary btn-block">Apply Filters</button>
                </div>
            </div>

            <!-- Movies Grid -->
            <div class="row" id="moviesGrid">
                <?php if ($movie_result->num_rows > 0): ?>
                    <?php while ($row = $movie_result->fetch_assoc()): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 movie-card">
                            <div class="card bg-dark text-white">
                                <img src="../thumb/<?php echo htmlspecialchars($row['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['m_name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['m_name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($row['m_des'], 0, 100)); ?>...</p>
                                    <a href="movie_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                                    <a href="watch_movie.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Watch Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center text-white">No movies found.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // Apply filters
        $('#applyFilters').on('click', function () {
            var query = $('#movieSearch').val();
            var category = $('#categoryFilter').val();
            var sort_by = $('#sortFilter').val();
            window.location.href = '?query=' + query + '&category=' + category + '&sort_by=' + sort_by;
        });
    </script>
</body>
</html>