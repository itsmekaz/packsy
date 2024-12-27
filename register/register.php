<?php 
    require_once "../koneksi.php";

    if (isset($_POST["register"])) {
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);
        $gambar = uploadGambar();
        $password = htmlspecialchars($_POST["password"]);

        // enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // cek apakah ada email yg sama
        $result = mysqli_query($conn,"SELECT email FROM admin WHERE email = '$email'");
         
        if (mysqli_num_rows($result) === 1) {
            $error = true;
        } else { 
            $success = mysqli_query($conn,"INSERT INTO admin VALUES('', '$name', '$email', '$password', '$gambar')");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | PACKSY</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/styles/basic.css">
    <link rel="stylesheet" href="assets/styles/register.css">
</head>
<body>
    
    <main class="container">
        <img src="assets/images/logo-PACKSY.svg" alt="">
        <hr>
        <h1 class="text-center py-2 pb-4">REGISTER</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                <label for="name">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                <label for="password">Password</label>
            </div>
            
            <?php if (isset($error)) :?>
                <div class=" input-group mb-4">
                    <label class="input-group-text" for="img">Upload Your Photo</label>
                    <input class="form-control" type="file" id="img" name="gambar" registered>
                </div>

                <p class="text-danger mt-0 ps-1" role="alert">
                    Email already registered!
                </p>
            <?php else :?>
                <div class=" input-group mb-5">
                    <label class="input-group-text" for="img">Upload Your Photo</label>
                    <input class="form-control" type="file" id="img" accept="image/*" name="gambar" required>
                </div>
            <?php endif?>

            <button type="submit" name="register" class="btn btn-sec text-uppercase w-100 mb-4">Register</button>
            <p class="text-center">Already have an account? <a href="../login.php">Login</a></p>
        </form>
    </main>
    
    
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">CONGRATS!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You've successfully registered!🥳</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" class="btn btn-primary" href="../login.php">Login Here</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Menampilkan modal jika registrasi berhasil
        <?php if (isset($success)) : ?>
            let myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        <?php endif; ?>
    </script>
</body>
</html>