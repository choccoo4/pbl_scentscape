// Show success alert if password reset success (based on meta tag)
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

// Login Form Alpine.js logic
export function loginForm() {
  return {
    email: '',
    password: '',
    errors: {},

    validate() {
      this.errors = {};
      if (!this.email) this.errors.email = 'Email is required.';
      if (!this.password) this.errors.password = 'Password is required.';
      return Object.keys(this.errors).length === 0;
    },

    submitForm() {
      if (this.validate()) {
        fetch('/login', {
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
        })
          .then(async res => {
            if (!res.ok) {
              const data = await res.json();
              Swal.fire({
                title: 'Login Failed',
                text: data.message || 'Incorrect email or password.',
                icon: 'error',
                timer: 2500,
                showConfirmButton: false
              });
              return;
            }

            const data = await res.json();
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
          })
          .catch(err => {
            Swal.fire({
              title: 'Oops!',
              text: 'An error occurred. Please try again.',
              icon: 'error',
              timer: 2500,
              showConfirmButton: false
            });
            console.error(err);
          });
      }
    }
  };
}