<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

include_once('includes/connection.php');

$userID = $_SESSION['id']; 

$query = "SELECT id, firstName, lastName, email, accountType, licenseNumber FROM account WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('s', $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $firstName = $row['firstName'];
    $lastName = $row['lastName'];
    $email = $row['email'];
    $accountType = $row['accountType'];
    $licenseNumber = $row['licenseNumber'];
} else {
    echo "User profile not found.";
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/navbar.css" rel="stylesheet">
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .grid-items1 {
            height: 150px;
            display: grid;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            border: 2px solid black;
            background-color: white;
            border-radius: 15px;
        }
        .bx {
            color: black;
            font-size: 40px;
            margin-right: 50px;
        }
        .profile-container {
            width: 60%;
            margin: 10px auto; /* Center align and add margin */
            border-radius: 10px;
            background-color: white;
            text-align: left;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Add shadow for better visibility */
        }
        .profile-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }
        .profile-info {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .profile-info label {
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            display: block;
            margin-bottom: 5px;
        }
        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
            padding: 8px;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
            border-radius: 4px;
        }
        .profile-info input[type="text"], .profile-info input[type="email"] {
            margin: 5px 0;
            font-size: 16px;
            padding: 8px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 4px;
            width: calc(100% - 18px);
        }
        .profile-actions {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            background-color: #7289DA;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: orange;
        }
    </style>
</head>
<body>
    <?php include_once('includes/adminNavbar.php'); ?>
    <section class="section" id="home">
        <section class="dashboard section-container">
            <div class="section-header">
                DASHBOARD
                <div class="user">
                    <a href="adminProfile.php">
                        <i class='bx bx-user-circle'></i>
                    </a>
                </div>
            </div>
        <div class="profile-container">
        <h2 style="float: left; margin-bottom: 30px;">User Profile</h2>
        <form id="profileForm" method="post">
            <!-- <div class="profile-info">
                <label style="margin-top: 70px;">ID:</label>
                <p style="width: 50px; text-align: center;"><?php echo $id; ?></p>
            </div> -->
            <div class="profile-info">
                <label style="margin-top: 70px;">First Name:</label>
                <input type="text" class="form-control" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>" readonly>
            </div>
            <div class="profile-info">
                <label>Last Name:</label>
                <input type="text" class="form-control" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>" readonly>
            </div>
            <div class="profile-info">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="profile-info">
                <label>Account Type:</label>
                <input type="text" class="form-control" name="accountType" value="<?php echo htmlspecialchars($accountType); ?>" readonly>
            </div>
            <div class="profile-info">
                <label>License Number:</label>
                <input type="text" class="form-control" name="licenseNumber" value="<?php echo htmlspecialchars($licenseNumber); ?>" readonly>
            </div>
            
            <!-- Edit Profile Button -->
            <div class="profile-actions">
                <button type="button" id="editProfileBtn" class="btn btn-primary">Edit Profile</button>
                <button type="submit" id="saveProfileBtn" class="btn btn-success" style="display: none;">Save Changes</button>
            </div>
        </form>
    </div>
        </section>
    </section>
    <script>
        let btn = document.querySelector('#btn');
        let sidebar = document.querySelector('.sidebar');
        let sections = document.querySelectorAll('.section');
        let navLinks = document.querySelectorAll('.nav-links a');

        btn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            sections.forEach(section => {
                section.classList.toggle('shifted');
            });
        });

        function showSection(id, element) {
            sections.forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(id).classList.remove('hidden');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
            });
            element.classList.add('active');
        }
       
    </script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script>
        document.getElementById('editProfileBtn').addEventListener('click', function() {
            var formElements = document.getElementById('profileForm').elements;
            for (var i = 0; i < formElements.length; i++) {
                if (formElements[i].type !== 'submit') {
                    formElements[i].readOnly = false;
                    formElements[i].classList.add('editable');
                }
            }
            document.getElementById('editProfileBtn').style.display = 'none';
            document.getElementById('saveProfileBtn').style.display = 'inline-block';
        });
    </script>
</body>
</html>
