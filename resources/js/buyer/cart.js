export function cartRoot() {
    return {
        total: 0,
        selectedTotal: 0,
        cartItems: [],

        init() {
            window.cartRootRef = this;
            console.log('[cartRoot:init] Ready to receive items from cartItem');
        },

        registerItem(component) {
            this.cartItems.push(component);
            component.rootRef = this;
            component.index = this.cartItems.length - 1;

            this.updateTotal();
            this.updateSelectedTotal();
        },

        updateTotal() {
            this.total = this.cartItems.reduce((acc, item) => acc + item.total, 0);
        },

        updateSelectedTotal() {
            this.selectedTotal = this.cartItems
                .filter(item => item.selected)
                .reduce((acc, item) => acc + item.total, 0);

            console.log('[updateSelectedTotal] Selected items:', this.cartItems.filter(i => i.selected).map(i => i.idProduk));
            console.log('[updateSelectedTotal] Total:', this.selectedTotal);
        },

        updateItem(index, quantity, price) {
            this.cartItems[index] = {
                ...this.cartItems[index],
                quantity,
                price,
                total: quantity * price
            };
            this.updateTotal();
            this.updateSelectedTotal();
        },

        get totalFormatted() {
            return this.total.toLocaleString('id-ID');
        }
    };
}

export function cartItem(price, qty, idProduk, stok, selectedAwal) {
    return {
        price,
        quantity: qty,
        idProduk,
        selected: selectedAwal ?? false,
        stock: stok,
        total: 0,
        index: null,
        rootRef: null,

        init() {
            this.total = this.price * this.quantity;

            this.$nextTick(() => {
                if (window.cartRootRef && typeof window.cartRootRef.registerItem === 'function') {
                    window.cartRootRef.registerItem(this);
                    console.log(`[cartItem:init] ${this.idProduk} registered to cartRoot`);
                } else {
                    console.warn(`[cartItem:init] Failed to register to cartRoot for ${this.idProduk}`);
                }
            });
        },

        toggleSelected(val) {
            this.selected = val;
            if (!this.rootRef || this.index === null) {
                console.warn("toggleSelected() failed to sync", this.rootRef, this.index);
                return;
            }
            this.rootRef.cartItems[this.index].selected = val;
            this.rootRef.updateSelectedTotal();
            console.log(`Item ${this.idProduk} toggleSelected():`, val);
        },

        increase() {
            if (this.quantity < this.stock) this.quantity++;
            this.saveQuantity();
        },

        decrease() {
            if (this.quantity > 1) this.quantity--;
            this.saveQuantity();
        },

        saveQuantity() {
            this.total = this.price * this.quantity;
            if (this.rootRef && this.index !== null) {
                this.rootRef.cartItems[this.index].quantity = this.quantity;
                this.rootRef.cartItems[this.index].total = this.total;
                this.rootRef.updateTotal();
                if (this.selected) {
                    this.rootRef.updateSelectedTotal();
                }
            }

            fetch(`/cart/update/${this.idProduk}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({ jumlah_produk: this.quantity })
            })
            .then(res => res.json())
            .then(data => {
                console.log('Quantity updated successfully:', data);
            })
            .catch(err => {
                Swal.fire({
                    title: 'Failed',
                    text: 'Failed to update product quantity!',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });
                console.error(err);
            });
        },

        removeItem() {
            Swal.fire({
                title: 'Remove Item?',
                text: 'Are you sure you want to remove this item from the cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/cart/remove/${this.idProduk}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        }
                    })
                    .then(res => {
                        if (res.ok) {
                            this.$el.remove();
                            if (typeof this.rootRef?.updateTotal === 'function') {
                                this.rootRef.cartItems.splice(this.index, 1);
                                this.rootRef.updateTotal();
                                this.rootRef.updateSelectedTotal();
                            }
                            Swal.fire({
                                title: 'Success',
                                text: 'Item has been removed from the cart.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                title: 'Failed',
                                text: 'Failed to remove the item from the cart!',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while removing the item.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        console.error('Remove error:', err);
                    });
                }
            });
        },

        updateSelection() {
            if (!this.ready || !this.rootRef || this.index === null) {
                console.warn("cartItem: not ready to update selection", this.rootRef, this.index);
                return;
            }
            this.rootRef.cartItems[this.index].selected = this.selected;
            this.rootRef.updateSelectedTotal();
            console.log(`Item ${this.idProduk} selected:`, this.selected);
        }
    };
}
