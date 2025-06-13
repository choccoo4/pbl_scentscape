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

            // Langsung daftar ke rootRef
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

            // update di frontend
            if (this.rootRef && this.index !== null) {
                // Update item di root juga
                this.rootRef.cartItems[this.index].quantity = this.quantity;
                this.rootRef.cartItems[this.index].total = this.total;

                // Update total & selectedTotal
                this.rootRef.updateTotal();

                // Kalau item ini dicentang, update selectedTotal juga
                if (this.selected) {
                    this.rootRef.updateSelectedTotal();
                }
            }

            // update ke backend
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
                    alert('Gagal update jumlah produk!');
                    console.error(err);
                });
        },

        removeItem() {
            if (!confirm('Yakin ingin menghapus item ini dari keranjang?')) return;

            fetch(`/cart/remove/${this.idProduk}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                }
            })
                .then(res => {
                    if (res.ok) {
                        // Remove from DOM
                        this.$el.remove();
                        // Update cartItems di root
                        if (typeof this.rootRef?.updateTotal === 'function') {
                            this.rootRef.cartItems.splice(this.index, 1);
                            this.rootRef.updateTotal();
                            this.rootRef.updateSelectedTotal();
                        }
                    } else {
                        alert('Gagal menghapus item dari keranjang!');
                    }
                })
                .catch(err => console.error('Remove error:', err));
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
