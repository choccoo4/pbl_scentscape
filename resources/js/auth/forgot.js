// resources/js/auth/forgot.js

export function forgotAlert() {
  const success = document.querySelector('meta[name="forgot-success"]')?.content;

  if (success) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: success,
      confirmButtonColor: '#414833'
    });
  }
}

// Auto-run when page is ready
document.addEventListener('DOMContentLoaded', forgotAlert);