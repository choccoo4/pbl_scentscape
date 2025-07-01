export function editProduk(existingImages = [], selectedCategories = []) {
  return {
    // For images
    images: existingImages.map(url => ({ url, isExisting: true })),
    errorMessage: '',

    // For aroma categories
    selected: selectedCategories,
    showAromaForm: false,
    newAroma: '',

    init() {
      // Set default selected from global window (if available)
      this.selected = window.selectedData || this.selected;
    },

    updatePreview(event) {
      const files = Array.from(event.target.files);
      if (this.images.length + files.length > 4) {
        this.errorMessage = 'Maximum of 4 images only.';
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
