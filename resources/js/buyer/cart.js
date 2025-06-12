export function cartRoot() {
    return {
        total: 0,
        cartItems: [], // ganti dari "items"

        init() {
            const elements = document.querySelectorAll('[x-data^="cartItem"]');
            this.cartItems = Array.from(elements).map((el) => {
                const xdata = el.getAttribute('x-data');
                const match = xdata.match(/cartItem\((\d+),\s*(\d+)\)/);
                const price = Number(match[1]);
                const quantity = Number(match[2]);
                return {
                    price,
                    quantity,
                    total: price * quantity,
                };
            });
            this.updateTotal();
        },

        updateTotal() {
            this.total = this.cartItems.reduce((acc, item) => acc + item.total, 0);
        },

        updateItem(index, quantity, price) {
            this.cartItems[index] = {
                quantity,
                price,
                total: quantity * price
            };
            this.updateTotal();
        },

        get totalFormatted() {
            return this.total.toLocaleString('id-ID');
        }
    };
}


export function cartItem(price, initialQty = 1) {
    return {
        quantity: initialQty,
        price: price,

        get total() {
            return (this.quantity * this.price).toLocaleString('id-ID');
        },

        increase() {
            this.quantity++;
        },

        decrease() {
            if (this.quantity > 1) this.quantity--;
        }
    };
}
