<?php
include_once('includes/connection.php');

$query = "SELECT * FROM captains";
$result = mysqli_query($db, $query);

$cards = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $boatImages = json_decode($row['boat']);
        $boatImage = 'path/to/default/image.jpg'; 
        if (!empty($boatImages)) {
            $boatImage = 'uploads/' . htmlspecialchars($boatImages[0]); 
        }

        $licenseID = htmlspecialchars($row['licenseID']);
        $boatName = htmlspecialchars($row['boatName']);
        $boatDescription = htmlspecialchars($row['boatDescription']);
        $boatPrice = htmlspecialchars($row['boatPrice']);
        $capacity = htmlspecialchars($row['capacity']);
        $cards .= "
        <a href='boatDetails.php?licenseID=$licenseID' class='card-link'>
        <div class='card'>
            <img src='$boatImage' alt='Boat Image'>
            <div class='card-container'>
                <h4>$boatName</h4>
                <p>$boatDescription</p>
                <p class='price'>$ $boatPrice per hour</p>
                <p class='capacity'>Capacity: $capacity people</p>
            </div>
        </div>
        </a>";
    }
} else {
    $cards .= '<p>No boats found.</p>';
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
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 20px;
            font-family: Arial, sans-serif;
        }

        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            width: 100%;
            height: 300px;
        }

        .card-container {
            padding: 16px;
        }

        .card h4 {
            margin: 0;
            font-size: 18px;
        }

        .card p {
            margin: 8px 0;
            color: #555;
        }

        .card .price {
            font-size: 20px;
            color: #b12704;
        }

        .card .capacity {
            font-size: 16px;
            color: #555;
        }
        .icon-size {
            font-size: 1.5rem;
        }
        .btn-light.btn-xl:hover {
            background-color: orange; 
            color: #333; 
            
        }
    </style>
</head>
<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 text-black" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">BALSA</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <div class="ml-auto d-flex align-items-center">
                    <a class="nav-link icon-size navbar-brand" style="margin-left: 900px; margin-right: 25px;" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                        <a class="dropdown-item" href="#">No new notifications</a>
                    </div>
                    <a class="nav-link icon-size dropdown-toggle navbar-brand" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="profile.php">View Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <section class="page-section" style="background-image: linear-gradient(to bottom, rgba(92, 77, 66, 0.8), rgba(92, 77, 66, 0.8)), url('assets/img/fortune.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container px-4 px-lg-5 text-center">
        <div class="mb-4">
                <label for="priceFilter" class="form-label" style="margin-bottom: 10px; margin-right: 50px; color: white;">Price Range:</label>
                <input type="number" class="form-control" placeholder="Price" id="priceValue" oninput="updatePriceFilter(this.value)" style="width: 200px; display: inline-block;" min="0" max="100000" step="100" >
            </div>
            <div class="mb-4">
                <label for="capacityFilter" class="form-label" style="margin-bottom: 10px; margin-right: 75px; color: white;">Capacity:</label>
                <input type="number" class="form-control" placeholder="Guest Number" id="capacityValue" oninput="updateCapacityFilter(this.value)" style="width: 200px; display: inline-block;" min="0" max="30" step="5" >
            </div>
            <div class="mb-4">
                <label for="availabilityRange" class="form-label" style="margin-bottom: 50px; color: white;">Availability Range:</label>
                <input type="date" class="form-control" style="width: 200px; display: inline-block;" id="availabilityRange" onchange="updateAvailabilityValue(this.value)">
            </div>
            <a class="btn btn-light btn-xl" href="#" onclick="displayFilters()">Search</a>
        </div>
    </section>
    
    <section class="results-section" style="background-color: white; height: auto; display: flex; flex-wrap: wrap; justify-content: space-around; padding: 20px;">
        <div id="titleDisplay" class="mb-4" style="width: 100%; text-align: left;">
            <h2>Rent A Boat</h2>
        </div>
        <div id="filtersDisplay" class="mb-4" style="width: 100%; text-align: left;"></div>
            <div class="container" style="background-color: white; height: auto; display: flex; flex-wrap: wrap; justify-content: space-around; padding: 10px;">
                <?php echo $cards; ?>
            </div>
    </section>
    <section class="footer" style="height: 200px; background-color: gray;">
        <p style="text-align: center; color: white; font-size: 50px; padding-top: 50px;">BALSA FOOTER</p>
    </section>

    <script>
        function updatePriceValue(value) {
            document.getElementById('priceValue').innerText = value;
        }

        function updateCapacityValue(value) {
            document.getElementById('capacityValue').innerText = value;
        }

        function updateAvailabilityValue(value) {
            // Handle availability value change
        }

        function displayFilters() {
            const price = document.getElementById('priceValue').value;
            const capacity = document.getElementById('capacityValue').value;
            const availability = document.getElementById('availabilityRange').value;

            const filtersDisplay = document.getElementById('filtersDisplay');
            filtersDisplay.innerHTML = `
            <p>Rent A Boat Filter: Price: $${price}, Capacity: ${capacity} people, Date: ${availability}</p>
            `;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
