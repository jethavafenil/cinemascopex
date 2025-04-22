<?php
include('C:\xampp\htdocs\project81\config.php');
include('header.php');

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
} else {
    echo "<script>alert('No category ID provided');window.location.href='category.php';</script>";
    exit();
}
?>

<div class="container mt-3">
    <h2 class="text-center mb-4">Movies by Category</h2>
    <a href="addmovie.php" class="btn btn-success mb-4">Add Movie</a>

    <?php
    // Fetch the category name
    $category_query = "SELECT * FROM category WHERE id='$category_id'";
    $category_result = mysqli_query($con, $category_query);
    $category_row = mysqli_fetch_assoc($category_result);
    echo '<div class="category-section">';
    echo '<h3 class="mb-4">' . htmlspecialchars($category_row['c_name']) . '</h3>';
    echo '<div class="row">';

    // Fetch movies for the selected category
    $movie_query = "SELECT movies.* FROM movies 
                    INNER JOIN movie_categories ON movies.id = movie_categories.movie_id 
                    WHERE movie_categories.category_id='$category_id'";
    $movie_result = mysqli_query($con, $movie_query);

    if (mysqli_num_rows($movie_result) > 0) {
        while ($row = mysqli_fetch_assoc($movie_result)) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card" style="width: 18rem; height: 100%;">';
            echo '<img src="../thumb/' . htmlspecialchars($row['img']) . '" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['m_name']) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars($row['m_des']) . '</p>';
            echo '<a href="editmovie.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
            echo '<a href="deletemovie.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a> ';
            echo '<a href="viewmovie.php?id=' . $row['id'] . '" class="btn btn-info btn-sm">View</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="col-md-12">';
        echo '<p class="text-center">No movies found in this category</p>';
        echo '</div>';
    }

    echo '</div>'; // End of row
    echo '</div>'; // End of category-section
    ?>
</div>

<?php include('footer.php'); ?>