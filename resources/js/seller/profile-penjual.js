// resources/js/pages/profil-penjual.js

// Preview foto sebelum upload
document.getElementById('profilePicInput')?.addEventListener('change', function (event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('profilePicPreview').src = URL.createObjectURL(file);
    }
});

// SweetAlert untuk pesan sukses
const successMsg = document.querySelector('[data-success]')?.dataset.success;
if (successMsg && window.Swal) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: successMsg,
        confirmButtonColor: '#9BAF9A'
    });
}

