<?php
include 'C:\xampp\htdocs\project81\config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Website</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
            <div class="container-fluid">
                <!-- Website Name -->
                <a class="navbar-brand" href="index.php">Cinemascope</a>
                <!-- Navbar Links and Search Bar -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="movies.php">Movies</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="watchlist.php">Watchlist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contactus.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="recommendations.php">Recommendations</a>
                        </li>
                        <?php if (isset($_SESSION['id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 ml-auto">
                        <input class="form-control mr-sm-2" id="searchInput" type="search" placeholder="Search for movies..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="searchButton">Search</button>
                        <a class="nav-link" href="signup.php"><i class="fa-solid fa-user" style="font-size:20px;"></i></a>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
      $(document).ready(function() {
            // Search functionality
            $('#searchInput').on('keyup', function() {
                var searchQuery = $('#searchInput').val().toLowerCase();
                $('#moviesGrid .movie-card').each(function() {
                    var title = $(this).data('title').toLowerCase();
                    if (title.includes(searchQuery)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            $('#searchButton').on('click', function() {
                var searchQuery = $('#searchInput').val().toLowerCase();
                $('#moviesGrid .movie-card').each(function() {
                    var title = $(this).data('title').toLowerCase();
                    if (title.includes(searchQuery)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Close the navbar when a link is clicked
            $('.navbar-nav>li>a').on('click', function(){
                $('.navbar-collapse').collapse('hide');
            });
      });
    </script>
</body>
</html>