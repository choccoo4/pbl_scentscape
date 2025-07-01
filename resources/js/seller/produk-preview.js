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
                    this.errorMessage = 'Only a maximum of 4 images can be selected.';
                    break;
                }

                if (this.fileNames.has(file.name)) {
                    this.errorMessage = `Image "${file.name}" has already been selected.`;
                    continue;
                }

                if (file.size > 2 * 1024 * 1024) {
                    this.errorMessage = `Size of "${file.name}" exceeds 2MB. Please select a smaller image.`;
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
            // Reset fileNames if tracking by image name is not consistent
            this.fileNames = new Set(this.images.map(img => {
                return null;
            }));
        }
    }
}
