export function confirmLogoutSeller() {
    Swal.fire({
        title: 'Logout from seller account?',
        text: 'You will be logged out and redirected to the login page.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f', // red
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, Logout',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const logoutForm = document.getElementById('logout-form-seller');
            if (logoutForm) logoutForm.submit();
        }
    });
}
