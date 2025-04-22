<?php
include('C:\xampp\htdocs\project81\config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch movie rating analytics
$sql = "SELECT 
            movies.id, 
            movies.m_name, 
            movies.img, 
            AVG(reviews.rating) AS avg_rating, 
            COUNT(reviews.id) AS total_ratings
        FROM 
            movies
        LEFT JOIN 
            reviews ON movies.id = reviews.movie_id
        GROUP BY 
            movies.id
        ORDER BY 
            avg_rating DESC";
$result = $con->query($sql);

// Fetch most viewed movies
$sql_most_viewed = "SELECT movies.m_name, movie_views.view_count 
                    FROM movie_views 
                    JOIN movies ON movie_views.movie_id = movies.id 
                    ORDER BY movie_views.view_count DESC 
                    LIMIT 5";
$result_most_viewed = $con->query($sql_most_viewed);

// Fetch recent user activity
$sql_recent_activity = "SELECT user_activity.*, users.uname, movies.m_name 
                        FROM user_activity 
                        LEFT JOIN users ON user_activity.user_id = users.id 
                        LEFT JOIN movies ON user_activity.movie_id = movies.id 
                        ORDER BY user_activity.created_at DESC 
                        LIMIT 10";
$result_recent_activity = $con->query($sql_recent_activity);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Rating Analytics</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Movie Rating Analytics</h2>

        <!-- Most Viewed Movies -->
        <div class="mt-5">
            <h3>Most Viewed Movies</h3>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Movie Name</th>
                        <th>View Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_most_viewed->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['m_name']); ?></td>
                            <td><?php echo $row['view_count']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
        <h3>Recent User Activity</h3>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Movie</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_recent_activity->num_rows > 0): ?>
                    <?php while ($row = $result_recent_activity->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['uname'] ?? 'Unknown User'); ?></td>
                            <td><?php echo htmlspecialchars($row['action']); ?></td>
                            <td><?php echo htmlspecialchars($row['m_name'] ?? 'Unknown Movie'); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No recent activity found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Movie</th>
                        <th>Image</th>
                        <th>Average Rating</th>
                        <th>Total Ratings</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['m_name']); ?></td>
                                <td>
                                    <img src="../thumb/<?php echo htmlspecialchars($row['img']); ?>" alt="Movie Image" style="width: 100px; height: auto;">
                                </td>
                                <td><?php echo round($row['avg_rating'], 1); ?> / 5</td>
                                <td><?php echo $row['total_ratings']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>