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

    submitForm(e) {
      e.preventDefault(); // cegah reload form

      if (this.validate()) {
        alert('Akun berhasil dibuat, silakan login');
        window.location.href = '/login'; // arahkan ke halaman login
      }
    }
  };
}
