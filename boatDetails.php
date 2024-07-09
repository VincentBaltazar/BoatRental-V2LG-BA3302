<?php
include_once('includes/connection.php');

if (isset($_GET['licenseID'])) {
    $licenseID = mysqli_real_escape_string($db, $_GET['licenseID']);
    $query = "SELECT * FROM captains WHERE licenseID = '$licenseID'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $boatImages = json_decode($row['boat']);
        $boatImage = 'path/to/default/image.jpg'; 
        if (!empty($boatImages)) {
            $boatImage = 'uploads/' . htmlspecialchars($boatImages[0]); 
        }
        $capName = htmlspecialchars($row['captainName']);
        $profilePic = 'path/to/default/image.jpg'; 
        if (!empty($row['profilePic'])) {
            $profilePic = 'uploads/' . htmlspecialchars($row['profilePic']); 
        }
        $boatName = htmlspecialchars($row['boatName']);
        $boatDescription = htmlspecialchars($row['boatDescription']);
        $boatPrice = htmlspecialchars($row['boatPrice']);
        $capacity = htmlspecialchars($row['capacity']);
        $crewMembers = htmlspecialchars($row['crewMembers']);
    } else {
        echo "<p>Boat not found.</p>";
        exit;
    }
} else {
    echo "<p>No boat selected.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 100vh;
            align-items: center;
        }
        .details {
            grid-column: 1 / span 2;
            text-align: center;
        }
        .details img {
            border-radius: 10px;
            width: 100%;
            height: 450px;
        }
        .boatDet {
            text-align: center;
            height: 300px;
            background-color: white;
        }
        .ratingsFeed {
            border-radius: 10px;
            border: 1px solid black;
            height: 300px;
            background-color: white;
        }
        .ratingsFeed p {
            margin: 10px;
            font-size: 25px;
        }
        .profile-image {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-left: 20px;
            margin-top: 10px;
        }
        .flex-container {
            display: flex;
            align-items: center;
        }
        .flex-container p {
            margin: 10;
            font-size: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="details">
            <img src="<?php echo $boatImage; ?>" alt="Boat Image" class="boat-image">
        </div>
        <div class="boatDet">
            <h2><?php echo $boatName; ?></h2>
            <div style="background-color: yellow; width: 70%; margin-left: 100px; height: 200px; border-radius: 20px 70px 20px 70px;">
                <p><?php echo $boatDescription; ?></p>
            </div>
        </div>
        <div class="ratingsFeed">
            <div class="flex-container">
                <p><?php echo $capName; ?></p>
                <img src="<?php echo $profilePic; ?>" alt="Profile Image" class="profile-image">
            </div>
            <p class="price">Price: $<?php echo $boatPrice; ?> per hour</p>
            <p class="capacity">Capacity: <?php echo $capacity; ?> people</p>
            <p class="crew-members">Crew Members: <?php echo $crewMembers; ?></p>
        </div>
    </div>
</body>
</html>
