
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapping</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="css/navbar.css" rel="stylesheet">
    <style>
        .bx {
            color: black;
            font-size: 40px;
            margin-right: 50px;
        }
        #map { height: 600px; }
    </style>
</head>
<body>
    <?php include_once('includes\adminNavbar.php'); ?>
    <section class="section" id="home">
        <section class="dashboard section-container">
            <div class="section-header">
                Mapping
                <div class="user">
                    <a href="adminProfile.php">
                        <i class='bx bx-user-circle'></i>
                    </a>
                </div>
            </div>
            <div id="map"></div>
        </section>
    </section>
    
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([14.0667, 120.6333], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Define boat positions (latitude, longitude, boat_name)
            
            var boatPositions = [
                { latitude: 14.1209, longitude: 120.5663, boat_name: 'Boat A' },
                { latitude: 14.0723, longitude: 120.6286, boat_name: 'Boat B' },
                { latitude: 14.0535, longitude: 120.4967, boat_name: 'Boat C' },
                { latitude: 14.0683, longitude: 120.6311, boat_name: 'Boat D' },
                { latitude: 14.0672, longitude: 120.6347, boat_name: 'Boat E' }
            ];

            // Add markers for each boat
            boatPositions.forEach(function(boat) {
                L.marker([boat.latitude, boat.longitude]).addTo(map)
                    .bindPopup(boat.boat_name);
            });
        });
    </script>
</body>
</html>
    
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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

        
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([14.0667, 120.6333], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            
            function fetchBoatPositions() {
                fetch('fetchBoatPositions.php')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(boat => {
                            L.marker([boat.latitude, boat.longitude]).addTo(map)
                                .bindPopup(boat.boat_name);
                        });
                    })
                    .catch(error => console.error('Error fetching boat positions:', error));
            }

        
            fetchBoatPositions();
            setInterval(fetchBoatPositions, 30000);
        });
    </script>
</body>
</html>
