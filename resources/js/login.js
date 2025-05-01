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
  
      submitForm(e) {
        e.preventDefault();
  
        if (this.validate()) {
          // Simulasi: cek apakah login sebagai admin/penjual
          if (this.email === 'adminscentscape@gmail.com' && this.password === 'admin123') {
            alert('Login sebagai penjual berhasil');
            window.location.href = '/dashboard';
          } else {
            alert('Login sebagai pembeli berhasil');
            window.location.href = '/home';
          }
        }
      }
    };
  }
  