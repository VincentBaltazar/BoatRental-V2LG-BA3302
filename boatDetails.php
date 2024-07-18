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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <style>
        .container1 {
            align-items: center;
        }
        .details {
            text-align: center;
        }
        .details img {
            border-radius: 10px;
            width: 100%;
            height: 450px;
        }
        .boatDet {
            position: relative; 
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: center;
            height: 1000px;
            background-color: white;
            width: 100%;
        }
        .ratingsFeed {
            position: fixed;
            top: 70%; 
            right: 30px; 
            transform: translateY(-50%); 
            border-radius: 10px;
            background-color: white;
            width: 400px;
            height: 300px;
            padding: 20px;
            overflow: auto;
            z-index: 100; 
            box-shadow: 0px 3px 40px #000;
        }

        .flex-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .captainName {
            margin-left: 10px;
            margin-top: 10px;
            font-size: 40px;
            font-weight: bold;
        }

        .profile-image {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .price, .capacity, .crew-members {
            margin: 5px 0;
        }

        .feedback-container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            background-color: white;
            margin-top: 150px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .feedback-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
            width: 100%;
        }
        .feedback-header h4 {
            margin: 0;
            margin-left: 10px;
        }
        .feedback-card {
            width: calc(50% - 10px);
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            margin-right: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .feedback-card h5 {
            margin: 0;
        }
        .stars {
            color: gold;
            font-size: 1.2em;
            margin: 5px 0;
        }
        .feedback-text {
            font-size: 0.9em;
            color: #555;
        }
        .boat-name {
            width: 98%;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
            MARGIN-LEFT: 20px;
            text-align: left;
            padding-left: 20px;
            border-bottom: 2px solid black;
        }
        @media (max-width: 768px) {
            .feedback-card {
                width: 100%;
                margin-right: 0;
            }
        }
        .rent{
            height: 40px;
            width: 150px;
            margin-top: 20px;
            border-radius: 10px;
            background-color: orange;
        }
        

    </style>
</head>
<body id="page-top">
    <?php include_once("includes/navbar.php") ?>
    <div class="container1">
        <div class="details">
            <img src="<?php echo $boatImage; ?>" alt="Boat Image" class="boat-image">
        </div>
        <div class="boatDet">
            <h2 class="boat-name"><?php echo $boatName; ?></h2>
            <p class="desc" style="margin-left: 40px; font-size: 30px; margin-top: 5px;"><?php echo $boatDescription; ?></p>    
            <div class="ratingsFeed">
                <div class="flex-container">
                    <img src="<?php echo $profilePic; ?>" alt="Profile Image" class="profile-image">
                    <p class="captainName"><?php echo $capName; ?></p>
                </div>
                <p class="price">Price: $<?php echo $boatPrice; ?> per hour</p>
                <p class="capacity">Capacity: <?php echo $capacity; ?> people</p>
                <p class="crew-members">Crew Members: <?php echo $crewMembers; ?></p>
                <button class="rent">Rent This Boat</button>
            </div>
            <div class="feedback-container">
                <div class="feedback-header">
                    <h4>Ratings and Feedback</h4>
                </div>
                <div class="feedback-card">
                    <h5>Tourist Name</h5>
                    <div class="stars">★★★★★</div>
                    <div class="feedback-text">
                        This is the feedback text provided by the tourist. It gives details about their experience and thoughts.
                    </div>
                </div>
                <div class="feedback-card">
                    <h5>Tourist Name</h5>
                    <div class="stars">★★★★★</div>
                    <div class="feedback-text">
                        This is the feedback text provided by the tourist. It gives details about their experience and thoughts.
                    </div>
                </div>
            </div>  
        </div>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
