document.addEventListener('DOMContentLoaded', function () {

    // VALIDATION FOR ADDING PRODUCT
    const form = document.querySelector('form');
    if (form) {
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
                messages.push('Product name is required');
                nama.classList.add('border-red-500');
            }
            if (!deskripsi.value.trim()) {
                isValid = false;
                messages.push('Product description is required');
                deskripsi.classList.add('border-red-500');
            }
            if (!label.value) {
                isValid = false;
                messages.push('Category label must be selected');
                label.classList.add('border-red-500');
            }
            if (!tipe.value) {
                isValid = false;
                messages.push('Perfume type must be selected');
                tipe.classList.add('border-red-500');
            }
            if (!volume.value.trim()) {
                isValid = false;
                messages.push('Volume is required');
                volume.classList.add('border-red-500');
            }
            if (!harga.value.trim()) {
                isValid = false;
                messages.push('Price is required');
                harga.classList.add('border-red-500');
            }
            if (!stok.value.trim()) {
                isValid = false;
                messages.push('Stock is required');
                stok.classList.add('border-red-500');
            }
            if (aromaTerpilih.length === 0) {
                isValid = false;
                messages.push('Select at least one scent');
            }
            if (!gambar.files.length) {
                isValid = false;
                messages.push('Upload at least one product image');
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please complete the form:\n- ' + messages.join('\n- '));
            }
        });
    }

    // SWEETALERT DELETE PRODUCT
    const deleteForms = document.querySelectorAll('.delete-produk');
    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Delete Product?',
                text: "Deleted products cannot be recovered!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#9BAF9A',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
