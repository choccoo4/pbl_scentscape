document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.add-to-cart');

    buttons.forEach(button => {
        button.addEventListener('click', async () => {
            const id = button.getAttribute('data-id');

            try {
                const response = await fetch(`/cart/add/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: result.message || 'Produk berhasil ditambahkan ke keranjang',
                        timer: 1500,
                        showConfirmButton: false,
                    });

                    // Optional: Update keranjang di navbar
                    // refreshCartCount();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: result.message || 'Gagal menambahkan ke keranjang',
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Coba lagi nanti.',
                });
            }
        });
    });
});
