<?php
$servername = "your_database_endpoint";
$username = "your_database_username";
$password = "your_database_password";
$dbname = "student_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_GET['student_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $project_title = $_POST['project_title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $time_slot = $_POST['time_slot'];

    $stmt = $conn->prepare("UPDATE registrations SET first_name = ?, last_name = ?, project_title = ?, email = ?, phone = ?, time_slot = ? WHERE student_id = ?");
    $stmt->bind_param("sssssss", $first_name, $last_name, $project_title, $email, $phone, $time_slot, $student_id);

    if ($stmt->execute()) {
        echo "Registration updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit();
} else {
    $sql = "SELECT * FROM registrations WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No registration found for this student ID.";
        $conn->close();
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Update Registration</h1>
        <form action="update_registration.php?student_id=<?php echo $student_id; ?>" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required pattern="[A-Za-z]+" value="<?php echo $row['first_name']; ?>">

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required pattern="[A-Za-z]+" value="<?php echo $row['last_name']; ?>">

            <label for="project_title">Project Title:</label>
            <input type="text" id="project_title" name="project_title" required value="<?php echo $row['project_title']; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" value="<?php echo $row['email']; ?>">

            <label for="phone">Phone (999-999-9999):</label>
            <input type="text" id="phone" name="phone" required pattern="\d{3}-\d{3}-\d{4}" value="<?php echo $row['phone']; ?>">

            <label for="time_slot">Time Slot:</label>
            <select id="time_slot" name="time_slot" required>
                <option value="4/19/2070, 6:00 PM – 7:00 PM" <?php if ($row['time_slot'] == '4/19/2070, 6:00 PM – 7:00 PM') echo 'selected'; ?>>4/19/2070, 6:00 PM – 7:00 PM</option>
                <option value="4/19/2070, 7:00 PM – 8:00 PM" <?php if ($row['time_slot'] == '4/19/2070, 7:00 PM – 8:00 PM') echo 'selected'; ?>>4/19/2070, 7:00 PM – 8:00 PM</option>
                <option value="4/19/2070, 8:00 PM – 9:00 PM" <?php if ($row['time_slot'] == '4/19/2070, 8:00 PM – 9:00 PM') echo 'selected'; ?>>4/19/2070, 8:00 PM – 9:00 PM</option>
            </select>

            <button type="submit">Update Registration</button>
        </form>
    </div>
</body>
</html>
