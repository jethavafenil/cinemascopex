<?php
include('C:\xampp\htdocs\project81\config.php');
include('header.php');

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
?>

<div class="container mt-3">
    <h2 class="text-center mb-4">Movie List</h2>
    <a href="addmovie.php" class="btn btn-success mb-4">Add Movie</a>
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
                echo '<div class="card" style="width: 18rem; height: 100%;">';
                echo '<img src="../thumb/' . htmlspecialchars($row['img']) . '" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['m_name']) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($row['m_des']) . '</p>';
                echo '<p class="card-text"><small class="text-muted">Categories: ' . htmlspecialchars($categories_str) . '</small></p>';
                echo '<a href="editmovie.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
                echo '<a href="deletemovie.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a> ';
                echo '<a href="viewmovie.php?id=' . $row['id'] . '" class="btn btn-info btn-sm">View</a>';
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

<?php include('footer.php'); ?>