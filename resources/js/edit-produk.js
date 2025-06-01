function previewImagesEdit(existingImages) {
    return {
        images: existingImages.map(url => ({ url })),
        updatePreview(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                if (this.images.length >= 4) break;
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.images.push({ url: e.target.result, file });
                };
                reader.readAsDataURL(file);
            }
        },
        removeImage(index) {
            this.images.splice(index, 1);
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
