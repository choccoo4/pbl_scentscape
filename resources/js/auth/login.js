document.addEventListener('DOMContentLoaded', () => {
  const status = document.querySelector('meta[name="reset-status"]')?.content;

  if (status) {
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: status,
      confirmButtonColor: '#4CAF50',
    });
  }
});

// Login form functionality
export function loginForm() {
  return {
    email: '',
    password: '',
    errors: {},
    isSubmitting: false, // 🔐 Tambahkan ini

    validate() {
      this.errors = {};
      if (!this.email) this.errors.email = 'Email is required.';
      if (!this.password) this.errors.password = 'Password is required.';
      return Object.keys(this.errors).length === 0;
    },

    async submitForm() {
      if (!this.validate() || this.isSubmitting) return;

      this.isSubmitting = true; // ✅ prevent double click

      try {
        const res = await fetch('/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password
          })
        });

        const data = await res.json();

        if (!res.ok) {
          Swal.fire({
            title: 'Login Failed',
            text: data.message || 'Incorrect email or password.',
            icon: 'error',
            timer: 2500,
            showConfirmButton: false
          });
          return;
        }

        Swal.fire({
          title: 'Login Successful!',
          text: 'Redirecting...',
          icon: 'success',
          timer: 2500,
          showConfirmButton: false,
          willClose: () => {
            if (data.role === 'penjual') {
              window.location.href = '/seller/dashboard';
            } else {
              window.location.href = '/home';
            }
          }
        });
      } catch (err) {
        Swal.fire({
          title: 'Oops!',
          text: 'Something went wrong. Please try again.',
          icon: 'error',
          timer: 2500,
          showConfirmButton: false
        });
        console.error(err);
      } finally {
        this.isSubmitting = false; // 🔓 allow retry
      }
    }
  };
}
