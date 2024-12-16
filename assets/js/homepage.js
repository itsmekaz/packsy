const navbar = document.querySelector("header.navbar");

window.addEventListener("scroll", () => {
    if (window.scrollY > 50) { // Jika scroll lebih dari 50px
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});



    // Mendapatkan elemen yang terkait dengan link untuk berpindah antar modal
    const goToRegister = document.getElementById('goToRegister');
    const goToLogin = document.getElementById('goToLogin');
    const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));

    // Menampilkan login modal ketika klik pada "Register" di footer login modal
    goToRegister.addEventListener('click', function() {
        // Tutup register modal dan tampilkan login modal
        registerModal.hide();
        loginModal.show();
    });

    // Menampilkan register modal ketika klik pada "Login" di footer register modal
    goToLogin.addEventListener('click', function() {
        // Tutup login modal dan tampilkan register modal
        loginModal.hide();
        registerModal.show();
    });


