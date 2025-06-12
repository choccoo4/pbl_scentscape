export function editProduk(existingImages = [], selectedCategories = []) {
  return {
    // Untuk gambar
    images: existingImages.map(url => ({ url, isExisting: true })),
    errorMessage: '',

    // Untuk kategori aroma
    selected: selectedCategories,
    showAromaForm: false,
    newAroma: '',

    init() {
      // Set default selected dari global window (jika ada)
      this.selected = window.selectedData || this.selected;
    },

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
    }
  }
}
