export function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Anda yakin ingin keluar dari akun?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yakin',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logoutForm').submit();
        }
    });
}
