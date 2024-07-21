<?php
include_once('includes\connection.php');   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'saveCaptain') {
        $capFName = isset($_POST['forCaptainFName']) ? mysqli_real_escape_string($db, $_POST['forCaptainFName']) : '';
        $capLName = isset($_POST['forCaptainLName']) ? mysqli_real_escape_string($db, $_POST['forCaptainLName']) : '';
        $profile = isset($_FILES['forProfile']) ? $_FILES['forProfile'] : [];
        $licenseNum = isset($_POST['forLicenseNumber']) ? mysqli_real_escape_string($db, $_POST['forLicenseNumber']) : '';
        $boatName = isset($_POST['forBoatName']) ? mysqli_real_escape_string($db, $_POST['forBoatName']) : '';
        $boat = isset($_FILES['forBoat']) ? $_FILES['forBoat'] : [];
        $boatDesc = isset($_POST['forBoatDes']) ? mysqli_real_escape_string($db, $_POST['forBoatDes']) : '';
        $boatPrice = isset($_POST['forBoatPrice']) ? mysqli_real_escape_string($db, $_POST['forBoatPrice']) : '';
        $boatCapacity = isset($_POST['forBoatCapacity']) ? mysqli_real_escape_string($db, $_POST['forBoatCapacity']) : '';
        $crewMem = isset($_POST['forCrew']) ? $_POST['forCrew'] : [];
        $req = isset($_FILES['forRequirements']) ? $_FILES['forRequirements'] : [];

        if (empty($capFName) || empty($capLName) || empty($licenseNum) || empty($req) || empty($boatPrice)) {
            echo "Error: All fields are required.";
        } else {
            $errors = [];
            $uploadedFiles = [];
            $boatImgNames = [];
            $profileImgName = '';

            if (!empty($profile['name'])) {
                $profileImgName = $profile['name'];
                $profileImgTmpName = $profile['tmp_name'];
                $profileImgError = $profile['error'];

                if ($profileImgError === UPLOAD_ERR_OK) {
                    $profileImgEx = pathinfo($profileImgName, PATHINFO_EXTENSION);
                    $profileImgExLc = strtolower($profileImgEx);
                    $allowedExs = array("jpg", "jpeg", "png");

                    if (in_array($profileImgExLc, $allowedExs)) {
                        $newProfileImgName = uniqid("PROFILE-", true) . '.' . $profileImgExLc;
                        $profileImgPath = 'C:/xampp/htdocs/BoatRental-V2LG-BA3302/uploads/' . $newProfileImgName;

                        if (move_uploaded_file($profileImgTmpName, $profileImgPath)) {
                            $profileImgName = $newProfileImgName;
                        } else {
                            $errors[] = "Error: Failed to move uploaded profile picture.";
                        }
                    } else {
                        $errors[] = "Error: You can't upload this file type for profile picture.";
                    }
                } else {
                    $errors[] = "Error: Unknown error occurred while uploading profile picture.";
                }
            }

            if (!empty($boat['name'][0])) {
                foreach ($boat['tmp_name'] as $key => $tmpName) {
                    $boatImgName = $boat['name'][$key];
                    $boatImgError = $boat['error'][$key];

                    if ($boatImgError === UPLOAD_ERR_OK) {
                        $boatImgEx = pathinfo($boatImgName, PATHINFO_EXTENSION);
                        $boatImgExLc = strtolower($boatImgEx);
                        $allowedExs = array("jpg", "jpeg", "png");

                        if (in_array($boatImgExLc, $allowedExs)) {
                            $newBoatImgName = uniqid("BOAT-", true) . '.' . $boatImgExLc;
                            $boatImgPath = 'C:/xampp/htdocs/BoatRental-V2LG-BA3302/uploads/' . $newBoatImgName;

                            if (move_uploaded_file($tmpName, $boatImgPath)) {
                                $boatImgNames[] = $newBoatImgName; 
                            } else {
                                $errors[] = "Error: Failed to move uploaded boat image.";
                            }
                        } else {
                            $errors[] = "Error: You can't upload this file type for boat image.";
                        }
                    } else {
                        $errors[] = "Error: Unknown error occurred while uploading boat image.";
                    }
                }
            }
            if (!empty($req['name'][0])) {
                foreach ($req['tmp_name'] as $key => $tmpName) {
                    $imageName = $req['name'][$key];
                    $imageError = $req['error'][$key];

                    if ($imageError === UPLOAD_ERR_OK) {
                        $imageEx = pathinfo($imageName, PATHINFO_EXTENSION);
                        $imageExLc = strtolower($imageEx);
                        $allowedExs = array("jpg", "jpeg", "png");

                        if (in_array($imageExLc, $allowedExs)) {
                            $newImgName = uniqid("REQ-", true) . '.' . $imageExLc;
                            $imagePath = 'C:/xampp/htdocs/BoatRental-V2LG-BA3302/uploads/' . $newImgName;

                            if (move_uploaded_file($tmpName, $imagePath)) {
                                $uploadedFiles[] = $newImgName;
                            } else {
                                $errors[] = "Error: Failed to move uploaded requirement image.";
                            }
                        } else {
                            $errors[] = "Error: You can't upload this file type for requirement image.";
                        }
                    } else {
                        $errors[] = "Error: Unknown error occurred while uploading requirement image.";
                    }
                }
            }
            if (empty($errors)) {
                $crewMemJson = mysqli_real_escape_string($db, json_encode($crewMem));
                $reqJson = mysqli_real_escape_string($db, json_encode($uploadedFiles));
                $boatImgJson = mysqli_real_escape_string($db, json_encode($boatImgNames));

                $checkQuery = "SELECT * FROM captains WHERE licenseID = '$licenseNum'";
                $checkResult = mysqli_query($db, $checkQuery);

                if (mysqli_num_rows($checkResult) > 0) {
                    echo "<script>alert('Captain \"$licenseNum\" already exists!');</script>";
                } else {
                    $query = "INSERT INTO captains (captainFirstName,captainLastName, profilePic, licenseID, boatName, boat, boatDescription, boatPrice, capacity, crewMembers, requirements) 
                        VALUES ('$capFName', '$capLName', '$profileImgName', '$licenseNum', '$boatName', '$boatImgJson', '$boatDesc', '$boatPrice', $boatCapacity, '$crewMemJson', '$reqJson')";
                    $result = mysqli_query($db, $query);

                    if ($result) {
                        $email = $licenseNum;
                        $hashedPassword = password_hash($licenseNum, PASSWORD_DEFAULT); // Hashing the password
                        $accountType = 'captain';

                        $adminQuery = "INSERT INTO account (firstName, lastName, email, password, accountType, licenseNumber) 
                                    VALUES ('$capFName', '$capLName', '$email', '$hashedPassword', '$accountType', '$licenseNum')";
                        $adminResult = mysqli_query($db, $adminQuery);

                        if ($adminResult) {
                            echo "<script>alert('Captain added successfully!');</script>";
                        } else {
                            echo "Error adding captain to admin table: " . mysqli_error($db);
                        }
                    } else {
                        echo "Error: " . mysqli_error($db);
                    }
                }
            } else {
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
            }
        }
    }
}


$query = "SELECT * FROM captains";
$result = mysqli_query($db, $query);

$rows = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows .= '<tr>';
        $rows .= '<td>' . htmlspecialchars($row['captainFirstName'] . ' ' . $row['captainLastName']) . '</td>';


        if (!empty($row['profilePic'])) { 
            $profileImagePath = 'uploads/' . $row['profilePic'];
            $rows .= '<td><img src="' . $profileImagePath . '" alt="Profile Image" style="max-width: 50px; max-height: 50px;"></td>';
        } else {
            $rows .= '<td>No image</td>';
        }

        $rows .= '<td>' . htmlspecialchars($row['licenseID']) . '</td>';
        $rows .= '<td>' . htmlspecialchars($row['crewMembers']) . '</td>';
        $rows .= '<td>' . htmlspecialchars($row['boatName']) . '</td>';

        $boatImages = json_decode($row['boat']);
        if ($boatImages !== null && json_last_error() === JSON_ERROR_NONE) {
            $rows .= '<td>';
            foreach ($boatImages as $image) {
                $boatImagePath = 'uploads/' . $image;
                $rows .= '<img src="' . $boatImagePath . '" alt="Boat Image" style="max-width: 50px; max-height: 50px;">';
            }
            $rows .= '</td>'; 
        } else {
            $rows .= '<td>No images</td>';
        }

        $requirements = json_decode($row['requirements']);
        $rows .= '<td>';
        foreach ($requirements as $requirement) {
            $requirementPath = 'uploads/' . $requirement;
            $rows .= '<img src="' . $requirementPath . '" alt="Requirement Image" style="max-width: 50px; max-height: 50px;">';
        }
        $rows .= '</td>'; 

        $rows .= '<td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal_' . $row['licenseID'] . '">
                      Edit
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal_' . $row['licenseID'] . '">
                      Delete
                    </button>
                  </td>';
        $rows .= '</tr>';
    }
} else {
    echo "<script>swal.fire('Oops!', 'No records found!', 'warning');</script>";
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captain List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="css/navbar.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .section {
            padding: 20px;
        }
        .dashboard .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .dashboard .section-header .user {
            display: flex;
            align-items: center;
        }
        table {
            width: 100%;
            margin: 30px 0;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-warning {
            font-size: 20px;
            background-color: #ffc107;
            color: white;
            border: none;
        }
        .options {
            text-align: center;
        }
        .options a {
            margin: 0 5px;
        }
        .controls {
            margin-bottom: 20px;
        }
        .controls label {
            margin-right: 10px;
        }
        .controls input,
        .controls select {
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .pagination {
            display: flex;
            justify-content: flex-end;
            list-style-type: none;
            padding: 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination li a {
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #007bff;
        }
        .pagination li a.active {
            background-color: #007bff;
            color: white;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .dataTables_wrapper .dataTables_filter {
            text-align: right;
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            width: 250px;
            max-width: 100%;
            box-sizing: border-box;
            font-size: 14px;
        }

        .dataTables_wrapper .dataTables_filter label {
            font-weight: normal;
            margin-right: 10px;
        }
        .dataTables_wrapper .dataTables_length {
            padding-top: 10px;
            float: left;
            color: green;
        }

        .modal {
            display: none;
            position: absolute;
            margin-left: 350px;
            z-index: 1;
            left: 0;
            top: 0;
            width: 700px;
            height: 700px;
            overflow: auto;
            border-radius: 10px;
            padding-top: 60px;
            
            
        }
        .modal-content {
            font-size: 24px;
            background-color: #fefefe;
            border-radius: 10px;
            margin: 5% auto;
            margin-left: 5%;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .inputTypes{
            border-radius: 5px;
            font-size: 15px;
            height: 30px;
            width: 300px;
        }
        .overlay {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .preview-container img {
            max-width: 100px;
            margin: 10px;
        }
        .bx {
            color: black;
            font-size: 40px;
            margin-right: 50px;
        }

        @media (max-width: 800px) {
            .dashboard .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }
            .section-header {
                padding-bottom: 30px;
                margin-left: 20px;
                font-weight: 900;
                font-size: 30px;
                letter-spacing: -1px;
            }
            .section {
                padding: 100px;
                margin-left: 60px;
                transition: margin-left .3s ease;
            }
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }
        @media (max-width: 650px) {
            .dashboard .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }
            .section-header {
                padding-bottom: 30px;
                margin-left: 20px;
                font-weight: 900;
                font-size: 30px;
                letter-spacing: -1px;
            }
            .section {
                padding: 100px;
                margin-left: 60px;
                transition: margin-left .3s ease;
            }
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }
        @media (max-width: 480px) {
            .dashboard .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }
            .section-header {
                padding-bottom: 30px;
                margin-left: 20px;
                font-weight: 900;
                font-size: 30px;
                letter-spacing: -1px;
            }
            .section {
                padding: 100px;
                margin-left: 60px;
                transition: margin-left .3s ease;
            }
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
<?php include_once('includes/adminNavbar.php'); ?>
    <section class="section" id="captains">
        <section class="dashboard section-container">
            <div class="section-header">
                CAPTAINS
                <div class="user">
                    <a href="adminProfile.php">
                        <i class='bx bx-user-circle'></i>
                    </a>
                </div>
            </div>
            <button class="btn btn-warning" id="addButton" style="float: right; margin-right: 10px; margin-bottom: 10px; width: 250px;">Add</button>

            <table id="captainTable" class="display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Profile</th>
                        <th>License Number</th>
                        <th>Crew Members</th>
                        <th>Boat Name</th>
                        <th>Boat</th>
                        <th>Requirements</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $rows; ?>
                </tbody>
            </table>
        </section>
    </section>

    <div id="overlay" class="overlay">
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 style="padding-bottom: 20px;">Add Captain</h2>
                <form id="addCaptainForm" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="captainFName">First Name:</label>
                        <input type="text" style="margin-left: 20px;" id="captainFName" class="inputTypes" name="forCaptainFName" required>
                    </div>
                    <div>
                        <label for="captainLName">Last Name:</label>
                        <input type="text" style="margin-left: 20px;" id="captainLName" class="inputTypes" name="forCaptainLName" required>
                    </div>
                    <div>
                        <label for="profile">Upload Profile:</label>
                        <input type="file" style="margin-left: 65px;" id="profile" name="forProfile">
                    </div>
                    <div>
                        <label for="licenseNumber">License Number:</label>
                        <input type="text" style="margin-left: 20px;" id="licenseNumber" class="inputTypes" name="forLicenseNumber" required>
                    </div>
                    <div>
                        <label for="boatName">Boat Name</label>:</label>
                        <input type="text" style="margin-left: 20px;" id="boatName" class="inputTypes" name="forBoatName" required>
                    </div>
                    <div>
                        <label for="boat">Upload Boat Images:</label>
                        <input type="file" id="boat" name="forBoat[]" multiple onchange="previewBoats(event)">
                    </div>
                    <div class="preview-container" id="boatsPreview"></div>
                    <div>
                        <label for="boatDes">Boat Description:</label>
                        <input type="text" style="margin-left: 20px;" id="boatDes" class="inputTypes" name="forBoatDes" required>
                    </div>
                    <div>
                        <label for="boatPrice">Boat Price:</label>
                        <input type="text" style="margin-left: 20px;" id="boatPrice" class="inputTypes" name="forBoatPrice" required>
                    </div>
                    <div>
                        <label for="boatCapacity">Boat Capacity:</label>
                        <input type="text" style="margin-left: 20px;" id="boatCapacity" class="inputTypes" name="forBoatCapacity" required>
                    </div>
                    <div>
                        <label for="crewMembers">Crew Members:</label>
                        <div id="crewMembers">
                            <input type="text" name="forCrew[]" placeholder="Crew Member Name" required>
                        </div>
                        <button type="button" id="addCrewMember">Add Crew Member</button>
                    </div>
                    <div>
                        <label for="requirements">Upload Requirements:</label>
                        <input type="file" id="requirements" name="forRequirements[]" multiple required>
                    </div>
                    <input type="hidden" name="action" value="saveCaptain">
                    <div class="modal-footer" style="padding: 20px 0px 10px 0px; margin-left: 320px;">
                        <button type="submit" class="btn btn-warning" id="saveCaptain">Add</button>
                        <button type="button" class="btn" style="background-color: red; font-size: 20px; color: white; border: none;" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
        let modal = document.getElementById("myModal");
        let btnModal = document.getElementById("addButton");
        let span = document.getElementsByClassName("close")[0];
        let overlay = document.getElementById("overlay");

        btnModal.onclick = function() {
            modal.style.display = "block";
            overlay.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
            overlay.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == overlay) {
                modal.style.display = "none";
                overlay.style.display = "none";
            }
        }

        document.getElementById("addCrewMember").addEventListener("click", function() {
            var crewMembersDiv = document.getElementById("crewMembers");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "forCrew[]";
            input.placeholder = "Crew Member Name";
            input.required = true;
            crewMembersDiv.appendChild(input);
        });

        
        $("#addCaptainForm").on("submit", function(event) {
            if (!validateForm()) {
                event.preventDefault(); 
                return;
            }
            
        });

        function validateForm() {
            
            var captainFName = $("#captainFName").val();
            var captainLName = $("#captainLName").val();

            if (!captainFName || !captainLName) {
                alert("Both First Name and Last Name of the Captain are required.");
                return false;
            }
            
            return true;
        }

        
        $('#captainTable').DataTable();
    });

    function previewBoats(event) {
        const previewContainer = document.getElementById('boatsPreview');
        const files = event.target.files;

        if (files) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px'; 
                    img.style.margin = '10px'; 
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    }
    </script>
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

</body>
</html>