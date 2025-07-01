export function registerForm() {
  return {
    name: '',
    email: '',
    username: '',
    password: '',
    errors: {},

    validate() {
      this.errors = {}; // reset errors

      if (!this.name) {
        this.errors.name = 'Name is required.';
      }

      if (!this.email) {
        this.errors.email = 'Email is required.';
      } else if (!this.email.includes('@')) {
        this.errors.email = 'Invalid email address.';
      }

      if (!this.username) {
        this.errors.username = 'Username is required.';
      }

      if (!this.password) {
        this.errors.password = 'Password is required.';
      } else if (this.password.length < 8) {
        this.errors.password = 'Password must be at least 8 characters.';
      }

      return Object.keys(this.errors).length === 0;
    },

    submitForm() {
      console.log('Submit form clicked!');

      if (this.validate()) {
        fetch('/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            username: this.username,
            password: this.password
          })
        })
          .then(async response => {
            const data = await response.json();

            if (!response.ok) {
              Swal.fire({
                title: 'Registration Failed',
                text: data.message || 'An error occurred.',
                icon: 'error'
              });
              return;
            }

            // If successful
            Swal.fire({
              title: 'Registration Successful!',
              text: 'You will be redirected to the login page...',
              icon: 'success',
              timer: 2000,
              showConfirmButton: false,
              willClose: () => {
                window.location.href = '/login';
              }
            });
          });
      }
    }
  };
}
