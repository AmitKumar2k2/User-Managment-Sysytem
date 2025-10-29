PHP User Management System 


Description

A simple PHP-based user management system with:

Secure Login/Logout

User Registration with Image Upload

Dashboard displaying all users

Edit/Delete user options

PDF report generation (using FPDF)

Form validation and session handling


Setup Instructions

Extract the project into your htdocs folder:

C:\xampp\htdocs\php_user_system_styled


Create a new database in phpMyAdmin named user_system.

Run this SQL query:

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  mobile VARCHAR(15),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  state VARCHAR(100),
  city VARCHAR(100),
  description TEXT,
  image VARCHAR(255)
);


Edit db_connect.php if your database credentials differ.

Download fpdf.php from www.fpdf.org
 and place it inside the project root.

Start Apache & MySQL from XAMPP.

Visit http://localhost/php_user_system_styled
.

Credentials

You can register a new user or create a test one manually.
