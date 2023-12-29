<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dir";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CREATE operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    $name = $_POST["name"];
    $location = $_POST["location"];

    // Insert data into the departments table
    $sql = "INSERT INTO departments (name, location) VALUES ('$name', '$location')";

    if ($conn->query($sql) === TRUE) {
        echo "Department created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// READ operation - Fetch all departments
$sqlFetchDepartments = "SELECT * FROM departments";
$resultDepartments = $conn->query($sqlFetchDepartments);

// UPDATE operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $location = $_POST["location"];

    // Update data in the departments table
    $sql = "UPDATE departments SET name='$name', location='$location' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Department updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments Page</title>
</head>
<body>

<h2>Create Department</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="departmentName">Department Name:</label>
    <input type="text" id="departmentName" name="name" required><br>

    <label for="departmentLocation">Department Location:</label>
    <input type="text" id="departmentLocation" name="location" required><br>

    <input type="submit" name="create" value="Create Department">
</form>

<h2>Update Department</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="updateDepartmentId">Department ID to Update:</label>
    <input type="text" id="updateDepartmentId" name="id" required><br>

    <label for="updateDepartmentName">New Department Name:</label>
    <input type="text" id="updateDepartmentName" name="name" required><br>

    <label for="updateDepartmentLocation">New Department Location:</label>
    <input type="text" id="updateDepartmentLocation" name="location" required><br>

    <input type="submit" name="update" value="Update Department">
</form>

<h2>All Departments</h2>
<?php
// Display all departments
if ($resultDepartments->num_rows > 0) {
    while ($row = $resultDepartments->fetch_assoc()) {
        echo "ID: " . $row["id"] . "<br>";
        echo "Department Name: " . $row["name"] . "<br>";
        echo "Department Location: " . $row["location"] . "<br><hr>";
    }
} else {
    echo "No departments found.";
}
?>

</body>
</html>
