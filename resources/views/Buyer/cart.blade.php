@extends('layouts.app')
@section('title', 'Cart - Scentscape')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
<div class="min-h-screen bg-[#F6F1EB] py-10 px-6 md:px-20">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-semibold text-center text-[#3E3A39] mb-8">Your Cart</h1>

        @if($cartItems->isEmpty())
        <div class="text-center py-12">
            <p class="text-xl text-[#3E3A39] mb-4">Keranjang Anda kosong</p>
            <a href="{{ route('home') }}" class="bg-[#414833] text-white px-6 py-3 rounded-lg hover:bg-[#00695C] transition-colors">
                Mulai Belanja
            </a>
        </div>
        @else
        <div x-data="cartRoot()" x-init="init()" class="space-y-6" x-ref="cartRoot">
            <p class="text-xl text-[#3E3A39] mb-4 font-medium">Select Products to Checkout</p>

            @foreach ($cartItems as $index => $item)
            <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all"
                x-data="cartItem({{ $item['price'] }}, {{ $item['quantity'] }}, '{{ $item['no_produk'] }}', {{ $item['stock'] }}, {{ $index }}, $refs.cartRoot)"
                x-init="init()">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Kiri: Checkbox, Gambar, Nama dan Harga -->
                    <div class="flex items-center gap-4 w-full sm:w-1/2">
                        <input type="checkbox" class="form-checkbox text-[#9BAF9A]" x-model="selected" @change="updateSelection()" />
                        <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}"
                            class="w-16 h-16 object-cover rounded-md border border-[#D6C6B8]">
                        <div>
                            <p class="text-base font-semibold text-[#3E3A39]">{{ $item['name'] }}</p>
                            <p class="text-sm text-[#6B7280]">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Kanan: Qty, Remove, dan Total -->
                    <div class="flex items-center justify-between gap-4 sm:gap-6 flex-wrap sm:flex-nowrap w-full sm:w-1/2">
                        <!-- Qty Controls -->
                        <div class="flex items-center space-x-2">
                            <button @click="decrease()" class="border border-[#9BAF9A] text-[#9BAF9A] px-2 py-1 rounded hover:bg-[#F6F1EB]"
                                :disabled="quantity <= 1">-</button>
                            <input type="number" min="1" :max="stock"
                                class="w-12 text-center border border-[#D6C6B8] rounded"
                                x-model.number="quantity"
                                @change.debounce.500ms="saveQuantity()" />
                            <button @click="increase()" class="border border-[#9BAF9A] text-[#9BAF9A] px-2 py-1 rounded hover:bg-[#F6F1EB]"
                                :disabled="quantity >= stock">+</button>
                        </div>

                        <!-- Remove -->
                        <form action="{{ route('cart.remove', $item['no_produk']) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-[#D6C6B8] hover:text-[#9BAF9A]">Remove</button>
                        </form>

                        <!-- Total per Item -->
                        <p class="text-base font-semibold text-[#3E3A39]">
                            Rp <span x-text="total"></span>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Grand Total -->
            <div class="flex flex-col sm:flex-row justify-between items-center bg-[#D6C6B8] p-6 rounded-lg shadow-lg mt-6 space-y-4 sm:space-y-0">
                <div class="text-center sm:text-left">
                    <p class="text-xl font-medium text-[#3E3A39]">
                        Total Keseluruhan:
                        <span class="font-semibold text-[#9BAF9A]">
                            Rp <span x-text="grandTotalFormatted">{{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </span>
                    </p>
                    <p class="text-sm text-[#3E3A39]">
                        Total yang dipilih:
                        <span class="font-medium">Rp <span x-text="selectedTotalFormatted">0</span></span>
                    </p>
                    <p class="text-sm text-[#3E3A39] mt-1">Shipping & taxes calculated at checkout</p>
                </div>
                <a href="/checkout" class="bg-[#414833] text-white px-8 py-3 text-lg font-medium hover:bg-[#00695C] transition-colors rounded-lg"
                    x-bind:class="{ 'opacity-50 cursor-not-allowed': selectedTotal <= 0 }"
                    @click="if(selectedTotal <= 0) { $event.preventDefault(); alert('Pilih produk terlebih dahulu!'); }">
                    Proceed to Checkout
                </a>
            </div>
            <div class="text-center mt-8 text-[#9BAF9A]">
                <p>"Every scent tells a story"</p>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Scripts --}}
<script>
    function cartRoot() {
        return {
            items: [],
            grandTotalFormatted: "{{ number_format($grandTotal, 0, ',', '.') }}",
            selectedTotal: 0,
            selectedTotalFormatted: '0',
            init() {
                this.items = [];
                setTimeout(() => {
                    this.calculateTotals();
                }, 100);
            },
            updateItem(index, quantity, price, selected = false) {
                this.items[index] = {
                    quantity,
                    price,
                    selected
                };
                this.calculateTotals();
            },
            updateSelection(index, selected) {
                if (this.items[index]) {
                    this.items[index].selected = selected;
                    this.calculateTotals();
                }
            },
            calculateTotals() {
                // Grand total (semua item)
                const grandTotal = this.items.reduce((sum, item) => {
                    if (!item) return sum;
                    return sum + (item.quantity * item.price);
                }, 0);
                this.grandTotalFormatted = grandTotal.toLocaleString('id-ID');

                // Selected total (hanya item yang dipilih)
                this.selectedTotal = this.items.reduce((sum, item) => {
                    if (!item || !item.selected) return sum;
                    return sum + (item.quantity * item.price);
                }, 0);
                this.selectedTotalFormatted = this.selectedTotal.toLocaleString('id-ID');
            }
        }
    }

    function cartItem(price, initialQuantity, no_produk, stock, index, rootRef) {
        return {
            price,
            quantity: initialQuantity,
            stock,
            selected: false,
            total: '',
            init() {
                this.updateTotal();
                rootRef.__x.$data.updateItem(index, this.quantity, this.price, this.selected);
            },
            increase() {
                if (this.quantity < this.stock) {
                    this.quantity++;
                    this.saveQuantity();
                }
            },
            decrease() {
                if (this.quantity > 1) {
                    this.quantity--;
                    this.saveQuantity();
                }
            },
            updateTotal() {
                this.total = (this.price * this.quantity).toLocaleString('id-ID');
            },
            updateSelection() {
                rootRef.__x.$data.updateSelection(index, this.selected);
            },
            saveQuantity() {
                fetch(`/cart/update/${no_produk}`, {
                    method: "PATCH",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        jumlah_produk: this.quantity
                    })
                }).then(res => {
                    if (res.ok) {
                        this.updateTotal();
                        rootRef.__x.$data.updateItem(index, this.quantity, this.price, this.selected);

                        // Show success message without reload
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Jumlah produk diperbarui.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal memperbarui jumlah produk.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }).catch(() => {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan pada server.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            }
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection