document.addEventListener("DOMContentLoaded", () => {
    // Tambah tipe parfum
    const tipeBtn = document.querySelector('#modal-tipe-simpan');
    const tipeInput = document.querySelector('#modal-tipe-input');

    tipeBtn?.addEventListener("click", async () => {
        const nama = tipeInput.value.trim();
        if (!nama) return;

        try {
            const res = await fetch('/tipe-parfum', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ nama })
            });

            const result = await res.json();

            if (res.ok) {
                const newBtn = document.createElement('button');
                newBtn.textContent = result.data.nama;
                newBtn.className = "border border-[#BFA6A0] px-3 py-1 rounded-full text-sm bg-[#F6F1EB] text-[#3E3A39]";
                newBtn.setAttribute("type", "button");
                newBtn.addEventListener("click", () => {
                    newBtn.classList.toggle("bg-[#BFA6A0]");
                    newBtn.classList.toggle("text-white");
                });

                document.querySelector('.flex.flex-wrap.gap-2.mt-4')?.appendChild(newBtn);
                tipeInput.value = '';
            }
        } catch (err) {
            console.error("Gagal menambah tipe parfum:", err);
        }
    });

    const btnSimpan = document.getElementById('simpanAroma');
    const inputAroma = document.getElementById('inputAromaBaru');

    btnSimpan?.addEventListener('click', async () => {
        const nama = inputAroma.value.trim();
        if (!nama) {
            alert('Aroma tidak boleh kosong.');
            return;
        }

        try {
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
                // Tambah ke array Alpine (harus global)
                if (window.selected) {
                    window.selected.push(data.aroma);
                }

                // Bersihkan input & tutup modal
                inputAroma.value = '';
                window.newAroma = '';

                alert(`Aroma "${data.aroma}" berhasil ditambahkan!`);

                if (typeof window.closeAromaForm === 'function') {
                    window.closeAromaForm();
                }

                // Tutup modal
                if (window.showAromaForm !== undefined) {
                    window.showAromaForm = false;

                    const alpineRoot = document.querySelector('[x-data]');
                    if (alpineRoot && alpineRoot.__x && alpineRoot.__x.$data) {
                        alpineRoot.__x.$data.showAromaForm = false;
                    }
                }
            } else {
                alert('Gagal menyimpan aroma');
            }
        } catch (err) {
            alert('Terjadi kesalahan');
            console.error(err);
        }
    });

    document.getElementById('BatalSimpanAroma')?.addEventListener('click', () => {
        if (typeof window.closeAromaForm === 'function') {
            window.closeAromaForm();
        }
    });


});
