<?php
// Database connection details
$host = 'sql107.infinityfree.com';  // MySQL host
$username = 'if0_37049035';   // MySQL username (default for XAMPP is 'root')
$password = 'VVMuGUawW0Bl9Q';       // MySQL password (default for XAMPP is empty)
$dbname = 'if0_37049035_portfolio';  // The name of your database (should match the one created in phpMyAdmin)

// Create a new connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted email and trim spaces
    $email = trim($_POST['email']);
    
    // Validate the email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the email already exists in the database
        $checkQuery = "SELECT * FROM subscriptions WHERE email = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            // Email already exists
            echo "This email is already subscribed.";
                            // Redirect to the new website after 3 seconds
                            header("refresh:1;url=https://punsarajms.me");
                            exit;  // Ensure script stops here after redirect
        } else {
            // Insert the email into the database
            $insertQuery = "INSERT INTO subscriptions (email) VALUES (?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("s", $email);
            
            if ($insertStmt->execute()) {
                // Success message
                echo "Thank you for subscribing! You will be redirected shortly.";
                
                // Redirect to the new website after 3 seconds
                header("refresh:1;url=https://punsarajms.me");
                exit;  // Ensure script stops here after redirect
            } else {
                // Error inserting into the database
                echo "Error: " . $insertStmt->error;
            }

            $insertStmt->close();
        }

        $checkStmt->close();
    } else {
        // Invalid email address
        echo "Invalid email address.";
                        // Redirect to the new website after 3 seconds
                        header("refresh:1;url=https://punsarajms.me");
                        exit;  // Ensure script stops here after redirect
    }
}

// Close the database connection
$conn->close();
?>
