<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $email = $_SESSION['email'];

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database (this example uses a hypothetical function)
    // update_password_in_db($email, $hashed_password);

    echo "Password has been updated successfully.";

    // Clear the session
    session_unset();
    session_destroy();
}
?>
