<?php
include_once("includes\connection.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" />
    </head>
    <body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#page-top">BALSA</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#portfolio">Portfolio</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item">
                    <a class="nav-link" style="width: 100px; border: 1px solid black; border-radius: 5px; text-align: center; padding: 0px 0; background-color: #f4623a; color: black;" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-brand {
        padding-bottom: 0;
    }
    .navbar-nav .nav-item {
        margin-right: 20px;
        margin-top: 10px; 
    }
    .nav-link {
        padding: 0.5rem 1rem; 
    }
    .nav-link.btn {
        margin-left: auto; 
    }

    
</style>
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h1 class="text-white font-weight-bold" style="font-size: 200px;">BALSA</h1>
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white-75" style="font-size: 30px;">If Life's A Beach, We're The Best Boat</p>
                        <hr style="height: 5px; background-color: orange; border-radius: 10px; color: white;">
                        <br>
                        <a class="btn btn-primary btn-xl" href="#about">Rent A Boat</a>
                    </div>
                </div>
            </div>
        </header>
        <section class="page-section" style="background-color: #D1BB9E;" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="text-white mt-0">What to know about Nasugbu?</h2>
                        <!-- <hr class="divider divider-light" /> -->
                        <p class="text-white-75 mb-4">Welcome to Nasugbu, Batangas, a picturesque beach destination in the beautiful province of Batangas. With its pristine shores, vibrant marine life, and rich history, Nasugbu is a must-visit tourist spot in the Philippines. Whether you’re seeking a relaxing beach getaway, thrilling diving spots, or enchanting nature attractions, Nasugbu has it all.</p>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe width="640" height="250" border-radius: 10px src="https://www.youtube.com/embed/L7tRq4ng2zc" allowfullscreen style="border-radius: 15px;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="page-section" style="background-color: #EAD8C0;" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">At Your Service</h2>
                <hr style="width: 350px; height: 5px; background-color: orange; margin-left: 350px;"/>
                <div class="row gx-4 gx-lg-5">
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2">Time Consuming</h3>
                            <p class="text-muted mb-0">Experience renting a boat anywhere, anytime!</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-laptop fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2">Fair Transaction</h3>
                            <p class="text-muted mb-0">All dependencies are kept current to keep things fresh.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-globe fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2">Communication</h3>
                            <p class="text-muted mb-0">Direct Communications with our beloved captains</p>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-heart fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2">Made with Love</h3>
                            <p class="text-muted mb-0">Is it really open source if it's not made with love?</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>
        <div id="portfolio">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="assets/img/fishfeeding.jpg" title="Project Name">
                        <img class="pic" style="width: 100%; height: 200px;" src="assets/img/fishfeeding.jpg" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Fish Feeding</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="assets/img/islandhopping.jpg" title="Project Name">
                        <img class="pic" style="width: 100%; height: 200px;" src="assets/img/islandhopping.jpg" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Island Hopping</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="assets/img/fortune.jpg" title="Project Name">
                        <img class="pic" style="width: 100%; height: 200px;" src="assets/img/fortune.jpg" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Fortune Island</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="assets/img/snorkeling.jpg" title="Project Name">
                        <img class="pic" style="width: 100%; height: 200px;" src="assets/img/snorkeling.jpg" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Snorkeling</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="assets/img/staycation.jpg" title="Project Name">
                            <img class="pic" style="width: 100%; height: 200px;" src="assets/img/staycation.jpg" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Staycation</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="assets/img/fishfeeding2.jpg" title="Project Name">
                        <img class="pic" style="width: 100%; height: 200px;" src="assets/img/fishfeeding2.jpg" alt="..." />
                            <div class="portfolio-box-caption p-3">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Fishfeeding</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <section class="page-section" style="background-color: #FFF2E1;">
            <div class="container px-4 px-lg-5 text-center">
                <h2 class="mb-4">Want to Experience this kind of Enjoyment?</h2>
                <a class="btn btn-primary btn-xl" href="login.php">Rent A Boat</a>
            </div>
        </section>
        <section class="page-section" id="contact">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h2 class="mt-0">Let's Get In Touch!</h2>
                        <hr class="divider" />
                        <p class="text-muted mb-5">Ready to start your next project with us? Send us a messages and we will get back to you as soon as possible!</p>
                    </div>
                </div>
                                
            </div>
        </section>
        <footer class="bg-light py-5">
            <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy; 2023 - Company Name</div></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
