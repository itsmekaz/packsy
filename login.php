<?php 
    session_start();
    if (isset($_SESSION["login"])) {
        header("Location: admin/index.php");
        exit;
    }

    require_once "koneksi.php";

    if (isset($_POST["login"])) {
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

        // cek apakah ada email yg terdaftar
        $result = mysqli_query($conn,"SELECT * FROM admin WHERE email = '$email'");

        if (mysqli_num_rows($result) === 1) {

            // dptkan data
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                
                $_SESSION["login"] = true;
                $_SESSION["admin_id"] = $row["id"];
                $_SESSION["admin_name"] = $row["nama"];
                $_SESSION["admin_email"] = $row["email"];
                $_SESSION["admin_image"] = $row["gambar"];

                header("Location: admin/index.php");
                exit;
            }
        }

        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PACKSY</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/styles/basic.css">
    <link rel="stylesheet" href="assets/styles/login.css">
</head>
<body>
    <main class="container">
        <a href="index.php"><img src="assets/images/logo-PACKSY.svg" alt=""></a>
        <hr>
        <h1 class="text-center py-2 pb-4">LOGIN</h1>
        <form action="" method="post" class="mt-3">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                <label for="password">Password</label>
            </div>
            
            <?php if (isset($error)) :?>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <p class="text-danger mt-0 ps-1">Email / Password salah!</p>
                    <p><a href="">Forgot password?</a></p>
                </div>
            <?php else :?>
                <div class="mb-4 d-flex justify-content-end align-items-center">
                    <p><a href="">Forgot password?</a></p>
                </div>
            <?php endif ?>

            <button type="submit" name="login" class="btn btn-sec text-uppercase w-100 mb-4">Login</button>
            <p class="text-center">Don't have an account? <a href="register/register.php">Register here</a></p>
        </form>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>