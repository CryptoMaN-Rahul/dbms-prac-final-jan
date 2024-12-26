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

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_ssn = $_POST["employee_ssn"] ?? null;
    $name = $_POST["name"] ?? null;
    $salary = $_POST["salary"] ?? null;
    $department_id = $_POST["department_id"] ?? null;
    $id = $_POST["id"] ?? null;
    $searchTerm = $_POST["searchTerm"] ?? null;

    if (isset($_POST["create"])) {
        // CREATE operation
        $sql = "INSERT INTO employees (employee_ssn, name, salary, department_id) VALUES ('$employee_ssn', '$name', '$salary', '$department_id')";
        $message = "Employee created successfully!";
    } elseif (isset($_POST["update"])) {
        // UPDATE operation
        $sql = "UPDATE employees SET salary='$salary', department_id='$department_id' WHERE id=$id";
        $message = "Employee updated successfully!";
    } elseif (isset($_POST["delete"])) {
        // DELETE operation
        $sql = "DELETE FROM employees WHERE id=$id";
        $message = "Employee deleted successfully!";
    } elseif (isset($_POST["search"])) {
        // SEARCH operation
        $sqlSearch = "SELECT employees.id, employee_ssn, employees.name, salary, departments.name AS department_name, location
                      FROM employees
                      LEFT JOIN departments ON employees.department_id = departments.id
                      WHERE employees.name LIKE '%$searchTerm%'";
        $resultEmployees = mysqli_query($conn, $sqlSearch);
    }

    if (isset($sql) && mysqli_query($conn, $sql)) {
        echo $message;
        if (isset($_POST["update"]) || isset($_POST["delete"])) {
            echo "<script>setTimeout(function(){ location.reload(); }, 100);</script>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// READ operation - Fetch all employees if not searching
if (!isset($resultEmployees)) {
    $sqlFetchEmployees = "SELECT employees.id, employee_ssn, employees.name, salary, departments.name AS department_name, location
                          FROM employees
                          LEFT JOIN departments ON employees.department_id = departments.id";
    $resultEmployees = mysqli_query($conn, $sqlFetchEmployees);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Management</title>
</head>
<body>

<h2>Add Employee</h2>
<form method="post">
    <label for="employeeSSN">Employee SSN:</label>
    <input type="text" id="employeeSSN" name="employee_ssn" required><br>

    <label for="employeeName">Employee Name:</label>
    <input type="text" id="employeeName" name="name" required><br>

    <label for="employeeSalary">Employee Salary:</label>
    <input type="text" id="employeeSalary" name="salary" required><br>

    <label for="employeeDepartment">Employee Department ID:</label>
    <input type="text" id="employeeDepartment" name="department_id" required><br>

    <input type="submit" name="create" value="Add Employee">
</form>

<br>
<!-- Button to connect to department.php -->
<button onclick="window.location.href='department.php';">Go to Department Management</button>

<h2>Search Employee</h2>
<form method="post">
    <label for="searchTerm">Search by Employee Name:</label>
    <input type="text" id="searchTerm" name="searchTerm" required>
    <input type="submit" name="search" value="Search">
</form>

<h2>Employee List</h2>
<table border="1" style="border-collapse: collapse; width: 100%;">
    <tr>
        <th>ID</th>
        <th>Employee SSN</th>
        <th>Name</th>
        <th>Salary</th>
        <th>Department Name</th>
        <th>Location</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
    <?php
    // Display all employees or searched employees
    if ($resultEmployees && $resultEmployees->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($resultEmployees)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["employee_ssn"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["salary"] . "</td>";
            echo "<td>" . $row["department_name"] . "</td>";
            echo "<td>" . $row["location"] . "</td>";

            // Update form
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<label for='updateSalary'>New Salary:</label>";
            echo "<input type='text' id='updateSalary' name='salary' required>";
            echo "<label for='updateDepartment'>New Department ID:</label>";
            echo "<input type='text' id='updateDepartment' name='department_id' required>";
            echo "<input type='submit' name='update' value='Update'>";
            echo "</form>";
            echo "</td>";

            // Delete button
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
            echo "</td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No employees found.</td></tr>";
    }
    ?>
</table>
</body>
</html>
