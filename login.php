
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/LoginStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .spaced-text {
            font-family: 'Cursive';
            font-weight: bold;
            color: black;
            letter-spacing: 0.2em; 
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6  d-flex justify-content-center align-items-center flex-column left-box"
            style="background: #9EDDFF;  border-radius: 50px 140px 50px 140px;">
            <div class="featured-image mb-3">
                <img src="img\logo.png" class="img-fluid" style="width: 250px;">
            </div>
            <p class="fs-2 spaced-text">BALSA
        </p>
            <small class="text-white text-wrap text-center"
                style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Lagye ng text ng maporma.</small>
        </div>
        <div class="col-md-6 right-box">
            <form action="login.php" method="post">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                    <h2 style="text-align: center; font-family: 'Times New Roman', 'Copperplate'; font-weight: 1000; ">Login</h2>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control form-control-lg bg-light fs-6"
                        id="email" name="email" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control form-control-lg bg-light fs-6"
                        id="password" name="password" placeholder="Password">
                </div>
                <div class="input-group mb-5 d-flex justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" class="form-chech-input" id="formCheck">
                        <label for="formCheck" classs="form-check-label text-secondary">
                            <small>Remember Me</small></label>
                    </div>
                    <div class="forgot"></div>
                        <small><a href="">Forgot Password</a></small>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6"><a href="index.php"></a>Login</button>
                </div>
                <div class="input-group mb-3">
                    <button  type="button" class="btn btn-lg btn-light w-100 fs-6" onclick="handleGoogleSignIn()"><img src="img\boat\google.png" style="width:30px"
                    class="me-2"><small>Sign In with Google</small></button>
                </div>
                <div class="row">
                    <small class="sign" style="text-align: center;">Don't have an account?<a href="signup.php">Sign Up</a></small>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
    function handleGoogleSignIn() {
        window.location.href = 'http://localhost:3000/auth/google'; 
    }
    </script>
</body>
</html>
<?php
include_once('includes/connection.php'); 

$email = '';
$password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $sql = "SELECT * FROM admin WHERE email = ? LIMIT 1";
        $stmt = $db->prepare($sql); 
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // if (password_verify($password, $user['password'])) {
            //     // Password is correct, start the session and redirect
            //     session_start();
            //     $_SESSION['id'] = $user['id'];
            //     $_SESSION['name'] = $user['name'];

            //     echo "<script>
            //         Swal.fire({
            //             icon: 'success',
            //             title: 'Login Successful',
            //             text: 'Redirecting to home page...',
            //             timer: 2000,
            //             showConfirmButton: false
            //         }).then(() => {
            //             window.location.href = 'index.php';
            //         });
            // </script>";
            if ($password === $user['password']) {
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['firstName'];

                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: 'Redirecting to home page...',
                        timer: 5000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                </script>";
            } else {
                // Invalid password
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Invalid email or password.'
                    });
                </script>";
            }
        } else {
            // Invalid email
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: 'Invalid email or password.'
                });
            </script>";
        }
    } else {
        // Email or password fields are empty
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Please fill in both fields.'
            });
        </script>";
    }
}
?>


