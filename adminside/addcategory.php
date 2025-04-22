<?php
include('C:\xampp\htdocs\project81\config.php');
?>
<?php include('header.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2></h2>
            <div class="jumbotron">
              <h3 class="display-6">Add Category</h3>
              <p class="lead">Add Category and also mention their Category ID</p>
              <hr class="my-2">
              <form method="POST">
                <div class="form-group">
                    <label for="category_id">Category ID</label>
                    <input type="text" placeholder="Enter Category ID" name="category_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" placeholder="Enter Category Name" name="category_name" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
              </form>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); 

if(isset($_POST['submit']))
{
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    
    $sql = "INSERT INTO `category`(`c_id`, `c_name`) VALUES ($category_id, '$category_name')";
    if(mysqli_query($con, $sql))
    {
        echo "<script>alert('Category Added Successfully');window.location.href='category.php';</script>";
    }
    else
    {
        echo "<script>alert('Category Not Added');window.location.href='addcategory.php';</script>";
    }
}
?>