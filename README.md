
**@CryptoMaN_Rahul**




**Employee Management System Overview**

*This project is a simple Employee Management System implemented using PHP, HTML, and MySQL. It allows users to manage employees and departments, perform CRUD (Create, Read, Update, Delete) operations, and includes basic styling.*

**Prerequisites**

- [XAMPP](https://www.apachefriends.org/index.html) installed on your machine to set up a local server.
- Basic understanding of PHP, HTML, and MySQL.

**Setup Instructions**

1. **Move to `htdocs` Directory:**
   - Copy or move the entire project folder (`employee-management-system`) to the `htdocs` folder inside your XAMPP installation.
   - If your project folder is named `dbproj`, the path should be `C:\xampp\htdocs\dbproj` (for Windows) or `/Applications/XAMPP/htdocs/dbproj` (for Mac).

2. **Start XAMPP:**
   - Start the Apache and MySQL servers using the XAMPP control panel.

3. **Create Database:**
   - Open phpMyAdmin in your browser (usually http://localhost/phpmyadmin/).
   - Create a new database named `dir`.

4. **Import SQL:**
   - Import the provided SQL script into the `dir` database. You can use phpMyAdmin for this.
     - File: `dir.sql`

5. **Run the Application:**
   - Open a web browser and navigate to `http://localhost/dbproj/emploeee.php`.

**Database Tables**

1. **Employee Table:**
   ```sql
   CREATE TABLE employees (
       id INT AUTO_INCREMENT PRIMARY KEY,
       employee_ssn VARCHAR(15) NOT NULL,
       name VARCHAR(100) NOT NULL,
       salary DECIMAL(10,2) NOT NULL,
       department_id INT,
       FOREIGN KEY (department_id) REFERENCES departments(id)
   );

Department Table:
   ```sql

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL
);


Usage

Employee Management:

Add a new employee using the "Add Employee" form.
Search for employees by name using the search functionality.
Update employee details using the "Update Employee" form.
Delete an employee using the "Delete Employee" button.
Department Management:

Add a new department using the "Create Department" form.
Update department details using the "Update Department" form.
View all departments on the page.
Navigation:

Use the "Manage Departments" button in employee.php to navigate to the department.php page.
Customization

Modify the CSS styles in the PHP files for a personalized look.
Extend functionalities as needed based on project requirements.
Issues and Contributions

If you encounter any issues or have suggestions for improvements, feel free to open an issue or submit a pull request.
Credits

This project is inspired by a series of conversations with ChatGPT.
Contributions and ideas are welcome!

