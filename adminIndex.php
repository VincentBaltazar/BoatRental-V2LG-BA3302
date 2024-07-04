<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="css/navbar.css" rel="stylesheet">
</head>
<body>
    <?php include_once('includes/adminNavbar.php'); ?>
    <section class="section" id="home" style="background-color: #F7F9F2; height: 690px;">
        <section class="dashboard section-container">
            <div class="section-header">
                DASHBOARD
                <div class="user">
                    <i class='bx bx-user-circle'></i>
                </div>
            </div>
            <div class="grid-container">
                <div class="grid-items">1</div>
                <div class="grid-items">2</div>
                <div class="grid-items">3</div>
                
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
