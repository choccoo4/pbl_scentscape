export function resetAlert() {
  const success = document.querySelector('meta[name="reset-success"]')?.content;

  if (success) {
    Swal.fire({
      icon: 'success',
      title: 'Password Changed',
      text: success,
      confirmButtonColor: '#414833',
      confirmButtonText: 'OK',
      willClose: () => {
        window.location.href = "/login";
      }
    });
  }
}

// Run when DOM is ready
document.addEventListener('DOMContentLoaded', resetAlert);
