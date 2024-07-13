<?php
// Initialize variables
$firstName = '';
$lastName = '';
$email = '';
$password = '';
$confirmPassword = '';
$hashedPassword = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Sanitize and validate input
    $firstName = trim(filter_input(INPUT_POST, 'signupFirstName', FILTER_SANITIZE_STRING));
    $lastName = trim(filter_input(INPUT_POST, 'signupLastName', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'signupEmail', FILTER_SANITIZE_EMAIL));
    $password = $_POST['signupPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate password confirmation
    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match.');
                window.location.href = 'signup.php';  // Redirect back to signup page
              </script>";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $sql = "INSERT INTO admin (firstName, lastName, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    // Bind parameters and execute statement
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful. You can now login.');
                window.location.href = 'login.php';  // Redirect to login page
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Registration failed. Please try again later.');
                window.location.href = 'signup.php';  // Redirect back to signup page
              </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            max-width: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="logo-container">
                    <img src="img/logo.png" alt="Logo">
                </div>
                <h2 class="text-center mb-4">Sign Up</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3">
                        <label for="signupFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="signupFirstName" name="signupFirstName" required value="<?php echo htmlspecialchars($firstName); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="signupLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="signupLastName" name="signupLastName" required value="<?php echo htmlspecialchars($lastName); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="signupEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="signupEmail" name="signupEmail" required value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="signupPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="signupPassword" name="signupPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
                </form>
                <div class="text-center mt-3">
                    <a href="login.php" class="btn btn-link">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
