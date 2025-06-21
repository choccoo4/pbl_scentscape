import Swal from 'sweetalert2';

export function confirmLogoutSeller() {
    Swal.fire({
        title: 'Logout dari akun penjual?',
        text: 'Anda akan keluar dan kembali ke halaman login.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f', // merah
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const logoutForm = document.getElementById('logout-form-seller');
            if (logoutForm) logoutForm.submit();
        }
    });
}
