<?php
include('C:\xampp\htdocs\project81\config.php');
include('header.php');

// Fetch categories from the database
$sql = "SELECT * FROM category";
$result = $con->query($sql);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add Movie</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <form method="POST" action="validmovie.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="movie_name">Movie Name</label>
                        <input type="text" placeholder="Enter Movie Name" name="movie_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="movie_des">Movie Description</label>
                        <textarea placeholder="Enter Movie Description" name="movie_des" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date">Release Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lang">Language</label>
                        <input type="text" placeholder="Enter Language" name="lang" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="director">Director</label>
                        <input type="text" placeholder="Enter Director" name="director" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="categories">Categories</label>
                        <div>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $row['id']; ?>">
                                    <label class="form-check-label"><?php echo $row['c_name']; ?></label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="img">Thumbnail Image</label>
                        <input type="file" name="img" class="form-control" required>
                    </div>   
                    <div class="form-group">             
                        <label for="video_link">Video Link</label>
                        <input type="text" placeholder="Enter Video Link" name="video_link" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Add Movie</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>