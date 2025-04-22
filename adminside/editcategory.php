<?php
include('C:\xampp\htdocs\project81\config.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM category WHERE id='$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Go To Category Page For Edit Category');window.location.href='category.php';</script>";
}

if(isset($_POST['update'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $category_post = $_POST['category_post'];
    
    $sql = "UPDATE category SET c_name='$category_name', c_id='$category_id', c_post='$category_post' WHERE id='$id'";
    if(mysqli_query($con, $sql)) {
        echo "<script>alert('Category Updated Successfully');window.location.href='category.php';</script>";
    } else {
        echo "<script>alert('Category Not Updated');window.location.href='editcategory.php?id=$id';</script>";
    }
}
?>
<?php include('header.php'); ?>
<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2></h2>
            <div class="jumbotron">
              <h3 class="display-6">Edit Category</h3>
              <p class="lead">Edit Category details</p>
              <hr class="my-2">
              <form method="POST">
                <div class="form-group">
                    <label for="category_id">Category ID</label>
                    <input type="text" name="category_id" class="form-control" value="<?php echo $row['c_id']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" class="form-control" value="<?php echo $row['c_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="category_post">Category Post</label>
                    <input readonly type="text" name="category_post" class="form-control" value="<?php echo $row['c_post']; ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update Category</button>
              </form>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>