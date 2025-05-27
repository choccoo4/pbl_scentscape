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
        this.errors.name = 'Nama wajib diisi.';
      }

      if (!this.email) {
        this.errors.email = 'Email wajib diisi.';
      } else if (!this.email.includes('@')) {
        this.errors.email = 'Email tidak valid.';
      }

      if (!this.username) {
        this.errors.username = 'Username wajib diisi.';
      }

      if (!this.password) {
        this.errors.password = 'Password wajib diisi.';
      } else if (this.password.length < 8) {
        this.errors.password = 'Password minimal 8 karakter.';
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
                title: 'Registrasi Gagal',
                text: data.message || 'Terjadi kesalahan.',
                icon: 'error'
              });
              return;
            }

            // Kalau berhasil
            Swal.fire({
              title: 'Registrasi Berhasil!',
              text: 'Anda akan diarahkan ke halaman login...',
              icon: 'success',
              timer: 2000,
              showConfirmButton: false,
              willClose: () => {
                window.location.href = '/login';
              }
            });
          })

      }
    }
  };
}
