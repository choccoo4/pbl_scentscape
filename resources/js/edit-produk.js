export function editProduk(existingImages = [], selectedCategories = []) {
    return {
        // untuk gambar
        images: existingImages.map(url => ({ url, isExisting: true })),
        errorMessage: '',
        updatePreview(event) {
            const files = Array.from(event.target.files);
            if (this.images.length + files.length > 4) {
                this.errorMessage = 'Maksimal 4 gambar saja.';
                event.target.value = '';
                return;
            }
            this.errorMessage = '';
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    this.images.push({ url: e.target.result, file });
                };
                reader.readAsDataURL(file);
            });
        },
        removeImage(index) {
            this.images.splice(index, 1);
            this.errorMessage = '';
        },

        // untuk kategori
        selected: selectedCategories,
        showAromaForm: false,
        newAroma: '',
        init() {
            this.selected = window.selectedData || this.selected;
        }
    }
}


document.addEventListener('alpine:init', () => {
    Alpine.data('previewImagesEdit', previewImagesEdit);
});

// Aroma modal buttons
document.addEventListener('DOMContentLoaded', () => {
    const simpanBtn = document.getElementById('simpanAroma');
    const batalBtn = document.getElementById('BatalSimpanAroma');

    if (simpanBtn) {
        simpanBtn.addEventListener('click', () => {
            const input = document.getElementById('inputAromaBaru');
            const val = input.value.trim();
            if (val) {
                alert('Fitur tambah aroma baru harus di-handle backend, atau diintegrasi AJAX.');
                input.value = '';
            }
        });
    }
    if (batalBtn) {
        batalBtn.addEventListener('click', () => {
            document.querySelector('[x-data]').__x.$data.showAromaForm = false;
            document.getElementById('inputAromaBaru').value = '';
        });
    }
});
