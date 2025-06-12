document.addEventListener("alpine:init", () => {
    window.closeAromaForm = function () {
        const simpanBtn = document.getElementById('simpanAroma');
        const alpineRoot = Alpine.closestDataStack(simpanBtn)?.[0];

        if (alpineRoot) {
            alpineRoot.showAromaForm = false;
            alpineRoot.newAroma = '';
            alpineRoot.selectedKategori = '';
        }

        const input = document.getElementById('inputAromaBaru');
        if (input) input.value = '';
    };
});

document.addEventListener("DOMContentLoaded", () => {
        const btnSimpan = document.getElementById('simpanAroma');

        btnSimpan?.addEventListener('click', async (e) => {
            const input = document.getElementById('inputAromaBaru');
            const nama = input?.value.trim();
            if (!nama) {
                alert('Aroma tidak boleh kosong.');
                return;
            }

            const alpineRoot = Alpine.closestDataStack(e.target)?.[0];
            if (!alpineRoot) {
                alert("Gagal mengambil data modal.");
                return;
            }

            const kategoriId = alpineRoot.selectedKategori;
            if (!kategoriId) {
                alert("Pilih aroma induk terlebih dahulu.");
                return;
            }

            try {
                const res = await fetch('/seller/aroma/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ nama, kategori_id: kategoriId })
                });

                const contentType = res.headers.get('content-type') || '';

                if (!contentType.includes('application/json')) {
                    const text = await res.text();
                    console.error("Response bukan JSON:", text);
                    alert("Gagal menyimpan aroma (response bukan JSON).");
                    return;
                }

                const data = await res.json();

                if (!res.ok) {
                    // Hanya tampilkan alert error kalau ada kesalahan dari server
                    const msg = data?.message || 'Gagal menyimpan aroma.';
                    alert(msg);
                    console.error("Server error:", data);
                    return;
                }

                // Sukses -> tambahkan ke UI dan tampilkan swal
                if (data.success) {
                    const aromaBaru = data.aroma;
                    const { categories, selected } = alpineRoot;

                    if (!categories.includes(aromaBaru)) {
                        alpineRoot.categories.push(aromaBaru);
                    }
                    if (!selected.includes(aromaBaru)) {
                        alpineRoot.selected.push(aromaBaru);
                    }

                    // Force update
                    alpineRoot.categories = [...alpineRoot.categories];
                    alpineRoot.selected = [...alpineRoot.selected];

                    window.closeAromaForm();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: `Aroma "${aromaBaru}" berhasil ditambahkan.`,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    alert('Gagal menyimpan aroma.');
                }
            } catch (error) {
                alert('Terjadi kesalahan saat menyimpan aroma.');
                console.error(error);
            }

        });

        // Tombol Batal
        document.getElementById('BatalSimpanAroma')?.addEventListener('click', () => {
            window.closeAromaForm();
        });
    });
