<?php
session_start();
include_once('includes/connection.php');


$firstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Guest';
$lastName = isset($_SESSION['lastName']) ? $_SESSION['lastName'] : '';

$cards_per_page = 6;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $cards_per_page;

$query = "SELECT * FROM captains WHERE 1";
if (isset($_GET['capacity']) && $_GET['capacity'] != '') {
    $capacity = (int)$_GET['capacity'];
    $query .= " AND capacity >= $capacity";
}
if (isset($_GET['price']) && $_GET['price'] != '') {
    $price = (int)$_GET['price'];
    $query .= " AND boatPrice <= $price";
}
// Add availability filter if needed, modify as per your availability logic
// if (isset($_GET['availability']) && $_GET['availability'] != '') {
//     $availability = $_GET['availability'];
//     $query .= " AND availability_condition_here";
// }

$query .= " LIMIT $cards_per_page OFFSET $offset";

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

$total_query = "SELECT COUNT(*) AS total FROM captains WHERE 1";

if (isset($_GET['capacity']) && $_GET['capacity'] != '') {
    $capacity = (int)$_GET['capacity'];
    $total_query .= " AND capacity >= $capacity";
}
if (isset($_GET['price']) && $_GET['price'] != '') {
    $price = (int)$_GET['price'];
    $total_query .= " AND boatPrice <= $price";
}
// Add availability filter if needed
// if (isset($_GET['availability']) && $_GET['availability'] != '') {
//     $availability = $_GET['availability'];
//     $total_query .= " AND availability_condition_here";
// }

$total_result = mysqli_query($db, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_cards = $total_row['total'];
$total_pages = ceil($total_cards / $cards_per_page);
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
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #555;
        }
        .pagination a:hover {
            background-color: #f0f0f0;
        }
        .pagination .active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
    </style>
</head>
<body id="page-top">
    <?php include_once("includes/navbar.php") ?>
    <section class="page-section" style="background-image: linear-gradient(to bottom, rgba(92, 77, 66, 0.8), rgba(92, 77, 66, 0.8)), url('assets/img/fortune.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container px-4 px-lg-5 text-center">
        <h2>Welcome, <?php echo $firstName . ' ' . $lastName; ?>!</h2>
            <!-- Filter inputs -->
            <form id="filterForm" method="GET">
                <div class="mb-4">
                    <label for="priceFilter" class="form-label" style="margin-bottom: 10px; margin-right: 50px; color: white;">Price Range:</label>
                    <input type="number" class="form-control" name="price" placeholder="Price" id="priceValue" value="<?php echo isset($_GET['price']) ? $_GET['price'] : ''; ?>" style="width: 200px; display: inline-block;" min="0" max="100000" step="100">
                </div>
                <div class="mb-4">
                    <label for="capacityFilter" class="form-label" style="margin-bottom: 10px; margin-right: 75px; color: white;">Capacity:</label>
                    <input type="number" class="form-control" name="capacity" placeholder="Guest Number" id="capacityValue" value="<?php echo isset($_GET['capacity']) ? $_GET['capacity'] : ''; ?>" style="width: 200px; display: inline-block;" min="0" max="30" step="5">
                </div>
                <!-- Add more filters as needed -->
                <div class="mb-4">
                    <label for="availabilityRange" class="form-label" style="margin-bottom: 50px; color: white;">Availability Range:</label>
                    <input type="date" class="form-control" name="availability" style="width: 200px; display: inline-block;" id="availabilityRange" value="<?php echo isset($_GET['availability']) ? $_GET['availability'] : ''; ?>">
                </div>
                <button type="submit" class="btn btn-light btn-xl">Search</button>
            </form>
        </div>
    </section>
    
    <section class="results-section" style="background-color: white; height: auto; display: flex; flex-wrap: wrap; justify-content: space-around; padding: 20px;">
        <div id="titleDisplay" class="mb-4" style="width: 100%; text-align: left;">
            <h2>Rent A Boat</h2>
        </div>
        <div id="filtersDisplay" class="mb-4" style="width: 100%; text-align: left;"></div>
        <div class="container" style="background-color: white; height: auto; display: flex; flex-wrap: wrap; justify-content: space-around; padding: 10px;">
            <?php echo $cards; ?>


            <!-- <?php echo "SQL Query: " . $query . "<br>"; ?> -->
        </div>
    </section>

    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a href="?page=<?php echo $current_page - 1; ?>&<?php echo http_build_query($_GET); ?>">&laquo; Previous</a>
        <?php endif; ?>
        
        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <a href="?page=<?php echo $page; ?>&<?php echo http_build_query($_GET); ?>" class="<?php if ($page == $current_page) echo 'active'; ?>"><?php echo $page; ?></a>
        <?php endfor; ?>
        
        <?php if ($current_page < $total_pages): ?>
            <a href="?page=<?php echo $current_page + 1; ?>&<?php echo http_build_query($_GET); ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
    <section class="footer" style="height: 200px; background-color: gray;">
        <p style="text-align: center; color: white; font-size: 50px; padding-top: 50px;">BALSA FOOTER</p>
    </section>

    <script>
        // function updatePriceValue(value) {
        //     document.getElementById('priceValue').innerText = value;
        // }

        // function updateCapacityValue(value) {
        //     document.getElementById('capacityValue').innerText = value;
        // }

        // function updateAvailabilityValue(value) {
        //     // Handle availability value change
        // }

        function displayFilters() {
            const price = document.getElementById('priceValue').value;
            const capacity = document.getElementById('capacityValue').value;
            const availability = document.getElementById('availabilityRange').value; // Uncomment if using availability filter

            const filtersDisplay = document.getElementById('filtersDisplay');
            filtersDisplay.innerHTML = `
            <p>Rent A Boat Filter: Price: $${price}, Capacity: ${capacity} people</p>
            `;
        }
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("availabilityRange").setAttribute("min", today);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
