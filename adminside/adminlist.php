<?php
include('C:\xampp\htdocs\project81\config.php');
include('header.php');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5 mb-5">
                <div class="card-header">
                    <h3 class="text-center">Admin List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM admins";
                            $run = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($run)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['uname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><a class="btn btn-danger" href="deleteadmin.php?id=<?php echo $row['id'];?>">Delete</td>
                                </tr>
                                <tr></tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php include "footer.php";?>