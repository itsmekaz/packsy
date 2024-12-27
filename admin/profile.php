<?php 
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: ../login.php");
        exit;
    }
    $admin_id = $_SESSION["admin_id"];
    $admin_name = $_SESSION["admin_name"];
    $admin_email = $_SESSION["admin_email"];
    $admin_image = $_SESSION["admin_image"];

    require_once "../koneksi.php";

    if (isset($_POST["edit"])) {
        if (updateAdmin($_POST) > 0) { 
            $editsuccess = true;
        }
    }

    if (isset($_POST["delete"])) {
        if (hapusAdmin($_POST) > 0) {
            $deletesuccess = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACKSY | PROFILE</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/styles/basic.css">
    <link rel="stylesheet" href="../assets/styles/profile.css">
</head>
<body>
    <main class="d-flex">
        <?php include "../layout/sidebar.php"?>
        
        <!-- Content -->
        <section class="content p-4 container-fluid">
            <h1 class="mt-2">Profile</h1>
            
            <div class="m-4 d-flex justify-content-center">
                <img id="preview" src="../upload/<?= $admin_image ?>" alt="Preview" class="preview-image" width="220" height="220" style="border-radius: 50%;">
            </div>
            <form action="" method="post" class="w-50 mx-auto" enctype="multipart/form-data">
                <input type="hidden" id="adminId" name="adminId" value="<?= $admin_id ?>">
                <input type="hidden" id="gambarLama" name="gambarLama" value="<?= $admin_image ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" name="nama" value="<?= $admin_name ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?= $admin_email ?>">
                </div>
                <div class="mb-5">
                    <label for="gambar" class="form-label">Upload New Photo</label>
                    <input type="file" class="form-control" id="gambar" accept="image/*" name="gambar">
                </div>
                <div class="mt-5 d-flex justify-content-end align-items-center gap-2">
                    <button type="submit" class="btn btn-danger" name="delete">Delete Account</button>
                    <button type="submit" class="btn btn-warning" name="edit">Edit</button>
                </div>
            </form>
        </section>
    </main>


    <!-- Notifikasi ketika data berhasil diupdate/delete -->
    <div class="modal fade" id="notifModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Notifications</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($editsuccess)) :?>
                        <p>Data berhasil diedit! Silakan logout dan login kembali</p>
                    <?php elseif (isset($deletesuccess)) :?>
                        <p>Akun berhasil dihapus!</p>
                    <?php endif ?>
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <a type="button" href="../logout.php" class="btn btn-secondary">Okay</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const photoInput = document.getElementById('gambar');
        const previewImage = document.getElementById('preview');

        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });


        // Menampilkan modal jika data berhasil dimanipulasi
        <?php if (isset($editsuccess) || isset($deletesuccess)) : ?>
            let myModal = new bootstrap.Modal(document.getElementById('notifModal'));
            myModal.show();
        <?php endif; ?>
    </script>
</body>
</html>
