document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        let isValid = true;
        let messages = [];

        const nama = form.querySelector('[name="nama_produk"]');
        const deskripsi = form.querySelector('[name="deskripsi"]');
        const label = form.querySelector('[name="label_kategori"]');
        const tipe = form.querySelector('[name="tipe_parfum"]');
        const volume = form.querySelector('[name="volume"]');
        const harga = form.querySelector('[name="harga"]');
        const stok = form.querySelector('[name="stok"]');
        const gambar = form.querySelector('[name="gambar[]"]');
        const aromaTerpilih = window.selected || [];

        [nama, deskripsi, label, tipe, volume, harga, stok].forEach(el => {
            el.classList.remove('border-red-500');
        });

        if (!nama.value.trim()) {
            isValid = false;
            messages.push('Nama produk harus diisi');
            nama.classList.add('border-red-500');
        }

        if (!deskripsi.value.trim()) {
            isValid = false;
            messages.push('Deskripsi produk harus diisi');
            deskripsi.classList.add('border-red-500');
        }

        if (!label.value) {
            isValid = false;
            messages.push('Label kategori harus dipilih');
            label.classList.add('border-red-500');
        }

        if (!tipe.value) {
            isValid = false;
            messages.push('Tipe parfum harus dipilih');
            tipe.classList.add('border-red-500');
        }

        if (!volume.value.trim()) {
            isValid = false;
            messages.push('Volume harus diisi');
            volume.classList.add('border-red-500');
        }

        if (!harga.value.trim()) {
            isValid = false;
            messages.push('Harga harus diisi');
            harga.classList.add('border-red-500');
        }

        if (!stok.value.trim()) {
            isValid = false;
            messages.push('Stok harus diisi');
            stok.classList.add('border-red-500');
        }

        if (aromaTerpilih.length === 0) {
            isValid = false;
            messages.push('Pilih minimal 1 aroma');
        }

        if (!gambar.files.length) {
            isValid = false;
            messages.push('Upload minimal 1 gambar produk');
        }

        if (!isValid) {
            e.preventDefault();
            alert('Harap lengkapi form:\n- ' + messages.join('\n- '));
        }
    });
});