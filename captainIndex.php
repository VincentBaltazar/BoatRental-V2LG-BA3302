<?php
include_once('includes/connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateBoat'])) {
    $licenseID = mysqli_real_escape_string($db, $_POST['licenseID']);
    $boatName = mysqli_real_escape_string($db, $_POST['boatName']);
    $boatDescription = mysqli_real_escape_string($db, $_POST['boatDescription']);
    $capacity = mysqli_real_escape_string($db, $_POST['capacity']);

    $updateQuery = "UPDATE captains SET boatName='$boatName', boatDescription='$boatDescription', capacity='$capacity' WHERE licenseID='$licenseID'";
    
    if (mysqli_query($db, $updateQuery)) {
        $_SESSION['updateSuccess'] = "Boat information updated successfully!";
    } else {
        $_SESSION['updateError'] = "Error updating boat information: " . mysqli_error($db);
    }
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
        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 10px;
        }
        .boat-images-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 10px;
            width: 100%;
        }
        .boat-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 4px;
        }
        .form-ratings-container {
            display: flex;
            gap: 20px;
            height: 250px;
            
        }
        .boat-form {
            display: flex;
            flex-direction: column;
            width: 100%;
            padding: 2px;
            gap: 7px;
            max-width: 420px;
            border-radius: 10px;
            
        }

        .boat-form input, .boat-form textarea {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .boat-form button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .message {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .ratings-container {
            flex: 1;
        }
        .ratings-container h2 {
            margin-bottom: 10px;
        }
        .rating-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php include_once('includes/captainNavbar.php'); ?>
    <section class="section" id="home">
        <section class="dashboard section-container">
            <div class="section-header">
                My Boat
                <div class="user">
                    <i class='bx bx-user-circle'></i>
                </div>
            </div>
            <div class="form-container">
                <?php
                if (isset($_SESSION['updateSuccess'])) {
                    echo '<div class="message success">' . $_SESSION['updateSuccess'] . '</div>';
                    unset($_SESSION['updateSuccess']);
                }
                if (isset($_SESSION['updateError'])) {
                    echo '<div class="message error">' . $_SESSION['updateError'] . '</div>';
                    unset($_SESSION['updateError']);
                }

                $query = "SELECT * FROM captains WHERE captainFirstName = '{$_SESSION['firstName']}' AND captainLastName = '{$_SESSION['lastName']}'";
                $result = mysqli_query($db, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $boatImages = json_decode($row['boat'], true); // Decode JSON into an array
                        
                        if (!empty($boatImages)) {
                            echo '<div class="boat-images-container">';
                            foreach ($boatImages as $image) {
                                $imagePath = 'uploads/' . htmlspecialchars($image);
                                echo '<img src="' . $imagePath . '" alt="Boat Image" class="boat-image">';
                            }
                            echo '</div>';
                        } else {
                            echo '<img src="path/to/default_image.jpg" alt="Default Boat Image" class="boat-image">';
                        }
                ?>
                <div class="form-ratings-container">
                    <form class="boat-form" method="post" action="">
                        <h2>My Boat Ratings</h2>
                        <input type="hidden" name="licenseID" value="<?php echo htmlspecialchars($row['licenseID']); ?>">
                        <input type="text" name="boatName" value="<?php echo htmlspecialchars($row['boatName']); ?>" required>
                        <textarea name="boatDescription" rows="3" required><?php echo htmlspecialchars($row['boatDescription']); ?></textarea>
                        <input type="number" name="capacity" value="<?php echo htmlspecialchars($row['capacity']); ?>" min="1" required>
                        <button type="submit" name="updateBoat" class="btn btn-primary">Update</button>
                    </form>
                    <div class="ratings-container">
                        <h2>My Boat Ratings</h2>
                        <?php

                        $ratings = [
                            ['rating' => 4.5, 'review' => 'Great boat!'],
                            ['rating' => 5, 'review' => 'Excellent experience.'],
                            ['rating' => 3.5, 'review' => 'Good, but could be improved.']
                        ];

                        function displayStars($rating) {
                            $fullStars = floor($rating);
                            $halfStar = ($rating - $fullStars) >= 0.5 ? true : false;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            
                            $stars = str_repeat('<i class="fas fa-star" style="color: #ffdd3c"></i>', $fullStars);
                            if ($halfStar) {
                                $stars .= '<i class="fas fa-star-half-alt" style="color: #ffdd3c"></i>';
                            }
                            $stars .= str_repeat('<i class="far fa-star" style="color: #ffdd3c"></i>', $emptyStars);
                            
                            return $stars;
                        }

                        if (!empty($ratings)) {
                            foreach ($ratings as $rating) {
                                echo '<div class="rating-item">';
                                echo '<strong>Rating:</strong> ' . displayStars($rating['rating']) . ' ' . htmlspecialchars($rating['rating']) . '<br>' ;
                                echo '<strong>Review:</strong> ' .  htmlspecialchars($rating['review']);
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No ratings available.</p>';
                        }
                        ?>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p>No boats found.</p>";
                }
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
