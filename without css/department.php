<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dir";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $location = $_POST["location"];

    if (isset($_POST["create"])) {
        // CREATE operation
        $sql = "INSERT INTO departments (name, location) VALUES ('$name', '$location')";
        $message = "Department created successfully!";
    } elseif (isset($_POST["update"])) {
        // UPDATE operation
        $id = $_POST["id"];
        $sql = "UPDATE departments SET name='$name', location='$location' WHERE id=$id";
        $message = "Department updated successfully!";
    }

    if (mysqli_query($conn, $sql)) {
        echo $message;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// READ operation - Fetch all departments
$resultDepartments = mysqli_query($conn, "SELECT * FROM departments");

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Departments Page</title>
</head>
<body>

<h2>Create Department</h2>
<form method="post">
    <label for="departmentName">Department Name:</label>
    <input type="text" id="departmentName" name="name" required><br>

    <label for="departmentLocation">Department Location:</label>
    <input type="text" id="departmentLocation" name="location" required><br>

    <input type="submit" name="create" value="Create Department">
</form>

<h2>Update Department</h2>
<form method="post">
    <label for="updateDepartmentId">Department ID to Update:</label>
    <input type="text" id="updateDepartmentId" name="id" required><br>

    <label for="updateDepartmentName">New Department Name:</label>
    <input type="text" id="updateDepartmentName" name="name" required><br>

    <label for="updateDepartmentLocation">New Department Location:</label>
    <input type="text" id="updateDepartmentLocation" name="location" required><br>

    <input type="submit" name="update" value="Update Department">
</form>

<br>

<button onclick="window.location.href='employee.php';">Go to Employee Management</button>

<h2>All Departments</h2>
<table border="1" style="border-collapse: collapse; width: 100%;">
    <tr>
        <th>ID</th>
        <th>Department Name</th>
        <th>Department Location</th>
    </tr>
    <?php
    // Display all departments
    if (mysqli_num_rows($resultDepartments) > 0) {
        while ($row = mysqli_fetch_assoc($resultDepartments)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["location"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No departments found.</td></tr>";
    }
    ?>
</table>

</body>
</html>

<!-- 
Changes made:
1. Combined the form submission handling into a single block.
2. Used a variable `$message` to store the success message.
3. Created a button that link to employee.php for faster access to page -->
