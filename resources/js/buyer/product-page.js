import { showSuccessAlert, showErrorAlert, showOutOfStockAlert } from './product-detail';

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-to-cart-form');
    const submitButton = document.getElementById('add-to-cart-button');
    const outOfStockButton = document.getElementById('out-of-stock-button');

    // Event saat tombol "Add to Cart" ditekan
    if (form && submitButton) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            submitButton.disabled = true;
            submitButton.innerText = 'Adding...';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to add product.');
                return response.json();
            })
            .then(() => showSuccessAlert())
            .catch(error => showErrorAlert(error.message))
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerText = 'Add to Cart';
            });
        });
    }

    // Event saat tombol "Out of Stock" ditekan
    if (outOfStockButton) {
        outOfStockButton.addEventListener('click', function () {
            showOutOfStockAlert();
        });
    }
});
