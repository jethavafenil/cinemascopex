<?php
include('C:\xampp\htdocs\project81\config.php');
?>
<?php include('header.php'); ?>

<div class="container mt-3">
    <h2 class="text-center mb-4">Category List</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Category ID</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Post</th>
                    <th scope="col">Actions</th>
                    <th scope="col">View Posts</th>
                </tr>
            </thead>
            <tbody>
            <a href='addcategory.php' class='btn btn-success mb-1'>Add Category</a>
                <?php
                $query = "SELECT * FROM category";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['c_id'] . "</td>";
                        echo "<td>" . $row['c_name'] . "</td>";
                        $id = $row['id'];
                        $query1 = "SELECT COUNT(*) as total FROM movie_categories WHERE category_id = $id";
                        $result1 = mysqli_query($con, $query1);
                        if ($result1) {
                            $data = mysqli_fetch_assoc($result1);
                            echo "<td>" . $data['total'] . "</td>";
                        } else {
                            echo "<td>0</td>";
                        }
                        echo "<td>
                                <a href='editcategory.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='deletecategory.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                        echo "<td>
                                <a href='viewposts.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>View Posts</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No categories found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>