<?php
$db_host = 'localhost:3307';
$db_user = 'root';
$db_password = '';
$db_name = 'boatrental';

$db = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// <div class="card">
//             <img src="img\boat\boat1.jpg" alt="Boat Image">
//             <div class="card-container">
//                 <h4>Luxury Yacht</h4>
//                 <p>Enjoy a luxurious experience on the water with our top-of-the-line yacht.</p>
//                 <p class="price">$500 per hour</p>
//                 <p class="capacity">Capacity: 10 people</p>
//             </div>
//         </div>
//         <div class="card">
//             <img src="img\boat\boat1.jpg" alt="Boat Image">
//             <div class="card-container">
//                 <h4>Luxury Yacht</h4>
//                 <p>Enjoy a luxurious experience on the water with our top-of-the-line yacht.</p>
//                 <p class="price">$500 per hour</p>
//                 <p class="capacity">Capacity: 10 people</p>
//             </div>
//         </div>
//         <div class="card">
//             <img src="img\boat\boat1.jpg" alt="Boat Image">
//             <div class="card-container">
//                 <h4>Luxury Yacht</h4>
//                 <p>Enjoy a luxurious experience on the water with our top-of-the-line yacht.</p>
//                 <p class="price">$500 per hour</p>
//                 <p class="capacity">Capacity: 10 people</p>
//             </div>
//         </div>
//         <div class="card">
//             <img src="img\boat\boat1.jpg" alt="Boat Image">
//             <div class="card-container">
//                 <h4>Luxury Yacht</h4>
//                 <p>Enjoy a luxurious experience on the water with our top-of-the-line yacht.</p>
//                 <p class="price">$500 per hour</p>
//                 <p class="capacity">Capacity: 10 people</p>
//             </div>
//         </div>
//         <div class="card">
//             <img src="img\boat\boat1.jpg" alt="Boat Image">
//             <div class="card-container">
//                 <h4>Luxury Yacht</h4>
//                 <p>Enjoy a luxurious experience on the water with our top-of-the-line yacht.</p>
//                 <p class="price">$500 per hour</p>
//                 <p class="capacity">Capacity: 10 people</p>
//             </div>
//         </div>