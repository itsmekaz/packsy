<?php 
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: ../login.php");
        exit;
    } 
    $admin_name = $_SESSION["admin_name"];

    require_once "../koneksi.php";
    
    // pagination
    $jumlahDataPerhalaman = 6;
    $totalData = count(show("SELECT * FROM products"));
    $jumlahHalaman = ceil($totalData / $jumlahDataPerhalaman);
    $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
    $awalData = ($halamanAktif * $jumlahDataPerhalaman) - $jumlahDataPerhalaman;
    
    $products = show("SELECT * FROM products LIMIT $awalData, $jumlahDataPerhalaman");

    // cek apakah tombol add sudah ditekan
    if (isset($_POST["add"])) {
        if (insert($_POST) > 0) {
            $addsuccess = true;
        }
        
    }

    if (isset($_POST["edit"])) {
        if (update($_POST) > 0) { 
            $editsuccess = true;
        }
    }
    

    if (isset($_POST["delete"])) {
        if (hapus($_POST) > 0) { 
            $editsuccess = true;
        }
    }
    
    if (isset($_POST["btn-search"])) { 
        $products = cari($_POST["search"]);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACKSY | DASHBOARD</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/styles/basic.css">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
</head>
<body>
    <main class="d-flex">
        <?php include "../layout/sidebar.php"?>

        <!-- Content -->
        <section class="content p-4 container-fluid">
            <h1 class="mt-2">Hello, <?= $admin_name ?>!👋🏻</h1>

            <div class="title">
                <h2 class="mb-4">ALL PRODUCT</h2>
                <div class="d-flex  justify-content-between align-items-start">
                    <form action="" method="post" class="input-group mb-3 w-50">
                        <input type="search" class="form-control" placeholder="What are you looking for?" aria-describedby="search" name="search">
                        <button class="btn btn-prim" type="submit" id="search" name="btn-search">
                            Search <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <button type="button" class="btn btn-sec" data-bs-toggle="modal" data-bs-target="#add"><i class="bi bi-plus-circle fw-bold"></i> &nbsp;ADD NEW PRODUCT</button>
                </div>
            </div>

            <!-- Modal tambah data -->
            <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Form Section -->
                        <form id="" action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="productName" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" id="productName" placeholder="Enter product name" name="nama_produk" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="brand" class="form-label">Brand</label>
                                            <input type="text" class="form-control" id="brand" placeholder="Enter brand" name="brand" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category</label>
                                            <select class="form-select" id="category" name="kategori">
                                                <option value="Backpack" selected>Backpack</option>
                                                <option value="Handbag">Handbag</option>
                                                <option value="Duffel">Duffel</option>
                                                <option value="Sling Bag">Sling Bag</option>
                                                <option value="Clutch">Clutch</option>
                                                <option value="Tote Bag">Tote Bag</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stock</label>
                                            <input type="number" class="form-control" id="stock" placeholder="0" min="1" name="stok">
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control" id="price" placeholder="Enter price" min="0" name="harga" required>
                                        </div>
                                    </div>
                                    <!-- Image Preview Section -->
                                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                                        <div class="mb-3">
                                            <img id="preview" src="https://via.placeholder.com/300" alt="Preview" class="preview-image" width="300" height="300">
                                        </div>
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Upload Photo</label>
                                            <input type="file" class="form-control" id="photo" accept="image/*" name="gambar" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="add">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
              

            <!-- Cards -->
            <div class="cards mt-4 d-flex align-items-center gap-2 row-gap-3 flex-wrap">
                
                <?php foreach($products as $product): ?>
                    <div class="product d-flex align-items-center gap-3 " 
                        data-bs-toggle="modal" 
                        data-bs-target="#editdelete"
                        data-id="<?= $product['id'] ?>"
                        data-nama="<?= $product['nama_produk'] ?>"
                        data-brand="<?= $product['brand'] ?>"
                        data-kategori="<?= $product['kategori'] ?>"
                        data-stok="<?= $product['stok'] ?>"
                        data-harga="<?= $product['harga'] ?>"
                        data-gambar="<?= $product['gambar'] ?>"
                    >
                        <img src="../upload/<?= $product['gambar']?>" alt="">
                        <div class="text w-100 me-3">
                            <h3><?= $product["nama_produk"]?></h3>
                            <div class="tag d-flex gap-2">
                                <p><?= $product["brand"]?></p>
                                <p><?= $product["kategori"]?></p>
                            </div>
                            <div class="foot d-flex justify-content-between align-items-center">
                                <h4>RP <?= number_format($product['harga'], 2, ',', '.') ?></h4>
                                <h4 class="fw-medium">Stok: <?= $product["stok"]?></h4>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>

            <!-- Pagination -->
            <nav class="mt-5 mb-3">
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

            <!-- Modal edit dan hapus data -->
            <div class="modal fade" id="editdelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit or Delete Product</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Form Section -->
                        <form id="" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="productId" name="productId">
                            <input type="hidden" id="gambarLama" name="gambarLama">

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="productNameEdit" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" id="productNameEdit" placeholder="Enter product name" name="nama_produkedit">
                                        </div>
                                        <div class="mb-3">
                                            <label for="brandEdit" class="form-label">Brand</label>
                                            <input type="text" class="form-control" id="brandEdit" placeholder="Enter brand" name="brandedit">
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category</label>
                                            <select class="form-select" id="categoryEdit" name="kategoriedit">
                                                <option value="Backpack" selected>Backpack</option>
                                                <option value="Handbag">Handbag</option>
                                                <option value="Duffel">Duffel</option>
                                                <option value="Sling Bag">Sling Bag</option>
                                                <option value="Clutch">Clutch</option>
                                                <option value="Tote Bag">Tote Bag</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stockEdit" class="form-label">Stock</label>
                                            <input type="number" class="form-control" id="stockEdit" placeholder="0" min="1" name="stokedit">
                                        </div>
                                        <div class="mb-3">
                                            <label for="priceEdit" class="form-label">Price</label>
                                            <input type="number" class="form-control" id="priceEdit" placeholder="Enter price" min="0" name="hargaedit">
                                        </div>
                                    </div>
                                    <!-- Image Preview Section -->
                                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                                        <div class="mb-3">
                                            <img id="previewEdit" src="https://via.placeholder.com/300" alt="Preview" class="preview-image" width="300" height="300">
                                        </div>
                                        <div class="mb-3">
                                            <label for="photoEdit" class="form-label">Upload Photo</label>
                                            <input type="file" class="form-control" id="photoEdit" accept="image/*" name="gambar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                <button type="submit" class="btn btn-warning" name="edit">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- Notifikasi ketika data berhasil ditambahkan -->
    <div class="modal fade" id="notifModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Notifications</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($addsuccess)) :?>
                        <p>Data berhasil ditambahkan!</p>
                    <?php elseif (isset($editsuccess)) :?>
                        <p>Data berhasil diedit!</p>
                    <?php elseif (isset($deletesuccess)) :?>
                        <p>Data berhasil dihapus!</p>
                    <?php endif ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>  
    <script>
        // Menampilkan modal jika data berhasil dimanipulasi
        <?php if (isset($addsuccess) || isset($editsuccess) || isset($deletesuccess)) : ?>
            let myModal = new bootstrap.Modal(document.getElementById('notifModal'));
            myModal.show();
        <?php endif; ?>
    </script>
</body>
</html>
