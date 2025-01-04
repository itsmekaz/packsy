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

    // Menambahkan item ke cart
    if (isset($_POST['addCart'])) {
        $productId = $_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        
        // Cek stok produk
        $productQuery = "SELECT stok FROM products WHERE id = $productId";
        $productResult = mysqli_query($conn, $productQuery);
        $product = mysqli_fetch_assoc($productResult);
    
        if ($product['stok'] >= $quantity) {
            // Periksa apakah produk sudah ada di keranjang
            $cartQuery = "SELECT * FROM cart WHERE produk_id = $productId";
            $cartResult = mysqli_query($conn, $cartQuery);
            if (mysqli_num_rows($cartResult) > 0) {
                // Update quantity
                $updateCartQuery = "UPDATE cart SET quantity = quantity + $quantity WHERE produk_id = $productId";
                mysqli_query($conn, $updateCartQuery);
            } else {
                // Tambahkan produk baru
                $addCartQuery = "INSERT INTO cart (produk_id, quantity) VALUES ($productId, $quantity)";
                mysqli_query($conn, $addCartQuery);
            }
    
            // Kurangi stok
            $updateStockQuery = "UPDATE products SET stok = stok - $quantity WHERE id = $productId";
            mysqli_query($conn, $updateStockQuery);
    
            header('Location: product.php'); // Redirect kembali ke halaman produk
        } else {
            echo "<script>alert('Stok tidak mencukupi!'); window.history.back();</script>";
        }
    }

    // Menghapus item ke cart
    if (isset($_POST['removeItem'])) {
        $cartId = $_POST['cart_id'];
    
        // Ambil detail produk di keranjang
        $cartQuery = "SELECT produk_id, quantity FROM cart WHERE id = $cartId";
        $cartResult = mysqli_query($conn, $cartQuery);
        $cartItem = mysqli_fetch_assoc($cartResult);
    
        if ($cartItem) {
            $productId = $cartItem['produk_id'];
            $currentQuantity = $cartItem['quantity'];
    
            if ($currentQuantity > 1) {
                // Kurangi quantity
                $updateCartQuery = "UPDATE cart SET quantity = quantity - 1  WHERE id = $cartId";
                mysqli_query($conn, $updateCartQuery);
            } else {
                // Hapus entri jika quantity mencapai 0
                $deleteCartQuery = "DELETE FROM cart WHERE id = $cartId";
                mysqli_query($conn, $deleteCartQuery);
            }
    
            // Kembalikan stok produk
            $updateStockQuery = "UPDATE products SET stok = stok + 1 WHERE id = $productId";
            mysqli_query($conn, $updateStockQuery);
    
            header('Location: product.php'); // Redirect kembali ke halaman produk
        } else {
            echo "<script>alert('Item tidak ditemukan!'); window.history.back();</script>";
        }
    }

    $cartItems = show("SELECT c.id, p.nama_produk, p.harga, p.gambar, c.quantity 
                FROM cart c 
                JOIN products p ON c.produk_id = p.id");
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
                <p class="mb-0 ps-2">Limited time only!</p>
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
                        <div class="card text-center rounded-5" data-bs-toggle="modal" data-bs-target="#modal<?= $product['id'] ?>">
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

    <!-- Modal Detail Produk -->
    <?php foreach ($products as $product) : ?>
        <div class="modal fade" id="modal<?= $product['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $product['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel<?= $product['id'] ?>"><?= $product['nama_produk'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img class="card-img-top rounded-5" style="width: 75%;" src="upload/<?= $product['gambar']?>" alt="<?= $product['gambar']?>"  />
                        <div class="d-flex justify-content-between align-items-center mx-auto">
                            <h5 class="card-text mt-3">Harga: Rp <?= number_format($product['harga'], 2, ',', '.') ?></h5>
                            <h5 class="card-text mt-3">Stok tersedia: <?= $product['stok'] ?></h5>
                        </div>
                    </div>
                    <form action="" method="post" class="modal-footer d-flex justify-content-between align-items-center">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="number" name="quantity" min="1" value="1" class="form-control text-center" style="width: 25%">
                        <button type="submit" name="addCart" class="btn btn-sec" style="width: 70%">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <!-- Modal Cart -->
    <div class="modal fade modal-xl" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-titl fs-4" id="cartModalLabel">My Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">               
                        <?php foreach ($cartItems as $item) : ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center gap-4">
                                <div class="title d-flex justify-content-start align-items-center gap-3 w-75">
                                    <input type="checkbox">
                                    <img class="card-img-top rounded-2" style="width: 10%;" src="upload/<?= $item['gambar'] ?>"/>
                                    <h5 class="text-start"><?= $item['nama_produk'] ?></h5>
                                </div>
                                <div class="desc d-flex justify-content-around align-items-center w-75">
                                    <p class="d-flex flex-column align-items-center">Harga Satuan: <span>Rp <?= number_format($item['harga'], 2, ',', '.') ?></span></p>
                                    <p class="d-flex flex-column align-items-center">Quantity: <span><?= $item['quantity'] ?></span></p>
                                    <p class="d-flex flex-column align-items-center">Total: <span>Rp <?= number_format($item['harga'] * $item['quantity'], 2, ',', '.') ?></span></p>
                                </div>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                    <button type="submit" name="removeItem" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sec mx-auto" style="width: 60%">Checkout</button>
                </div>
            </div>
        </div>
    </div>




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