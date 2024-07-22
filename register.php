<?php
$servername = "your_database_endpoint";
$username = "your_database_username";
$password = "your_database_password";
$dbname = "student_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$project_title = $_POST['project_title'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$time_slot = $_POST['time_slot'];

$sql = "SELECT * FROM registrations WHERE student_id = '$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<script>
        alert('You are already registered. Do you want to update your registration?');
        window.location.href = 'update_registration.php?student_id=$student_id';
    </script>";
} else {
    $stmt = $conn->prepare("INSERT INTO registrations (student_id, first_name, last_name, project_title, email, phone, time_slot) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $student_id, $first_name, $last_name, $project_title, $email, $phone, $time_slot);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
