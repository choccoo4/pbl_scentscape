import Swal from 'sweetalert2';

export function showOutOfStockAlert() {
    Swal.fire({
        icon: 'info',
        title: 'Out of Stock',
        text: 'Sorry, this product is currently unavailable.',
        confirmButtonColor: '#9BAF9A'
    });
}

export function showSuccessAlert() {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Product has been added to your cart.',
        timer: 2000,
        showConfirmButton: false
    });
}

export function showErrorAlert(message = 'Something went wrong.') {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: message
    });
}
