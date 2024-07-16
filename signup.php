<?php
include_once('includes/connection.php');
$firstName = '';
$lastName = '';
$email = '';
$password = '';
$confirmPassword = '';
$hashedPassword = '';
$licenseNumber = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $firstName = trim(filter_input(INPUT_POST, 'signupFirstName', FILTER_SANITIZE_STRING));
    $lastName = trim(filter_input(INPUT_POST, 'signupLastName', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'signupEmail', FILTER_SANITIZE_EMAIL));
    $password = $_POST['signupPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $accountType = $_POST['accountType'];

    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match.');
                window.location.href = 'signup.php';  // Redirect back to signup page
              </script>";
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($accountType === 'admin') {
        $query = "SELECT COUNT(*) as count FROM account WHERE accountType = 'admin'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] > 0) {
            echo "<script>
                    alert('An admin account already exists. Only one admin account can be created.');
                    window.location.href = 'signup.php';  // Redirect back to signup page
                  </script>";
            exit;
        }

        $licenseNumber = trim(filter_input(INPUT_POST, 'licenseNumber', FILTER_SANITIZE_STRING));
        if (empty($licenseNumber)) {
            echo "<script>
                    alert('License Number/Valid ID is required for admin account.');
                    window.location.href = 'signup.php';  // Redirect back to signup page
                  </script>";
            exit;
        }
    }

    $sql = "INSERT INTO account (firstName, lastName, email, password, accountType, licenseNumber) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    $stmt->bind_param("ssssss", $firstName, $lastName, $email, $hashedPassword, $accountType, $licenseNumber);
    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful. You can now login.');
                window.location.href = 'login.php';  
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Registration failed. Please try again later.');
                window.location.href = 'signup.php'; 
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
        .hidden {
            display: none;
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
                    <div class="mb-3" id="adminField">
                        <label for="licenseNumber" class="form-label">License Number/Valid ID</label>
                        <input type="text" class="form-control" id="licenseNumber" name="licenseNumber">
                    </div>
                    <div class="mb-3">
                        <label for="accountType" class="form-label">Account Type</label>
                        <select class="form-control" id="accountType" name="accountType" required onchange="toggleAdminField()">
                            <option value="">Select Account Type</option>
                            <option value="tourist">Tourist</option>
                            <option value="admin">Admin</option>
                        </select>
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
    <script>
        function toggleAdminField() {
            const accountType = document.getElementById('accountType').value;
            const adminField = document.getElementById('adminField');
            
            if (accountType === 'admin') {
                adminField.classList.remove('hidden');
                document.getElementById('licenseNumber').setAttribute('required', 'required');
            } else {
                adminField.classList.add('hidden');
                document.getElementById('licenseNumber').removeAttribute('required');
            }
        }
    </script>
</body>
</html>
