window.closeAromaForm = function () {
    const alpineRoot = document.querySelector('[x-ref="modalAroma"]');
    if (alpineRoot && alpineRoot.__x && alpineRoot.__x.$data) {
        alpineRoot.__x.$data.showAromaForm = false;
    }

    const input = document.getElementById('inputAromaBaru');
    if (input) input.value = '';
};

document.addEventListener("DOMContentLoaded", () => {
    // Ambil elemen tombol dan input
    const btnSimpan = document.getElementById('simpanAroma');
    const inputAroma = document.getElementById('inputAromaBaru');

    // Saat tombol diklik
    btnSimpan?.addEventListener('click', async () => {
        const nama = inputAroma.value.trim();
        if (!nama) {
            alert('Aroma tidak boleh kosong.');
            return;
        }

        try {
            // Kirim POST ke route store aroma
            const res = await fetch('/seller/aroma/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ nama })
            });

            const data = await res.json();

            if (data.success) {
                // ✅ Tambahkan aroma baru ke selected[] di Alpine
                const alpineRoot = document.querySelector('[x-ref="modalAroma"]');
                if (alpineRoot && alpineRoot.__x && alpineRoot.__x.$data) {
                    alpineRoot.__x.$data.selected.push(data.aroma);
                    alpineRoot.__x.$data.categories.push(data.aroma);

                    alpineRoot.__x.$data.categories = [...alpineRoot.__x.$data.categories];
                    alpineRoot.__x.$data.selected = [...alpineRoot.__x.$data.selected];
                }

                // Kosongkan input
                inputAroma.value = '';

                // Tutup modal jika fungsi global disiapkan
                if (typeof window.closeAromaForm === 'function') {
                    window.closeAromaForm();
                }

                // Fallback tutup modal lewat Alpine (jika di-set seperti ini)
                const alpineRoot2 = document.querySelector('[x-data]');
                if (alpineRoot2 && alpineRoot2.__x && alpineRoot2.__x.$data) {
                    alpineRoot2.__x.$data.showAromaForm = false;
                }

                alert(`Aroma "${data.aroma}" berhasil ditambahkan!`);
            } else {
                alert('Gagal menyimpan aroma');
            }
        } catch (err) {
            alert('Terjadi kesalahan');
            console.error(err);
        }
    });

    // Tombol batal klik
    document.getElementById('BatalSimpanAroma')?.addEventListener('click', () => {
        if (typeof window.closeAromaForm === 'function') {
            window.closeAromaForm();
        }
    });
});
