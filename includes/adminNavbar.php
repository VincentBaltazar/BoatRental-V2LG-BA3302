<?php 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
    
<body>
<nav class="sidebar">
    <div class="logo">
        <h5>BALSA</h5>
    </div>
    <i id="btn" class="fa-solid fa-bars"></i>
    <ul class="nav-links">
        <li>
            <a href="adminIndex.php" onclick="showSection('home', this)">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="adminCaptainList.php" onclick="showSection('homew', this)">
                <i class="fa-solid fa-user"></i>
                <span>Captains</span>
            </a>
        </li>
        <li>
            <a href="mapping.php" onclick="showSection('hd', this)">
                <i class="fa-solid fa-ship"></i>
                <span>Mapping</span>
            </a>
        </li>
        <li>
            <a href="#hd" onclick="showSection('hd', this)">
                <i class="fa-solid fa-ship"></i>
                <span>Boat</span>
            </a>
        </li>
        <li>
            <a href="logout.php" style="margin-top: 230px;">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>

</body>
</html>



