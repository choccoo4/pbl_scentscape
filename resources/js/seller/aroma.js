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
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Aroma tidak boleh kosong.',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        const alpineRoot = Alpine.closestDataStack(e.target)?.[0];
        if (!alpineRoot) {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: 'Gagal mengambil data modal.',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        const kategoriId = alpineRoot.selectedKategori;
        if (!kategoriId) {
            Swal.fire({
                icon: 'info',
                title: 'Oops!',
                text: 'Pilih aroma induk terlebih dahulu.',
                timer: 2000,
                showConfirmButton: false
            });
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
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menyimpan aroma (response bukan JSON).',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            const data = await res.json();

            if (!res.ok) {
                const msg = data?.message || 'Gagal menyimpan aroma.';
                console.error("Server error:", data);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            if (data.success) {
                const aromaBaru = data.aroma;
                const { categories, selected } = alpineRoot;

                if (!categories.includes(aromaBaru)) {
                    alpineRoot.categories.push(aromaBaru);
                }
                if (!selected.includes(aromaBaru)) {
                    alpineRoot.selected.push(aromaBaru);
                }

                alpineRoot.categories = [...alpineRoot.categories];
                alpineRoot.selected = [...alpineRoot.selected];

                window.closeAromaForm();

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: `The aroma "${aromaBaru}" has been successfully added.`,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to save the aroma.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while saving the aroma.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });

    document.getElementById('BatalSimpanAroma')?.addEventListener('click', () => {
        window.closeAromaForm();
    });
});
