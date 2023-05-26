<?php
$servername = 'localhost';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    if (empty($_POST['dbname'])) {
        $dbnameErr = 'Database Name is Required!';
    } else {
        $dbname = test_input($_POST['dbname']);
    }

    if (empty($_POST['username'])) {
        $usernameErr = 'Username is Required!';
    } else {
        $username = test_input($_POST['username']);
    }

    if (empty($_POST['password'])) {
        $password = '';
    } else {
        $password = test_input($_POST['password']);
    }
}

//Funtion to exclude extra spaces, and specal characters from input string
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Create a connection
$conn = new mysqli($servername, $username, $password);


// Check if the database exists
$result = $conn->query("SHOW DATABASES LIKE '$dbname'");

if ($result->num_rows > 0) {
    // Database already exists, establish connection
    $conn->select_db($dbname);
    echo "Connection established to existing database: $dbname";
} else {
    // Database does not exist, create it and establish connection
    $createDbQuery = "CREATE DATABASE $dbname";
    if ($conn->query($createDbQuery) === TRUE) {
        echo "Database created successfully.";
        $conn->select_db($dbname);
        echo "Connection established to newly created database: $dbname";

        $customer = "CREATE TABLE users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(30) NOT NULL,
                lastname VARCHAR(30) NOT NULL,
                email VARCHAR(50),
                user_role ENUM ('admin', 'customer'),
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";

        $result = mysqli_query($conn, $customer);

        if ($result) {
            echo "<h1>Customer Table Created</h1>";
        } else {
            echo "Error in Customer Table" . $conn->error;;
        }

        $category = "CREATE TABLE category (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                category_name VARCHAR(30) NOT NULL,
                category_type VARCHAR(30) NOT NULL,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";


        $result = mysqli_query($conn, $category);

        if ($result) {
            echo "<h1>Category Table Created</h1>";
        } else {
            echo "Error in Category Table" . $conn->error;;
        }

        $products = "CREATE TABLE products (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                product_name VARCHAR(30) NOT NULL,
                category_id int UNSIGNED,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES category(id)
                )";

        $result = mysqli_query($conn, $products);

        if ($result) {
            echo "<h1>Products Table Created</h1>";
        } else {
            echo "Error in Products Table" . $conn->error;;
        }
        $orders = "CREATE TABLE orders (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                customer_id int UNSIGNED,
                product_id int UNSIGNED,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES users(id),
                FOREIGN KEY (product_id) REFERENCES products(id)

                )";

        $result = mysqli_query($conn, $orders);

        if ($result) {
            echo "<h1>Orders Table Created</h1>";
        } else {
            echo "Error in Order Table" . $conn->error;;
        }
        $order_details = "CREATE TABLE order_details (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                order_id int UNSIGNED,
                customer_id int UNSIGNED,
                product_id int UNSIGNED,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (order_id) REFERENCES orders(id),
                FOREIGN KEY (customer_id) REFERENCES users(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
                )";

        $result = mysqli_query($conn, $order_details);

        if ($result) {
            echo "<h1>Customer Table Created</h1>";
        } else {
            echo "Error in Customer Table" . $conn->error;;
        }
    } else {
        echo "Error creating database: " . $conn->error;
    }
}

// Close the connection when you're done
$conn->close();
