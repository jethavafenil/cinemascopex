<?php
include('C:\xampp\htdocs\project81\config.php');

// Handle form submission
if (isset($_POST['submit'])) {
    $movie_name = $_POST['movie_name'];
    $movie_des = $_POST['movie_des'];
    $temp_image = $_FILES['img']['tmp_name'];
    $date = $_POST['date'];
    $lang = $_POST['lang'];
    $director = $_POST['director'];
    $categories = $_POST['categories']; // Array of selected categories
    $video_link = $_POST['video_link'];

    $mv_date = date('Y-m-d', strtotime($date));
    $target_image = "../thumb/" . basename($_FILES['img']['name']);
    $img = $_FILES['img']['name'];
    
    $uploadOk = 1;

    // Upload image
    if (move_uploaded_file($temp_image, $target_image)) {
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            $sql = "INSERT INTO `movies`(`m_name`, `m_des`, `date`, `img`, `lang`, `director`, `vid`) VALUES ('$movie_name', '$movie_des', '$mv_date', '$img', '$lang', '$director', '$video_link')";
            if (mysqli_query($con, $sql)) {
                $movie_id = mysqli_insert_id($con);
                foreach ($categories as $category_id) {
                    $sql = "INSERT INTO `movie_categories`(`movie_id`, `category_id`) VALUES ('$movie_id', '$category_id')";
                    mysqli_query($con, $sql);
                }
                echo "<script>alert('Movie Added Successfully');window.location.href='movie.php';</script>";
            } else {
                echo "<script>alert('Movie Not Added');window.location.href='addmovie.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Failed to upload image');window.location.href='addmovie.php';</script>";
    }
}
?>