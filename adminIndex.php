<?php
include_once('includes/connection.php');

$query = "SELECT SUM(JSON_LENGTH(crewMembers)) AS total_crew_members FROM captains";
$result = mysqli_query($db, $query);


if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $crewMembersCount = $row['total_crew_members']; 
} else {
    $crewMembersCount = 0; 
}


$query = "SELECT COUNT(*) AS total_captain FROM captains";
$result = mysqli_query($db, $query);


if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCaptainCount = $row['total_captain']; 
} else {
    $totalCaptainCount = 0; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
    </style>
</head>
<body>
    <?php include_once('includes/adminNavbar.php'); ?>
    <section class="section" id="home" style="background-color: #F7F9F2; padding-bottom: 50px;">
        <section class="dashboard section-container">
            <div class="section-header">
                DASHBOARD
                <div class="user">
                    <i class='bx bx-user-circle'></i>
                </div>
            </div>
            <div class="grid-container">
                <?php
                echo '<div class="grid-items1">' . $crewMembersCount . ' </div>';
                echo '<div class="grid-items1">' . $totalCaptainCount . ' </div>';
                echo '<div class="grid-items1">' . "Tourist" . ' </div>';
                ?>
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
</body>
</html>
