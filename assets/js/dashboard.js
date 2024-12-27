const photoInput = document.getElementById('photo');
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

const photoInputEdit = document.getElementById('photoEdit');
const previewImageEdit = document.getElementById('previewEdit');

photoInputEdit.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImageEdit.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});


// Event listener untuk elemen produk
const products = document.querySelectorAll('.product');
products.forEach(product => {
    product.addEventListener('click', (event) => {
        // Ambil data dari elemen yang diklik
        const productId = event.currentTarget.getAttribute('data-id');
        const productName = event.currentTarget.getAttribute('data-nama');
        const productBrand = event.currentTarget.getAttribute('data-brand');
        const productCategory = event.currentTarget.getAttribute('data-kategori');
        const productStock = event.currentTarget.getAttribute('data-stok');
        const productPrice = event.currentTarget.getAttribute('data-harga');
        const productImage = event.currentTarget.getAttribute('data-gambar');

        // Set data pada form modal
        document.getElementById('productId').value = productId;
        document.getElementById('productNameEdit').value = productName;
        document.getElementById('brandEdit').value = productBrand;
        document.getElementById('categoryEdit').value = productCategory;
        document.getElementById('stockEdit').value = productStock;
        document.getElementById('priceEdit').value = productPrice;
        document.getElementById('gambarLama').value = productImage;
        document.getElementById('previewEdit').src = `../upload/${productImage}`;

    });
});

