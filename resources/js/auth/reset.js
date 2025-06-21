import Swal from 'sweetalert2';

export function resetAlert() {
  const success = document.querySelector('meta[name="reset-success"]')?.content;

  if (success) {
    Swal.fire({
      icon: 'success',
      title: 'Password Diubah',
      text: success,
      confirmButtonColor: '#414833',
      confirmButtonText: 'OK',
      willClose: () => {
        window.location.href = "/login";
      }
    });
  }
}

// Jalankan saat DOM siap
document.addEventListener('DOMContentLoaded', resetAlert);
