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
        $gambar = htmlspecialchars($data["gambar"]);

        // masukkan ke tabel products
        $query = "INSERT INTO products
                VALUES ('', '$nama_produk', '$brand', '$kategori', '$stok', '$harga', '$gambar')";

        mysqli_query($conn, $query);

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
        $gambar = htmlspecialchars($data['gambaredit']); // Jika ada gambar baru

        $sql = "UPDATE products SET
                nama_produk = '$nama_produk',
                brand = '$brand',
                kategori = '$kategori',
                stok = '$stok',
                harga = '$harga',
                gambar = '$gambar' 
                WHERE id = $produkId";
        mysqli_query($conn, $sql);

        return mysqli_affected_rows($conn);
    }

    // delete data
    function delete($data) {
        global $conn;
        $productId = $data['productId'];
        mysqli_query($conn, "DELETE FROM products WHERE id = '$productId'");

        return mysqli_affected_rows($conn);
    }
?>