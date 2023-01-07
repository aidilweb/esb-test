 <?php
    require('config.php');

    $conn = new mysqli($_servername, $_username, $_password, $_database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
