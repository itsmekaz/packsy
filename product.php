<?php 
    require_once "koneksi.php";

    // pagination
    $jumlahDataPerhalaman = 8;
    $totalData = count(show("SELECT * FROM products"));
    $jumlahHalaman = ceil($totalData / $jumlahDataPerhalaman);
    $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
    $awalData = ($halamanAktif * $jumlahDataPerhalaman) - $jumlahDataPerhalaman;
    
    $products = show("SELECT * FROM products LIMIT $awalData, $jumlahDataPerhalaman");

    if (isset($_POST["btn-search"])) { 
        $products = cari($_POST["search"]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACKSY Product</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/styles/basic.css">
    <link rel="stylesheet" href="assets/styles/product.css">
</head>
<body>
    <?php include "layout/header.html"?>

    <main class="container-fluid p-0 mt-0">
        <section class="promo container d-flex justify-content-end align-items-center pe-3 mb-5">
            <div class="text-start">
                <p class="mb-0 ps-2">Limited time only</p>
                <h1 class="mt-0 mb-3 p-0">Get 30% off</h1>
                <p class="ps-2">Bags designed with style and practicality in mind, <br> ensuring you stay organized and on-the-go with ease.</p>
            </div>
        </section>

        <section class="bags container d-flex flex-column justify-content-start align-items-center gap-5 mt-5">
                <form action="" method="post" class="input-group w-50">
                    <input type="search" class="form-control" placeholder="What are you looking for?" aria-describedby="search" name="search">
                    <button class="btn btn-prim" type="submit" id="search" name="btn-search">
                        Search <i class="bi bi-search"></i>
                    </button>
                </form>

                <section id="" class="cards mt-4 d-flex justify-content-start gap-3 flex-wrap row-gap-4"> 
                    <?php foreach ($products as $product) : ?>
                        <div class="card text-center rounded-5">
                            <div class="card-img-top rounded-5 overflow-hidden d-flex justify-content-center align-items-center">
                                <img class="card-img-top rounded-5" src="upload/<?= $product['gambar']?>" alt="<?= $product['gambar']?>"  />
                            </div>
                            <div class="card-body text-uppercase p-4 d-flex flex-column justify-content-between align-items-center">
                                <h5 class="card-title mb-3"><?= $product['nama_produk']?></h5>
                                <h5 class="card-text">Rp <?= number_format($product['harga'], 2, ',', '.') ?></h5>
                            </div>
                        </div>
                    <?php endforeach ?>
                </section>

                <!-- Pagination -->
                <nav class="mt-3 mb-3">
                    <ul class="pagination justify-content-center">
                        <?php if($halamanAktif > 1) :?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $halamanAktif - 1 ?>"><i class="bi bi-chevron-left"></i>Previous</a></li>
                        <?php else :?>
                            <li class="page-item disabled"><a class="page-link" href=""><i class="bi bi-chevron-left"></i>Previous</a></li>
                        <?php endif ?>
                        
                        <?php for($i = 1; $i <= $jumlahHalaman; $i++) :?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                        <?php endfor ?>

                        <?php if($halamanAktif < $jumlahHalaman) :?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $halamanAktif + 1 ?>">Next <i class="bi bi-chevron-right"></i></a></li>
                        <?php else :?>
                            <li class="page-item disabled"><a class="page-link" href="">Next <i class="bi bi-chevron-right"></i></a></li>
                        <?php endif ?>
                    </ul>
                </nav>
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
    </script>
</body>
</html>