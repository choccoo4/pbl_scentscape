export function forgotAlert() {
  const success = document.querySelector('meta[name="reset-status"]')?.content;
  const error = document.querySelector('meta[name="forgot-error"]')?.content;

  if (success) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: success,
      confirmButtonColor: '#414833'
    }).then(() => {
      window.location.href = '/login';
    });
  }

  if (error) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: error,
      confirmButtonColor: '#414833'
    });
  }
}

document.addEventListener('DOMContentLoaded', forgotAlert);
