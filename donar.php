<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $location = $_POST['location'] ?? '';
    $blood_group = $_POST['blood_group'] ?? '';

    // Basic validation
    if (!empty($full_name) && !empty($phone_number) && !empty($location) && !empty($blood_group)) {
        $host = "localhost";
        $port = 3307;  // Your MySQL port
        $dbusername = "root";
        $dbpassword = "";  // If no password
        $dbname = "tamilhacks";

        // Create connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare statement to avoid SQL injection
        $stmt = $conn->prepare("INSERT INTO donors (full_name, phone_number, location, blood_group) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $phone_number, $location, $blood_group);

        if ($stmt->execute()) {
            echo "Donor registered successfully!";
            // Optionally redirect to home.html after 2 seconds:
            // header("refresh:2;url=home.html");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}
?>
