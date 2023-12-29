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
    $employee_ssn = $_POST["employee_ssn"];
    $name = $_POST["name"];
    $salary = $_POST["salary"];
    $department_id = $_POST["department_id"];

    // Insert data into the employees table
    $sql = "INSERT INTO employees (employee_ssn, name, salary, department_id) VALUES ('$employee_ssn', '$name', '$salary', '$department_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Employee created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// READ operation - Fetch all employees
$sqlFetchEmployees = "SELECT employees.id, employee_ssn, employees.name, salary, departments.name AS department_name, location
                      FROM employees
                      LEFT JOIN departments ON employees.department_id = departments.id";
$resultEmployees = $conn->query($sqlFetchEmployees);

// UPDATE operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $salary = $_POST["salary"];
    $department_id = $_POST["department_id"];

    // Update data in the employees table
    $sql = "UPDATE employees SET salary='$salary', department_id='$department_id' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Employee updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// DELETE operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $id = $_POST["id"];

    // Delete data from the employees table
    $sql = "DELETE FROM employees WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Employee deleted successfully!";
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
    <title>Employee Management</title>
</head>
<body>

<h2>Add Employee</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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

<h2>Employee List</h2>
<?php
// Display all employees
if ($resultEmployees->num_rows > 0) {
    while ($row = $resultEmployees->fetch_assoc()) {
        echo "<strong>Employee Details:</strong><br>";
        echo "ID: " . $row["id"] . "<br>";
        echo "Employee SSN: " . $row["employee_ssn"] . "<br>";
        echo "Name: " . $row["name"] . "<br>";
        echo "Salary: " . $row["salary"] . "<br>";
        echo "<br><strong>Department Details:</strong><br>";
        echo "Department Name: " . $row["department_name"] . "<br>";
        echo "Department Location: " . $row["location"] . "<br><hr>";

        // Update form
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
        echo "<label for='updateSalary'>New Salary:</label>";
        echo "<input type='text' id='updateSalary' name='salary' required><br>";
        echo "<label for='updateDepartment'>New Department ID:</label>";
        echo "<input type='text' id='updateDepartment' name='department_id' required><br>";
        echo "<input type='submit' name='update' value='Update Employee'>";
        echo "</form>";

        // Delete button
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
        echo "<input type='submit' name='delete' value='Delete Employee'>";
        echo "</form><hr>";
    }
} else {
    echo "No employees found.";
}
?>

</body>
</html>
