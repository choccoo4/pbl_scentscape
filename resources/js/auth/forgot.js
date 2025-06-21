// resources/js/auth/forgot.js

export function forgotAlert() {
  const success = document.querySelector('meta[name="forgot-success"]')?.content;

  if (success) {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: success,
      confirmButtonColor: '#414833'
    });
  }
}

// Jalankan otomatis
document.addEventListener('DOMContentLoaded', forgotAlert);
