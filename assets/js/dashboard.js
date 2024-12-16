const sidebar = document.getElementById("sidebar");
const toggleButton = document.getElementById("toggleSidebar");

toggleButton.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
    const icon = toggleButton.querySelector("i");
    icon.classList.toggle("bi-chevron-double-right");

    const logo = document.getElementById("logo");
    logo.classList.toggle("logo-small");
    
    const nameAdmin = document.getElementById("name");
    nameAdmin.classList.toggle("d-none");

});


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
        document.getElementById('previewEdit').src = `../assets/images/bags/${productImage}`;
    });
});

