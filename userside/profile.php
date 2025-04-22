<?php
include('C:\xampp\htdocs\project81\config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo "<script>alert('User not sign in'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user information
$sql_user = "SELECT * FROM users WHERE id = ?";
$stmt_user = $con->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$stmt_user->close();

// Fetch user reviews
$sql_reviews = "SELECT reviews.*, movies.m_name FROM reviews 
                JOIN movies ON reviews.movie_id = movies.id 
                WHERE reviews.user_id = ?";
$stmt_reviews = $con->prepare($sql_reviews);
$stmt_reviews->bind_param("i", $user_id);
$stmt_reviews->execute();
$result_reviews = $stmt_reviews->get_result();
$stmt_reviews->close();

// Fetch user watchlist
$sql_watchlist = "SELECT movies.* FROM movies 
                  JOIN watchlist ON movies.id = watchlist.movie_id 
                  WHERE watchlist.user_id = ?";
$stmt_watchlist = $con->prepare($sql_watchlist);
$stmt_watchlist->bind_param("i", $user_id);
$stmt_watchlist->execute();
$result_watchlist = $stmt_watchlist->get_result();
$stmt_watchlist->close();

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./userside/style.css">
</head>
<body class="bg-black text-light">
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">User Profile</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="p-3 bg-secondary rounded">
                    <h3>Profile Information</h3>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['uname']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="p-3 bg-secondary rounded">
                    <h3>My Reviews</h3>
                    <?php if ($result_reviews->num_rows > 0): ?>
                        <table class="table table-dark table-bordered">
                            <thead>
                                <tr>
                                    <th>Movie</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($review = $result_reviews->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($review['m_name']); ?></td>
                                        <td><?php echo $review['rating']; ?> / 5</td>
                                        <td><?php echo htmlspecialchars($review['review']); ?></td>
                                        <td><?php echo $review['created_at']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No reviews found.</p>
                    <?php endif; ?>
                </div>

                <div class="p-3 bg-secondary rounded mt-5">
                    <h3>My Watchlist</h3>
                    <?php if ($result_watchlist->num_rows > 0): ?>
                        <div class="row">
                            <?php while ($movie = $result_watchlist->fetch_assoc()): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card bg-dark text-light h-100 shadow-sm">
                                        <img src="../thumb/<?php echo htmlspecialchars($movie['img']); ?>" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title"><?php echo htmlspecialchars($movie['m_name']); ?></h5>
                                            <p class="card-text"><?php echo htmlspecialchars($movie['m_des']); ?></p>
                                            <div class="mt-auto">
                                                <a href="movie_detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-info btn-sm">Read More</a>
                                                <a href="watch_movie.php?id=<?php echo $movie['id']; ?>" class="btn btn-primary btn-sm">Watch Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p>No movies in your watchlist.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>