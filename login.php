<?php
session_start(); // Start the session at the top of the script
include_once('includes/connection.php');

$email = '';
$password = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $errorMessage = "Please fill in both fields.";
        } else {
            $sql = "SELECT * FROM account WHERE email = ? LIMIT 1";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['firstName'] = $user['firstName'];
                    $_SESSION['lastName'] = $user['lastName'];
                    $_SESSION['accountType'] = $user['accountType'];
                    $_SESSION['email'] = $user['email'];


                    $redirectUrl = '';

                    if ($user['accountType'] == 'admin') {
                        $redirectUrl = 'adminIndex.php';
                    } elseif ($user['accountType'] == 'tourist') {
                        $redirectUrl = 'index.php';
                    } else {
                        $redirectUrl = 'captainIndex.php';
                    }
                    header("Location: $redirectUrl");
                    exit();
                } else {
                    $errorMessage = "Invalid email or password.";
                }
            } else {
                $errorMessage = "Invalid email or password.";
            }
        }
    } else {
        $errorMessage = "Please fill in both fields.";
    }
}
?>

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
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        .spaced-text {
            font-family: 'Cursive';
            font-weight: bold;
            color: black;
            letter-spacing: 0.2em; 
        }
        .google-signin {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .g_id_signin > div {
            width: 100%;
        }

    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 d-flex justify-content-center align-items-center flex-column left-box"
            style="background: #9EDDFF; border-radius: 50px 140px 50px 140px;">
                <div class="featured-image mb-3">
                    <img src="img/logo.png" class="img-fluid" style="width: 250px;">
                </div>
                <p class="fs-2 spaced-text">BALSA</p>
                <small class="text-white text-wrap text-center"
                    style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Lagye ng text ng maporma.</small>
            </div>
            <div class="col-md-6 right-box">
                <form action="login.php" method="post">
                    <div class="row align-items-center">
                        <div class="header-text mb-4">
                            <h2 style="text-align: center; font-family: 'Times New Roman', 'Copperplate'; font-weight: 1000;">Login</h2>
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
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary">
                                    <small>Remember Me</small>
                                </label>
                            </div>
                            <div class="forgot"></div>
                            <small><a href="">Forgot Password</a></small>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                        <div class="input-group mb-3">
                            <div id="g_id_onload"
                                 data-client_id="843854210696-9cao0fkvimufgsc9h9ljvblq6973i16q.apps.googleusercontent.com"
                                 data-callback="handleCredentialResponse"
                                 data-auto_prompt="false">
                            </div>
                            <div class="g_id_signin w-100 google-signin" data-type="standard"></div>
                        </div>
                        <div class="row">
                            <small class="sign" style="text-align: center; ">Don't have an account?<a href="signup.php">Sign Up</a></small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function handleCredentialResponse(response) {
        const responsePayload = parseJwt(response.credential);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "api\google-callback.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                window.location.href = xhr.responseText;
            }
        };
        xhr.send(JSON.stringify({
            credential: response.credential,
            clientId: "843854210696-9cao0fkvimufgsc9h9ljvblq6973i16q.apps.googleusercontent.com"
        }));
    }

    function parseJwt(token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));

        return JSON.parse(jsonPayload);
    }

    <?php if (!empty($errorMessage)) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '<?php echo $errorMessage; ?>'
        });
    <?php endif; ?>
    </script>
</body>
</html>
