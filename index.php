<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACKSY</title>
    
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/styles/basic.css">
    <link rel="stylesheet" href="assets/styles/homepage.css">
</head>
<body>
    <?php include "layout/header.html"?>

    <main class="container-fluid p-0">
        <section class="container hero d-flex justify-content-between align-items-center rounded-5 mt-4">
            <div class="left w-50">
                <div class="position-relative mb-5">
                    <h1 class="fw-bold position-relative z-3">LET'S <br> EXPLORE <br> UNIQUE <br> BAGS.</h1>
                    <img src="assets/images/hero/rectangle.svg" alt="" class="position-absolute z-2 img-fluid">
                </div>
                <p class="fw-normal mb-4">Live for the Bag that Completes Your Look!</p>
                <a href="product.php" class="btn btn-prim">Shop Now</a>
            </div>
            <div class="right w-50 position-relative">
                <img src="assets/images/hero/small-vector.svg" alt="" class="position-absolute">
                <img src="assets/images/hero/hero-img.png" alt="" class="position-relative">
                <img src="assets/images/hero/big-vector.svg" alt="" class="position-absolute">
            </div>
        </section>

        <section class="container brands mt-5 overflow-hidden position-relative">
            <div class="brands-scroll rounded-5 m-auto d-flex">
                <?php
                // array berisi nama file gambar
                $images = [
                    "exsport.svg",
                    "eiger.svg",
                    "samsonite.svg",
                    "herschel.svg",
                    "elizabeth.svg",
                    "nike.svg"
                ]
                ?>
                <!-- Loop untuk menampilkan gambar -->
                <?php for ($i = 0; $i <= 3; $i++) :?>
                    <?php foreach ($images as $image) : ?>
                        <img src="assets/images/brands/<?= $image?>" alt="Brand <?= pathinfo($image, PATHINFO_FILENAME) ?>">
                    <?php endforeach?>
                <?php endfor?>
            </div>
        </section>


        <section class="new mt-5 py-3">
            <div class="container d-flex flex-column">
                <div class="title d-flex justify-content-between align-items-end mb-4">
                    <h2 class="w-50">Don't miss out new arrivals</h2>
                    <a href="product.php" class="btn btn-sec text-uppercase">Explore More</a>
                </div>
                <div class="cards mt-4 d-flex justify-content-between">
                    <div class="card-new text-center rounded-5">
                        <div class="card-img-top rounded-5 overflow-hidden d-flex justify-content-center align-items-center">
                            <img class="card-img-top rounded-5" src="assets/images/new/bag-1.png" alt="Elizabeth" />
                        </div>
                        <div class="card-body text-uppercase p-4">
                            <h5 class="card-title mb-3">Genuine Leather Backpack 0720-0420</h5>
                            <h5 class="card-text">Rp 890.000,00</h5>
                        </div>
                    </div>
                    <div class="card-new text-center rounded-5">
                        <div class="card-img-top rounded-5 overflow-hidden d-flex justify-content-center align-items-center">
                            <img class="card-img-top rounded-5" src="assets/images/new/bag-2.jpg" alt="Eiger" />
                        </div>
                        <div class="card-body text-uppercase p-4">
                            <h5 class="card-title mb-3">EIGER VANDA 10L POTRAIT WS</h5>
                            <h5 class="card-text">Rp 249.000,00</h5>
                        </div>
                    </div>
                    <div class="card-new text-center rounded-5">
                        <div class="card-img-top rounded-5 overflow-hidden d-flex justify-content-center align-items-center">
                            <img class="card-img-top rounded-5" src="assets/images/new/bag-3.jpg" alt="Eiger" />
                        </div>
                        <div class="card-body text-uppercase p-4">
                            <h5 class="card-title mb-3">WANDERHAUL DUFFELPACK 40L</h5>
                            <h5 class="card-text">Rp 609.000,00</h5>
                        </div>
                    </div>
                    <div class="card-new text-center rounded-5">
                        <div class="card-img-top rounded-5 overflow-hidden d-flex justify-content-center align-items-center">
                            <img class="card-img-top rounded-5" src="assets/images/new/bag-4.png" alt="NIKE" />
                        </div>
                        <div class="card-body text-uppercase p-4">
                            <h5 class="card-title mb-3">NIKE PREMIUM BACKPACK 21L</h5>
                            <h5 class="card-text">Rp 559.000,00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="categories mt-5 container rounded-5">
            <h2 class="text-center pb-3">CATEGORIES</h2>
            <div class="d-flex gap-3 flex-wrap justify-content-center align-items-center mt-4">
                <div class="card one p-0 rounded-5 overflow-hidden">
                    <img src="assets/images/categories/backpack.png" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h3 class="card-title">Backpack</h3>
                    </div>
                </div>  
                <div class="card two p-0 rounded-5 overflow-hidden">
                    <img src="assets/images/categories/handbag.jpg" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h3 class="card-title">Handbag</h3>
                    </div>
                </div>
                <div class="card two p-0 rounded-5 overflow-hidden">
                    <img src="assets/images/categories/duffel.png" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h3 class="card-title">Duffel</h3>
                    </div>
                </div>
                <div class="card one p-0 rounded-5 overflow-hidden">
                    <img src="assets/images/categories/slingbag.png" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h3 class="card-title">Sling Bag</h3>
                    </div>
                </div>
                <div class="card one p-0 rounded-5 overflow-hidden">
                    <img src="assets/images/categories/clutch.png" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h3 class="card-title">Clutch</h3>
                    </div>
                </div>
                <div class="card two p-0 rounded-5 overflow-hidden">
                    <img src="assets/images/categories/totebag.png" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h3 class="card-title">Tote Bag</h3>
                    </div>
                </div>
                
            </div>
        </section>

        <section class="review mt-5">
            <h2 class="w-60 text-center mb-5">OUR HAPPY CUSTOMERS</h2>
            <div class="card-wrapper overflow-hidden position-relative">
                <div class="cards d-flex gap-3 m-auto">
                    <div class="rounded-4 p-4 size-card">
                        <div class="star d-flex justify-content-start align-items-center gap-1 mb-3">
                            <?php for($i = 0; $i < 5; $i++) :?>
                                <img src="assets/images/review/star.svg" alt="">
                            <?php endfor?>
                        </div>
                        <div class="card-title d-flex justify-content-start align-items-start gap-1 mb-0">
                            <h4>Caitlyn K.</h4>
                            <img src="assets/images/review/verified.svg" alt="">
                        </div>
                        <p class="card-text">The backpack is stylish and durable! It fits all my essentials perfectly and is super lightweight—ideal for daily use.</p>
                    </div>
                    <div class="rounded-4 p-4 size-card">
                        <div class="star d-flex justify-content-start align-items-center gap-1 mb-3">
                            <?php for($i = 0; $i < 5; $i++) :?>
                                <img src="assets/images/review/star.svg" alt="">
                            <?php endfor?>
                        </div>
                        <div class="card-title d-flex justify-content-start align-items-start gap-1 mb-0">
                            <h4>Loren William</h4>
                            <img src="assets/images/review/verified.svg" alt="">
                        </div>
                        <p class="card-text">This duffel bag is amazing! Spacious, stylish, and perfect for both gym and weekend trips.</p>
                    </div>
                    <div class="rounded-4 p-4 size-card">
                        <div class="star d-flex justify-content-start align-items-center gap-1 mb-3">
                            <?php for($i = 0; $i < 5; $i++) :?>
                                <img src="assets/images/review/star.svg" alt="">
                            <?php endfor?>
                        </div>
                        <div class="card-title d-flex justify-content-start align-items-start gap-1 mb-0">
                            <h4>Joanne Alexandra</h4>
                            <img src="assets/images/review/verified.svg" alt="">
                        </div>
                        <p class="card-text">Great quality sling bag with a sleek design. Comfortable to wear and super functional!</p>
                    </div>
                </div>
            </div>
        </section>        
    </main>
    
    <?php include "layout/footer.html"?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const navbar = document.querySelector("header.navbar");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 50) { // Jika scroll lebih dari 50px
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });

        let cards = document.querySelectorAll(".card-new");
        cards.forEach(card => {
            card.addEventListener('click', function() {
                window.location.href = "product.php";
            });
        });
    </script>
</body>
</html>