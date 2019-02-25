
<?php
$dbhost = 'localhost';//127.0.0.1
$dbuser = 'root';
$dbpass = '';
$dbname = 'spider';


$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>