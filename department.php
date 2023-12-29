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

// READ operation - Fetch all departments
$sqlFetchDepartments = "SELECT * FROM departments";
$resultDepartments = $conn->query($sqlFetchDepartments);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            color: #333;
        }

        h2 {
            color: #008CBA;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            padding: 8px;
            margin-bottom: 15px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        hr {
            border: 1px solid #ddd;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .department-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="department-container">
    <h2>Create Department</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="departmentName">Department Name:</label>
        <input type="text" id="departmentName" name="name" required>

        <label for="departmentLocation">Department Location:</label>
        <input type="text" id="departmentLocation" name="location" required>

        <input type="submit" name="create" value="Create Department">
    </form>

    <h2>Update Department</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="updateDepartmentId">Department ID to Update:</label>
        <input type="text" id="updateDepartmentId" name="id" required>

        <label for="updateDepartmentName">New Department Name:</label>
        <input type="text" id="updateDepartmentName" name="name" required>

        <label for="updateDepartmentLocation">New Department Location:</label>
        <input type="text" id="updateDepartmentLocation" name="location" required>

        <input type="submit" name="update" value="Update Department">
    </form>

    <h2>All Departments</h2>
    <?php
    // Display all departments
    // result of LINE 47,48
    if ($resultDepartments->num_rows > 0) {
                    while ($row = $resultDepartments->fetch_assoc()) {
            echo "<strong>ID:</strong> " . $row["id"] . "<br>";
            echo "<strong>Department Name:</strong> " . $row["name"] . "<br>";
            echo "<strong>Department Location:</strong> " . $row["location"] . "<br><hr>";
        }
    } else {
        echo "No departments found.";
    }
    ?>
</div>

</body>
</html>
