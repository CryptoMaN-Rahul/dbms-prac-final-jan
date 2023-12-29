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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $employee_ssn = $_POST["employee_ssn"];
    $name = $_POST["name"];
    $salary = $_POST["salary"];
    $department_id = $_POST["department_id"];

    // Insert data into the employees table
    $sql = "INSERT INTO employees (employee_ssn, name, salary, department_id) 
            VALUES ('$employee_ssn', '$name', '$salary', '$department_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Employee added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// READ operation - Fetch all employees or specific employee(s)
$searchName = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchName"])) {
    $searchName = $_POST["searchName"];
}

$sqlFetchEmployees = "SELECT employees.id, employees.employee_ssn, employees.name, employees.salary, 
                               departments.name AS department_name, departments.location
                    FROM employees
                    JOIN departments ON employees.department_id = departments.id
                    WHERE employees.name LIKE '%$searchName%'";
$resultEmployees = $conn->query($sqlFetchEmployees);

// UPDATE operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $salary = $_POST["salary"];
    $department_id = $_POST["department_id"];

    // Update data in the employees table
    $sql = "UPDATE employees 
            SET salary='$salary', department_id='$department_id' 
            WHERE id=$id";

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
    <title>Employees Page</title>
    <style>
        body {
            display: flex;
            justify-content: space-between;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 45%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .left, .right {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            margin-bottom: 5px;
        }

        input {
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        h2 {
            margin-bottom: 15px;
        }

        hr {
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container left">
    <h2>Add Employee</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="employee_ssn">Employee SSN:</label>
        <input type="text" id="employee_ssn" name="employee_ssn" required>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="salary">Salary:</label>
        <input type="text" id="salary" name="salary" required>

        <label for="department_id">Department ID:</label>
        <input type="text" id="department_id" name="department_id" required><br>

        <input type="submit" name="add" value="Add Employee">
    </form>


    <h2>Search Employee</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="searchName">Search by Name:</label>
        <input type="text" id="searchName" name="searchName">
        <input type="submit" value="Search">
    </form><br><br><br>

      <form method="get" action="department.php">
        <input type="submit" value="Manage Departments">
    </form>
</div>

<div class="container right">
    <h2>All Employees</h2>
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

            // Delete form
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<input type='submit' name='delete' value='Delete Employee'>";
            echo "</form>";
        }
    } else {
        echo "No employees found.";
    }
    ?>
</div>

</body>
</html>
