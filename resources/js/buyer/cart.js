export function cartRoot() {
    return {
        total: 0,
        selectedTotal: 0,
        cartItems: [],

        init() {
            window.cartRootRef = this;
            console.log('[cartRoot:init] Siap menerima item dari cartItem');
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
                    console.log(`[cartItem:init] ${this.idProduk} terdaftar ke cartRoot`);
                } else {
                    console.warn(`[cartItem:init] Gagal daftar ke cartRoot untuk ${this.idProduk}`);
                }
            });
        },

        toggleSelected(val) {
            this.selected = val;
            if (!this.rootRef || this.index === null) {
                console.warn("toggleSelected() gagal sync", this.rootRef, this.index);
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
                console.log('Berhasil update:', data);
            })
            .catch(err => {
                Swal.fire({
                    title: 'Gagal',
                    text: 'Gagal update jumlah produk!',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });
                console.error(err);
            });
        },

        removeItem() {
            Swal.fire({
                title: 'Hapus Item?',
                text: 'Yakin ingin menghapus item ini dari keranjang?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
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
                                title: 'Berhasil',
                                text: 'Item berhasil dihapus dari keranjang.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Gagal menghapus item dari keranjang!',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghapus.',
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
                console.warn("cartItem: belum siap update selection", this.rootRef, this.index);
                return;
            }
            this.rootRef.cartItems[this.index].selected = this.selected;
            this.rootRef.updateSelectedTotal();
            console.log(`Item ${this.idProduk} selected:`, this.selected);
        }
    };
}
