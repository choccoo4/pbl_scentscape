export function loginForm() {
  return {
    email: '',
    password: '',
    errors: {},

    validate() {
      this.errors = {};

      if (!this.email) {
        this.errors.email = 'Email wajib diisi.';
      }

      if (!this.password) {
        this.errors.password = 'Password wajib diisi.';
      }

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
                title: 'Login Gagal',
                text: data.message || 'Email atau password salah.',
                icon: 'error',
                timer: 2500,
                showConfirmButton: false
              });
              return;
            }

            const data = await res.json();
            Swal.fire({
              title: 'Login Berhasil!',
              text: 'Anda akan diarahkan...',
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
              text: 'Terjadi kesalahan. Silakan coba lagi.',
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

