<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'movie_watching_website';

$con = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
}
?>