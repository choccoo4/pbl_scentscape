export function registerForm() {
  return {
    name: '',
    email: '',
    username: '',
    password: '',
    errors: {},
    submitting: false,

    validate() {
      this.errors = {};
      if (!this.name) this.errors.name = 'Name is required.';
      if (!this.email) this.errors.email = 'Email is required.';
      else if (!this.email.includes('@')) this.errors.email = 'Invalid email.';
      if (!this.username) this.errors.username = 'Username is required.';
      if (!this.password) this.errors.password = 'Password is required.';
      else if (this.password.length < 8) this.errors.password = 'Min. 8 characters.';
      return Object.keys(this.errors).length === 0;
    },

    async submitForm() {
      if (this.submitting) return;
      this.submitting = true;

      if (!this.validate()) {
        this.submitting = false;
        return;
      }

      try {
        const response = await fetch('/register', {
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
        });

        let data;
        try {
          data = await response.clone().json();
        } catch (e) {
          throw new Error('Invalid JSON response');
        }

        if (!response.ok) {
          this.errors = data.errors || {};
          Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: data.message || 'Something went wrong.'
          });
          this.submitting = false;
          return;
        }

        // ✅ SUCCESS
        Swal.fire({
          icon: 'success',
          title: 'Registration Successful!',
          text: 'Redirecting to login...',
          timer: 2000,
          showConfirmButton: false,
          willClose: () => {
            window.location.href = '/login';
          }
        });
      } catch (err) {
        console.error('Registration Error:', err);
        Swal.fire({
          icon: 'error',
          title: 'Request Failed',
          text: err.message || 'Something went wrong. Please try again.'
        });
      } finally {
        this.submitting = false;
      }
    }
  };
}
