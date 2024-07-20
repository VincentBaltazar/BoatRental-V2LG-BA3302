<?php
include_once('includes/connection.php');

if (isset($_GET['licenseID']) && isset($_GET['boatName']) && isset($_GET['boatPrice'])) {
    $licenseID = mysqli_real_escape_string($db, $_GET['licenseID']);
    $boatName = urldecode(mysqli_real_escape_string($db, $_GET['boatName']));
    $boatPrice = mysqli_real_escape_string($db, $_GET['boatPrice']);
} else {
    echo "<p>Invalid request.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $renterName = mysqli_real_escape_string($db, $_POST['renterName']);
    $renterEmail = mysqli_real_escape_string($db, $_POST['renterEmail']);
    $rentalDate = mysqli_real_escape_string($db, $_POST['rentalDate']);
    $rentalDuration = mysqli_real_escape_string($db, $_POST['rentalDuration']);

    $query = "INSERT INTO rentals (licenseID, boatName, renterName, renterEmail, rentalDate, rentalDuration, totalPrice) VALUES ('$licenseID', '$boatName', '$renterName', '$renterEmail', '$rentalDate', '$rentalDuration', '$boatPrice' * '$rentalDuration')";
    if (mysqli_query($db, $query)) {
        echo "<p>Rental successful!</p>";
    } else {
        echo "<p>Error: " . mysqli_error($db) . "</p>";
    }
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

</head>
<body id="page-top">
    <?php include_once("includes/navbar.php") ?>
    <div class="container mt-5">
        <h2 style="padding-top: 60px;">Rent Boat: <?php echo htmlspecialchars($boatName); ?></h2>
        <p>Price per hour: $<?php echo htmlspecialchars($boatPrice); ?></p>
        <form method="post">
            <div class="mb-3">
                <label for="renterName" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="renterName" name="renterName" required>
            </div>
            <div class="mb-3">
                <label for="renterEmail" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="renterEmail" name="renterEmail" required>
            </div>
            <div class="mb-3">
                <label for="rentalDate" class="form-label">Rental Date</label>
                <input type="date" class="form-control" id="rentalDate" name="rentalDate" required>
            </div>
            <div class="mb-3">
                <label for="rentalDuration" class="form-label">Rental Duration (hours)</label>
                <input type="number" class="form-control" id="rentalDuration" name="rentalDuration" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("rentalDate").setAttribute("min", today);
        });
    </script>
</body>
</html>
