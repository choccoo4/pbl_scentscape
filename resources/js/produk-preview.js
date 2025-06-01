export function previewImages() {
    return {
        images: [],
        fileNames: new Set(),
        errorMessage: '',
        preview(event) {
            const files = Array.from(event.target.files);
            this.errorMessage = '';

            for (let file of files) {
                if (this.images.length >= 4) {
                    this.errorMessage = 'Maksimal hanya 4 gambar yang bisa dipilih.';
                    break;
                }

                if (this.fileNames.has(file.name)) {
                    this.errorMessage = `Gambar "${file.name}" sudah dipilih sebelumnya.`;
                    continue;
                }

                if (file.size > 2 * 1024 * 1024) {
                    this.errorMessage = `Ukuran "${file.name}" melebihi 2MB. Pilih gambar lain.`;
                    continue;
                }

                const reader = new FileReader();
                reader.onload = e => {
                    this.images.push(e.target.result);
                    this.fileNames.add(file.name);
                };
                reader.readAsDataURL(file);
            }
        },
        removeImage(index) {
            this.images.splice(index, 1);
            this.fileNames = new Set(this.images.map(img => {
                // ini opsional, kalau kamu simpan nama file bersama image,
                // harus disesuaikan dengan cara kamu track nama file
                // kalau nggak, reset saja fileNames kosong
                return null; 
            }));
        }
    }
}
