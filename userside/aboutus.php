<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Cinemascope</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <style>
        .about-us {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('path/to/your/background-image.jpg') no-repeat center center;
            background-size: cover;
            color: #ffffff;
            padding: 50px 0;
        }
        .about-us h1, .about-us h2, .about-us a {
            color: #e50914;
        }
        .about-us p {
            font-size: 1.1rem;
        }
        .about-us img {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .about-us .section {
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="about-us">
        <div class="container">
            <h1 class="text-center">About Us</h1>
            <p class="text-center">Welcome to Cinemascope, your ultimate destination for movie enthusiasts!</p>
            <div class="row mt-4 section">
                <div class="col-md-6">
                    <img src="../thumb/aboutus.jpeg" class="img-fluid" alt="About Us Image">
                </div>
                <div class="col-md-6">
                    <h2>Our Mission</h2>
                    <p>At Cinemascope, we aim to provide the best movie-watching experience for our users. Whether you're a fan of action, drama, comedy, or romance, we have something for everyone. Our platform offers a wide range of movies from different genres and eras, ensuring that you always have something new and exciting to watch.</p>
                </div>
            </div>
            <div class="row mt-4 section">
                <div class="col-md-6 order-md-2">
                    <img src="../thumb/ourteam.jpeg" class="img-fluid" alt="Our Team Image">
                </div>
                <div class="col-md-6 order-md-1">
                    <h2>Our Team</h2>
                    <p>Our team is composed of passionate movie lovers who are dedicated to bringing you the best content. We work tirelessly to curate a diverse selection of movies and provide insightful reviews and recommendations. Our goal is to create a community of movie enthusiasts who can share their love for cinema.</p>
                </div>
            </div>
            <div class="row mt-4 section">
                <div class="col-md-6">
                    <img src="../thumb/contactus.jpeg" class="img-fluid" alt="Contact Us Image">
                </div>
                <div class="col-md-6">
                    <h2>Contact Us</h2>
                    <p>If you have any questions or feedback, feel free to <a href="contactus.php">Contact Us</a>. We'd love to hear from you!</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>