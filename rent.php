<?php
include_once('includes/connection.php');
include_once('includes/auth.php');
checkAuthentication();

$firstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Guest';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if (isset($_GET['licenseID'], $_GET['boatName'], $_GET['boatPrice'], $_GET['capacity'])) {
    $licenseID = mysqli_real_escape_string($db, $_GET['licenseID']);
    $boatName = urldecode(mysqli_real_escape_string($db, $_GET['boatName']));
    $boatPrice = mysqli_real_escape_string($db, $_GET['boatPrice']);
    $capacity = is_numeric($_GET['capacity']) ? mysqli_real_escape_string($db, $_GET['capacity']) : 0; // Assuming capacity is numeric
} else {
    echo "<p>Invalid request.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $renterName = mysqli_real_escape_string($db, $firstName); 
    $renterNum = mysqli_real_escape_string($db, $_POST['renterNum']);
    $rentalDate = mysqli_real_escape_string($db, $_POST['rentalDate']);
    $arrivalTime = mysqli_real_escape_string($db, $_POST['arrivalTime']); 
    $numberOfPax = mysqli_real_escape_string($db, $_POST['numberOfPax']);
    $email = mysqli_real_escape_string($db, $email);

    $rentalDuration = 1;
    $totalPrice = $boatPrice * $rentalDuration;

    echo "<p>Query Values:</p>";
        echo "<ul>";
        echo "<li>License ID: $licenseID</li>";
        echo "<li>Boat Name: $boatName</li>";
        echo "<li>Renter Name: $renterName</li>";
        echo "<li>Renter Email: $email</li>";
        echo "<li>Renter Number: $renterNum</li>";
        echo "<li>Rental Date: $rentalDate</li>";
        echo "<li>Arrival Time: $arrivalTime</li>";
        echo "<li>Number of Pax: $numberOfPax</li>";
        echo "<li>Total Price: $totalPrice</li>";
        echo "</ul>";

    // $query = "INSERT INTO rentals (licenseID, boatName, renterName, renterEmail, renterNum, rentalDate, arrivalTime, numberOfPax, totalPrice) 
    //           VALUES ('$licenseID', '$boatName', '$renterName', '$email', '$renterNum', '$rentalDate', '$arrivalTime', '$numberOfPax', '$totalPrice')";

    // if (mysqli_query($db, $query)) {
    //     echo "<p>Rental successful!</p>";
    // } else {
    //     echo "<p>Error: " . mysqli_error($db) . "</p>";
        
    // }
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
        <p>Capacity: <?php echo htmlspecialchars($capacity); ?></p>
        <form method="post">
            <div class="mb-3">
                <label for="renterName" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="renterName" name="renterName" value="<?php echo htmlspecialchars($firstName); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="renterNum" class="form-label">Your Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <select class="custom-select" style="height: 40px; width: 55px; border: 1px solid gray; border-radius: 5px; margin-right: 5px;" id="countryCode" name="countryCode">
                            <option value="+63">+63 Philippines</option>
                        </select>
                    </div>
                    <input type="tel" class="form-control" style="border-radius: 5px;" id="renterNum" name="renterNum" pattern="[0-9]{7,11}" maxlength="11" required>
                    <div class="invalid-feedback">
                        Please enter a valid phone number (7 to 11 digits).
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="rentalDate" class="form-label">Rental Date</label>
                <input type="date" class="form-control" id="rentalDate" name="rentalDate" required>
            </div>
            <div class="mb-3">
                <label for="arrivalTime" class="form-label">Arrival Time</label>
                <input type="time" class="form-control" id="arrivalTime" name="arrivalTime" required>
            </div>
            <div class="mb-3">
                <label for="numberOfPax" class="form-label">Number of Pax</label>
                <input type="number" class="form-control" id="numberOfPax" name="numberOfPax" min="10" max="<?php $capacity ?>" required>
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
