<?php
// Database connection details
$host = "localhost"; // Your host
$username = "root";  // Your username
$password = "";      // Your password
$dbname = "event_db"; // Your database name

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $eventType = $conn->real_escape_string(htmlspecialchars(trim($_POST['eventType'])));
    $budget = filter_var($_POST['budget'], FILTER_VALIDATE_FLOAT);
    $description = $conn->real_escape_string(htmlspecialchars(trim($_POST['description'])));
    $contacts = $conn->real_escape_string(htmlspecialchars(trim($_POST['contacts'])));
    $name = $conn->real_escape_string(htmlspecialchars(trim($_POST['name'])));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $date = $conn->real_escape_string(htmlspecialchars(trim($_POST['date'])));
    $location = $conn->real_escape_string(htmlspecialchars(trim($_POST['location'])));
    $attendees = filter_var($_POST['attendees'], FILTER_VALIDATE_INT);
    $customRequest = $conn->real_escape_string(htmlspecialchars(trim($_POST['customRequest'])));

    // Validate required fields
    if (!$eventType || !$budget || !$contacts || !$name || !$email) {
        echo "<script>alert('Please fill in all required fields.');</script>";
        exit;
    }

    // Insert the form data into the database
    $sql = "INSERT INTO event_submissions (event_type, budget, description, contacts, name, email, event_date, location, attendees, custom_request)
            VALUES ('$eventType', '$budget', '$description', '$contacts', '$name', '$email', '$date', '$location', '$attendees', '$customRequest')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Thank you, " . htmlspecialchars($name) . "! Your form has been submitted successfully.');
                window.location.href = 'l3.html'; // Redirect to the HTML page
              </script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    // Close the database connection
    $conn->close();
}
?>
