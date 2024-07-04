<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captain List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="css/navbar.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .section {
            padding: 20px;
        }
        .dashboard .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .dashboard .section-header .user {
            display: flex;
            align-items: center;
        }
        table {
            width: 100%;
            margin: 30px 0;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-warning {
            font-size: 20px;
            background-color: #ffc107;
            color: white;
            border: none;
        }
        .options {
            text-align: center;
        }
        .options a {
            margin: 0 5px;
        }
        .controls {
            margin-bottom: 20px;
        }
        .controls label {
            margin-right: 10px;
        }
        .controls input,
        .controls select {
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .pagination {
            display: flex;
            justify-content: flex-end;
            list-style-type: none;
            padding: 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination li a {
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #007bff;
        }
        .pagination li a.active {
            background-color: #007bff;
            color: white;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .dataTables_wrapper .dataTables_filter {
            text-align: right;
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            width: 250px;
            max-width: 100%;
            box-sizing: border-box;
            font-size: 14px;
        }

        .dataTables_wrapper .dataTables_filter label {
            font-weight: normal;
            margin-right: 10px;
        }
        .dataTables_wrapper .dataTables_length {
            padding-top: 10px;
            float: left;
            color: green;
        }

        .modal {
            display: none;
            position: absolute;
            margin-left: 350px;
            z-index: 1;
            left: 0;
            top: 0;
            width: 700px;
            height: 700px;
            overflow: auto;
            border-radius: 10px;
            padding-top: 60px;
            
            
        }
        .modal-content {
            font-size: 24px;
            background-color: #fefefe;
            border-radius: 10px;
            margin: 5% auto;
            margin-left: 5%;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .inputTypes{
            border-radius: 5px;
            font-size: 15px;
            height: 30px;
            width: 300px;
        }
        .overlay {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        @media (max-width: 800px) {
            .dashboard .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }
            .section-header {
                padding-bottom: 30px;
                margin-left: 20px;
                font-weight: 900;
                font-size: 30px;
                letter-spacing: -1px;
            }
            .section {
                padding: 100px;
                margin-left: 60px;
                transition: margin-left .3s ease;
            }
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }
        @media (max-width: 650px) {
            .dashboard .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }
            .section-header {
                padding-bottom: 30px;
                margin-left: 20px;
                font-weight: 900;
                font-size: 30px;
                letter-spacing: -1px;
            }
            .section {
                padding: 100px;
                margin-left: 60px;
                transition: margin-left .3s ease;
            }
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }
        @media (max-width: 480px) {
            .dashboard .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }
            .section-header {
                padding-bottom: 30px;
                margin-left: 20px;
                font-weight: 900;
                font-size: 30px;
                letter-spacing: -1px;
            }
            .section {
                padding: 100px;
                margin-left: 60px;
                transition: margin-left .3s ease;
            }
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <?php include_once('includes/adminNavbar.php'); ?>
    <section class="section" id="captains">
        <section class="dashboard section-container">
            <div class="section-header">
                CAPTAINS
                <div class="user">
                    <i class='bx bx-user-circle'></i>
                </div>
            </div>
            <button class="btn btn-warning" id="addButton" style="float: right; margin-right: 10px; margin-bottom: 10px; width: 250px;">Add</button>

            <table id="captainTable" class="display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Boat</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Captain John</td>
                        <td>Sea Explorer</td>
                        <td class="options">
                            <a href="#" class="btn btn-warning">Edit</a>
                            <a href="#" class="btn btn-warning" style="background-color: red;">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Captain Smith</td>
                        <td>Ocean Voyager</td>
                        <td class="options">
                            <a href="#" class="btn btn-warning">Edit</a>
                            <a href="#" class="btn btn-warning" style="background-color: red;">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </section>

    <!-- Adding Modal -->
    <div id="overlay" class="overlay"></div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 style="padding-bottom: 20px;">Add Captain</h2>
            <form id="addCaptainForm">
                <div>
                    <label for="captainName">Captain Name:</label>
                    <input type="text" id="captainName" class="inputTypes" name="captainName" required>
                </div>
                <div>
                    <label for="crewMembers">Crew Members:</label>
                    <div id="crewMembers">
                        <input type="text" name="crew[]" placeholder="Crew Member Name" required>
                    </div>
                    <button type="button" id="addCrewMember">Add Crew Member</button>
                </div>
                <div>
                    <label for="requirements">Upload Requirements:</label>
                    <input type="file" id="requirements" name="requirements[]" multiple required>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#captainTable').DataTable();

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

            let modal = document.getElementById("myModal");
            let btnModal = document.getElementById("addButton");
            let span = document.getElementsByClassName("close")[0];
            let overlay = document.getElementById("overlay");

            btnModal.onclick = function() {
                modal.style.display = "block";
                overlay.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
                overlay.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == overlay) {
                    modal.style.display = "none";
                    overlay.style.display = "none";
                }
            }

            document.getElementById("addCrewMember").addEventListener("click", function() {
                var crewMembersDiv = document.getElementById("crewMembers");
                var input = document.createElement("input");
                input.type = "text";
                input.name = "crew[]";
                input.placeholder = "Crew Member Name";
                input.required = true;
                crewMembersDiv.appendChild(input);
            });

            document.getElementById("addCaptainForm").addEventListener("submit", function(event) {
                event.preventDefault();

                alert("Form submitted!");
                modal.style.display = "none";
            });
        });
    </script>
</body>
</html>
