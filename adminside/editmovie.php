<?php
include('C:\xampp\htdocs\project81\config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM movies WHERE id='$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Fetch associated categories
    $query_categories = "SELECT category_id FROM movie_categories WHERE movie_id='$id'";
    $result_categories = mysqli_query($con, $query_categories);
    $selected_categories = [];
    while ($row_category = mysqli_fetch_assoc($result_categories)) {
        $selected_categories[] = $row_category['category_id'];
    }
} else {
    echo "<script>alert('Go To Movie Page For Edit Movie');window.location.href='movie.php';</script>";
    exit();
}

if (isset($_POST['update'])) {
    $movie_id = $_POST['movie_id'];
    $movie_name = $_POST['movie_name'];
    $movie_des = $_POST['movie_des'];
    $date = $_POST['date'];
    $lang = $_POST['lang'];
    $director = $_POST['director'];
    $categories = $_POST['categories']; // Array of selected categories
    $img = $_FILES['img']['name'];

    if ($img) {
        $temp_image = $_FILES['img']['tmp_name'];
        $target = "../thumb/" . basename($img);
        move_uploaded_file($temp_image, $target);
        $sql = "UPDATE movies SET m_name='$movie_name', m_des='$movie_des', date='$date', img='$img', lang='$lang', director='$director' WHERE id='$movie_id'";
    } else {
        $sql = "UPDATE movies SET m_name='$movie_name', m_des='$movie_des', date='$date', lang='$lang', director='$director' WHERE id='$movie_id'";
    }

    if (mysqli_query($con, $sql)) {
        // Update categories
        $sql_delete_categories = "DELETE FROM movie_categories WHERE movie_id='$movie_id'";
        mysqli_query($con, $sql_delete_categories);

        foreach ($categories as $category_id) {
            $sql_insert_category = "INSERT INTO movie_categories (movie_id, category_id) VALUES ('$movie_id', '$category_id')";
            mysqli_query($con, $sql_insert_category);
        }

        echo "<script>alert('Movie Updated Successfully');window.location.href='movie.php';</script>";
    } else {
        echo "<script>alert('Movie Not Updated');window.location.href='editmovie.php?id=$movie_id';</script>";
    }
}
?>
<?php include('header.php'); ?>
<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2></h2>
            <div class="jumbotron">
              <h3 class="display-6">Edit Movie</h3>
              <p class="lead">Edit Movie details</p>
              <hr class="my-2">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="movie_id">Movie ID</label>
                    <input type="text" name="movie_id" class="form-control" value="<?php echo $row['id']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="movie_name">Movie Name</label>
                    <input type="text" name="movie_name" class="form-control" value="<?php echo $row['m_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="movie_des">Movie Description</label>
                    <textarea name="movie_des" class="form-control" required><?php echo $row['m_des']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="date">Release Date</label>
                    <input type="date" name="date" class="form-control" value="<?php echo $row['date']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="lang">Language</label>
                    <input type="text" name="lang" class="form-control" value="<?php echo $row['lang']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="director">Director</label>
                    <input type="text" name="director" class="form-control" value="<?php echo $row['director']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="categories">Categories</label>
                    <div>
                        <?php
                        $sql_all_categories = "SELECT * FROM category";
                        $result_all_categories = mysqli_query($con, $sql_all_categories);
                        while ($row_all_categories = mysqli_fetch_assoc($result_all_categories)) {
                            $checked = in_array($row_all_categories['id'], $selected_categories) ? 'checked' : '';
                            echo '<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="' . $row_all_categories['id'] . '" ' . $checked . '>
                                    <label class="form-check-label">' . $row_all_categories['c_name'] . '</label>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="img">Thumbnail Image</label>
                    <input type="file" name="img" class="form-control">
                    <?php if ($row['img']) { ?>
                        <img src="../thumb/<?php echo $row['img']; ?>" alt="Thumbnail" class="img-thumbnail mt-2" width="150">
                    <?php } ?>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update Movie</button>
              </form>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>