document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.body.dataset.success;
    const errorMessage = document.body.dataset.error;

    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: successMessage,
            timer: 2000,
            showConfirmButton: false
        });
    }

    if (errorMessage) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: errorMessage,
            timer: 2000,
            showConfirmButton: false
        });
    }
});
