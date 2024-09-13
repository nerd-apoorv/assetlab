<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish the connection
    $conn = mysqli_connect('host', 'username', 'pass', 'database');
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve and escape input
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Prepare the query
    $query = "INSERT INTO wlist (email) VALUES ('$email')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo '';
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);

    include 'joined.php';
}
?>
