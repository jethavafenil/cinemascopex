<?php
include('C:\xampp\htdocs\project81\config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM movies WHERE id='$id'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Fetch associated categories
        $query_categories = "SELECT c_name FROM category INNER JOIN movie_categories ON category.id = movie_categories.category_id WHERE movie_categories.movie_id='$id'";
        $result_categories = mysqli_query($con, $query_categories);
        $categories = [];
        while ($row_category = mysqli_fetch_assoc($result_categories)) {
            $categories[] = $row_category['c_name'];
        }
        $categories_str = implode(", ", $categories);
    } else {
        echo "<script>alert('Movie not found');window.location.href='movie.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No movie ID provided');window.location.href='movie.php';</script>";
    exit();
}
?>
<?php include('header.php'); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card jumbotron">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="../thumb/<?php echo htmlspecialchars($row['img']); ?>" class="card-img" alt="Thumbnail" style="width: 100%; height: 300px; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($row['m_name']); ?></h3>
                            <p class="card-text"><?php echo htmlspecialchars($row['m_des']); ?></p>
                            <hr class="my-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Movie ID:</strong> <?php echo htmlspecialchars($row['id']); ?></li>
                                <li class="list-group-item"><strong>Categories:</strong> <?php echo htmlspecialchars($categories_str); ?></li>
                                <li class="list-group-item"><strong>Release Date:</strong> <?php echo htmlspecialchars($row['date']); ?></li>
                                <li class="list-group-item"><strong>Language:</strong> <?php echo htmlspecialchars($row['lang']); ?></li>
                                <li class="list-group-item"><strong>Director:</strong> <?php echo htmlspecialchars($row['director']); ?></li>
                            </ul>
                            <div class="mt-3">
                                <a href="movie.php" class="btn btn-primary">Back to movies</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>