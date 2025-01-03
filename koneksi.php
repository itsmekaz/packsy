<?php 
    $conn = mysqli_connect("localhost","root","","packsy");

    if ($conn -> connect_error) {
        echo "Koneksi database gagal!";
        die("error!");
    }

    // menampilkan data
    function show($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    
    // menambahkan data
    function insert($data) {
        global $conn;
        // ambil data
        $nama_produk = htmlspecialchars($data["nama_produk"]);
        $brand = htmlspecialchars($data["brand"]);
        $kategori = htmlspecialchars($data["kategori"]);
        $stok = htmlspecialchars($data["stok"]);
        $harga = htmlspecialchars($data["harga"]);
        $gambar = uploadGambar();

        // masukkan ke tabel products
        $query = "INSERT INTO products
                VALUES ('', '$nama_produk', '$brand', '$kategori', '$stok', '$harga', '$gambar')";

        mysqli_query($conn, $query);

        // Log aktivitas admin
        $admin_id = $_SESSION['admin_id'];
        $produk_id = mysqli_insert_id($conn);

        // Masukkan log aktivitas ke dalam tabel admin_logs
        $log_query = "INSERT INTO admin_logs (admin_id, produk_id, aksi)
                    VALUES ('$admin_id', '$produk_id', 'Add')";
        mysqli_query($conn, $log_query);

        // mengembalikan nilai 1 bila berhasil ditambahkan, -1 bila gagal ditambahkan
        return mysqli_affected_rows($conn);
    }


    // edit data
    function update($data) {
        global $conn;
        $produkId = htmlspecialchars($data['productId']);
        $nama_produk = htmlspecialchars($data['nama_produkedit']);
        $brand = htmlspecialchars($data['brandedit']);
        $kategori = htmlspecialchars($data['kategoriedit']);
        $stok = htmlspecialchars($data['stokedit']);
        $harga = htmlspecialchars($data['hargaedit']);

        if ($_FILES['gambar']['error'] === 4) {
            $gambar = htmlspecialchars($data['gambarLama']);
        } else {
            $gambar = uploadGambar();
            if (!$gambar) {
                return false;
            }
        }

        $sql = "UPDATE products SET
                nama_produk = '$nama_produk',
                brand = '$brand',
                kategori = '$kategori',
                stok = '$stok',
                harga = '$harga',
                gambar = '$gambar' 
                WHERE id = $produkId";
        mysqli_query($conn, $sql);

        // Log aktivitas admin
        $admin_id = $_SESSION['admin_id'];

        // Masukkan log aktivitas ke dalam tabel admin_logs
        $log_query = "INSERT INTO admin_logs (admin_id, produk_id, aksi)
                    VALUES ('$admin_id', '$produkId', 'Update')";
        mysqli_query($conn, $log_query);

        return mysqli_affected_rows($conn);
    }


    function uploadGambar() {
        $namaFile = $_FILES['gambar']['name'];
        $tmpName = $_FILES["gambar"]["tmp_name"];
        move_uploaded_file($tmpName, "../upload/".$namaFile);

        return $namaFile;
    }

    // delete data
    function hapus($data) {
        global $conn;
        $productId = $data['productId'];

        $admin_id = $_SESSION['admin_id'];

        // Masukkan log aktivitas ke dalam tabel admin_logs
        $log_query = "INSERT INTO admin_logs (admin_id, produk_id, aksi)
                    VALUES ('$admin_id', '$productId', 'Delete')";
        mysqli_query($conn, $log_query);

        // Hapus produk dari tabel products
        mysqli_query($conn, "DELETE FROM products WHERE id = '$productId'");

        return mysqli_affected_rows($conn);
    }


    // mencari data
    function cari($search) {
        $query = "SELECT * FROM products
                WHERE nama_produk LIKE '%$search%' OR brand LIKE '%$search%' OR kategori LIKE '%$search%' OR harga LIKE '%$search%'";
        return show($query);
    }

    // update data admin
    function updateAdmin($data) {
        global $conn;
        $adminId = htmlspecialchars($data['adminId']);
        $nama = htmlspecialchars($data['nama']);
        $email = htmlspecialchars($data['email']);
        
        if ($_FILES['gambar']['error'] === 4) {
            $gambar = htmlspecialchars($data['gambarLama']);
        } else {
            $gambar = uploadGambar();
            if (!$gambar) {
                return false;
            }
        }

        $sql = "UPDATE admin SET
                nama = '$nama',
                email = '$email',
                gambar = '$gambar' 
                WHERE id = $adminId";
        mysqli_query($conn, $sql);

        return mysqli_affected_rows($conn);
    }

    // delete data admin
    function hapusAdmin($data) {
        global $conn;
        $productId = $data['adminId'];
        mysqli_query($conn, "DELETE FROM admin WHERE id = '$productId'");
        
        return mysqli_affected_rows($conn);
    }
?>