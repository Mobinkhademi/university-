# Neon Technology University

This is a university management system web application. The project is built with PHP and MySQL and features a futuristic neon-themed user interface.

## Features

*   **User Authentication:** Students can register and log in to the system.
*   **Admin Panel:** An admin panel to manage student data.
*   **Search Functionality:** The admin can search for students based on their student ID.
*   **Modern UI:** A futuristic neon-themed and responsive user interface.

## Installation and Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/your-repository.git
    ```
2.  **Database Setup:**
    *   Create a MySQL database named `university`.
    *   Import the `university.sql` file (if provided) or create a `students` table with the following schema:
        ```sql
        CREATE TABLE students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            family VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            student_id VARCHAR(50) NOT NULL
        );
        ```
3.  **Configure Database Connection:**
    *   Open the `includes/conn.php` file.
    *   Update the database credentials if they are different from the default:
        ```php
        <?php
        $mysqli = mysqli_connect("localhost", "root", "", "university");
        ?>
        ```
4.  **Run the application:**
    *   Start your local web server (e.g., Apache, Nginx).
    *   Open the project in your web browser.

## Usage

1.  **Register:**
    *   Open the application in your web browser.
    *   Click on the "ثبت‌نام/ ورود" (Register/Login) button.
    *   Fill in the registration form and click "ثبت‌نام" (Register).
2.  **Login:**
    *   After registration, you will be redirected to the login page.
    *   Enter your username and password and click "ورود امن" (Secure Login).
3.  **Admin Panel:**
    *   After logging in, you will be redirected to the admin panel.
    *   Here you can view all the registered students.
    *   You can search for a student by their student ID.
