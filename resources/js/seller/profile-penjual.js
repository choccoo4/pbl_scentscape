// resources/js/pages/profil-penjual.js

// Preview profile photo before upload
document.getElementById('profilePicInput')?.addEventListener('change', function (event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('profilePicPreview').src = URL.createObjectURL(file);
    }
});

// SweetAlert for success message
const successMsg = document.querySelector('[data-success]')?.dataset.success;
if (successMsg && window.Swal) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: successMsg,
        confirmButtonColor: '#9BAF9A'
    });
}
