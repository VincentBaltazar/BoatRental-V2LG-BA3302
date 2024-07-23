<?php
include_once('includes/connection.php');

if (isset($_GET['licenseID'])) {
    $licenseID = mysqli_real_escape_string($db, $_GET['licenseID']);
    $query = "SELECT * FROM captains WHERE licenseID = '$licenseID'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $boatImages = json_decode($row['boat'], true);
        // $boatImage = 'path/to/default/image.jpg'; 
        // if (!empty($boatImages)) {
        //     $boatImage = 'uploads/' . htmlspecialchars($boatImages[0]); 
        // }
        $capName = htmlspecialchars($row['captainFirstName'] . ' ' . $row['captainLastName']);
        $profilePic = 'path/to/default/image.jpg'; 
        if (!empty($row['profilePic'])) {
            $profilePic = 'uploads/' . htmlspecialchars($row['profilePic']); 
        }
        $boatName = htmlspecialchars($row['boatName']);
        $boatDescription = htmlspecialchars($row['boatDescription']);
        $boatPrice = htmlspecialchars($row['boatPrice']);
        $capacity = htmlspecialchars($row['capacity']);
        $crewMembers = json_decode($row['crewMembers']);
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
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 10px;
            
        }
        .details img {
            border-radius: 10px;
            width: 100%;
            height: 450px;
            object-fit: cover; 
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
            box-shadow: 2px 2px 20px 4px rgba(32, 38, 38, .18);
        }

        .flex-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .captainName {
            margin-left: 10px;
            margin-top: 10px;
            font-size: 25px;
            font-weight: bold;
        }

        .profile-image {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        /* .price, .capacity, .crew-members {
            float: left;
            margin: 5px 0;
            clear: left;
        } */
        .price, .capacity, .crew-members {
            float: left;
            margin: 5px 0;
            clear: left;
            margin-bottom: 10px; 
        }

        .price span, .capacity span, .crew-members span {
            display: inline-block;
            width: 200px; 
            margin-left: 20px;
        }

        .crew-members span {
            width: auto; 
        }


        .feedback-container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            background-color: white;
            margin-top: 50px;
            padding: 20px;
            border-radius: 10px;
           
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
            width: 95.4%;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-left: 20px;
            text-align: left;
            padding-left: 20px;
        }
        .boat-inc {
            display: flex;
            width: 95.4%;
            padding-top: 30px;
            border-top: 2px solid black;
            margin-top: 100px;
            margin-left: 20px;
            padding-left: 20px;
            margin-right: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .inclusion-list {
            display: flex;
            flex-wrap: wrap;
            list-style-type: none;
            margin: 20px;
            padding: 0;
            font-size: 16px;
        }

        .inclusion-list li {
            flex: 0 0 50%; 
            margin-bottom: 5px;
        }
        @media (max-width: 768px) {
            .feedback-card {
                width: 100%;
                margin-right: 0;
            }
        }
        .rent{
            height: 50px;
            width: 300px;
            margin-top: 10px;
            border-radius: 10px;
            background-color: orange;
        }
        .image-viewer {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .image-viewer img {
            width: 500px;
            max-height: 80vh;
            border-radius: 10px;
        }

        .viewer-close {
            color: #ffffff;
            font-size: 40px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 25px;
            cursor: pointer;
        }

        .viewer-prev, .viewer-next {
            color: white;
            font-size: 50px;
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            text-decoration: none;
        }

        .viewer-prev {
            left: 10px;
        }

        .viewer-next {
            right: 10px;
        }


        

    </style>
</head>
<body id="page-top">
    <?php include_once("includes/navbar.php") ?>
    <div class="container1">
        <div class="details">
            <?php foreach ($boatImages as $index => $image): ?>
                <div class="image-wrapper">
                    <img src="<?php echo 'uploads/' . htmlspecialchars($image); ?>" alt="Boat Image" class="boat-image" onclick="openImageViewer(<?php echo $index; ?>)">
                </div>
            <?php endforeach; ?>
        </div>
        <div id="imageViewer" class="image-viewer">
            <span class="viewer-close" onclick="closeImageViewer()">&times;</span>
            <img id="viewerImage" src="" alt="Boat Image">
            <a class="viewer-prev" onclick="navigateImages(-1)">&#10094;</a>
            <a class="viewer-next" onclick="navigateImages(1)">&#10095;</a>
        </div>

        <div class="boatDet" style="width: 65%">
            <h2 class="boat-name"><?php echo $boatName; ?></h2>
            <p class="desc" style="margin-left: 40px; font-size: 20px; margin-top: 5px; text-align: left;"><?php echo $boatDescription; ?></p>    
            <div class="ratingsFeed">
                <div class="flex-container">
                    <img src="<?php echo $profilePic; ?>" alt="Profile Image" class="profile-image">
                    <p class="captainName"><?php echo $capName; ?></p>
                </div>
    
                <p class="price"><strong>Price:</strong><span>$<?php echo $boatPrice; ?>per hour</span></p>
                <p class="capacity"><strong>Capacity:</strong><span><?php echo $capacity; ?>people</span> </p>
                <p class="crew-members"><strong>Crew Members:</strong>
                    <?php foreach ($crewMembers as $member): ?>
                        <span><?php echo $member; ?></span>, 
                    <?php endforeach; ?>
                </p>

                <!-- Rent Button -->
                <button type="button" onclick="location.href='rent.php?licenseID=<?php echo $licenseID; ?>&boatName=<?php echo urlencode($boatName); ?>&boatPrice=<?php echo $boatPrice; ?>&capacity=<?php echo urlencode($capacity); ?>&capacity=<?php echo $capacity; ?>'" class="rent">Rent This Boat</button>
                
            </div>
                <h6 class="boat-inc">Boat Includes</h6>
                <ul class="inclusion-list">
                    <li>Safety Vest</li>
                    <li>GPS</li>
                    <li>Fishing Gear</li>
                    <li>First Aid Kit</li>
                    <li>Life Raft</li>
                    <li>Snorkeling Equipment</li>
                    <li>Anchor</li>
                    <li>Radio</li>
                </ul>
            
            <div class="feedback-container">
                <div class="feedback-header">
                    <h4>Ratings and Feedback</h4>
                </div>
                <div class="feedback-card">
                    <h5>Tourist Name</h5>
                    <div class="stars">★★★★☆</div>
                    <p class="feedback-text">The boat was in great condition and the captain was very friendly. Had an amazing time!</p>
                </div>
                <div class="feedback-card">
                    <h5>Tourist Name</h5>
                    <div class="stars">★★★☆☆</div>
                    <p class="feedback-text">The trip was good but the weather was not favorable. The captain handled the situation well.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>

    <script>
        function openImageViewer(index) {
            const imageViewer = document.getElementById('imageViewer');
            const viewerImage = document.getElementById('viewerImage');
            viewerImage.src = document.querySelectorAll('.boat-image')[index].src;
            imageViewer.style.display = 'block';
        }

        function closeImageViewer() {
            document.getElementById('imageViewer').style.display = 'none';
        }

        function navigateImages(direction) {
            const images = document.querySelectorAll('.boat-image');
            const viewerImage = document.getElementById('viewerImage');
            let currentIndex = Array.from(images).findIndex(img => img.src === viewerImage.src);
            let newIndex = currentIndex + direction;

            if (newIndex < 0) {
                newIndex = images.length - 1;
            } else if (newIndex >= images.length) {
                newIndex = 0;
            }

            viewerImage.src = images[newIndex].src;
        }

        </script>



</body>
</html>
