@extends('layouts.seller')
@section('title', 'Edit Produk - Scentscape')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
<form
    x-data="editProduk(
        {{ Js::from(collect($produk->gambar ?? [])->map(fn($g) => Storage::url($g))) }},
        {{ Js::from(old('categories', $produkCategories ?? [])) }}
    )"
    action="{{ route('produk.update', $produk->no_produk) }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="max-w-3xl mx-auto p-6 bg-[#F6F1EB] rounded-2xl shadow-lg mt-6">
        <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2 text-[#3E3A39]">
            ✏️ Edit Produk
        </h2>

        <!-- Nama Produk -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}"
                class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]"
                placeholder="Masukkan nama produk" />
            @if($errors->has('nama_produk'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('nama_produk') }}</p>
            @endif
        </div>

        <!-- Deskripsi Produk -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Deskripsi Produk</label>
            <textarea rows="5" name="deskripsi"
                class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]"
                placeholder="Tulis deskripsi lengkap, termasuk karakter aroma (top, middle, base notes), kondisi pemakaian, dan lainnya...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            <p class="text-xs text-[#3E3A39] mt-1">Deskripsi akan ditampilkan sesuai format (paragraf, numbering, dll) yang diinput penjual.</p>
            @if($errors->has('deskripsi'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('deskripsi') }}</p>
            @endif
        </div>

        <!-- Label Kategori Gender -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Label Gender</label>
            <select name="label_kategori"
                class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]">
                <option value="" disabled {{ old('label_kategori', $produk->label_kategori) ? '' : 'selected' }}>Pilih Label Kategori</option>
                @foreach($labelKategoriList as $label)
                <option value="{{ $label }}" {{ old('label_kategori', $produk->label_kategori) == $label ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @if($errors->has('label_kategori'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('label_kategori') }}</p>
            @endif
        </div>

        <!-- Tipe Parfum -->
        <div class="mb-4">
            <label for="tipe_parfum" class="block text-sm font-medium text-[#3E3A39] mb-1">
                Tipe Produk
            </label>
            <select id="tipe_parfum" name="tipe_parfum"
                class="w-full border border-[#9BAF9A] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]">
                <option value="" disabled {{ old('tipe_parfum', $produk->tipe_parfum) ? '' : 'selected' }}>Pilih Tipe Parfum</option>
                <option value="Eau De Parfum (EDP)" {{ old('tipe_parfum', $produk->tipe_parfum) == 'Eau De Parfum (EDP)' ? 'selected' : '' }}>Eau De Parfum (EDP)</option>
                <option value="Eau De Toilette (EDT)" {{ old('tipe_parfum', $produk->tipe_parfum) == 'Eau De Toilette (EDT)' ? 'selected' : '' }}>Eau De Toilette (EDT)</option>
                <option value="Body Mist" {{ old('tipe_parfum', $produk->tipe_parfum) == 'Body Mist' ? 'selected' : '' }}>Body Mist</option>
                <option value="Cologne" {{ old('tipe_parfum', $produk->tipe_parfum) == 'Cologne' ? 'selected' : '' }}>Cologne</option>
                <option value="Perfume Oil" {{ old('tipe_parfum', $produk->tipe_parfum) == 'Perfume Oil' ? 'selected' : '' }}>Perfume Oil</option>
                <option value="Solid Perfume" {{ old('tipe_parfum', $produk->tipe_parfum) == 'Solid Perfume' ? 'selected' : '' }}>Solid Perfume</option>
            </select>
            @if($errors->has('tipe_parfum'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('tipe_parfum') }}</p>
            @endif
        </div>

        <!-- Volume -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Volume</label>
            <input type="text" name="volume" value="{{ old('volume', $produk->volume) }}"
                class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]"
                placeholder="contoh: 50ml" />
            @if($errors->has('volume'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('volume') }}</p>
            @endif
        </div>

        <!-- Harga -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Harga</label>
            <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}"
                class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]"
                placeholder="Masukkan harga produk" />
            @if($errors->has('harga'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('harga') }}</p>
            @endif
        </div>

        <!-- Kategori Aroma -->
        <div
            x-data="{
  selected: {{ Js::from(old('categories', $produkCategories ?? ['musk'])) }},
  showAromaForm: false,
  newAroma: ''
}"
            x-init="
  window.selected = selected;
  window.getAromaForm = () => $el;
  window.closeAromaForm = () => { showAromaForm = false; newAroma = ''; };"
            x-ref="modalAroma"
            class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-2">Kategori</label>
            <div class="flex flex-wrap gap-2">
                <button type="button" @click="showAromaForm = true"
                    class="w-8 h-8 rounded-full flex items-center justify-center bg-[#9BAF9A] text-white text-lg hover:bg-[#8DA089] shadow">
                    +
                </button>

                @foreach ($categories as $category)
                <button type="button"
                    @click="selected.includes('{{ $category }}') ? selected = selected.filter(i => i !== '{{ $category }}') : selected.push('{{ $category }}')"
                    :class="selected.includes('{{ $category }}') ? 'bg-[#9BAF9A] text-white' : 'bg-[#F6F1EB] text-[#3E3A39]'"
                    class="border border-[#9BAF9A] px-3 py-1 rounded-full text-sm">
                    {{ $category }}
                </button>
                @endforeach
            </div>

            <template x-for="item in selected" :key="item">
                <input type="hidden" name="categories[]" :value="item">
            </template>

            <div x-show="showAromaForm" @click.outside="showAromaForm = false"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
                <div class="bg-white rounded-xl shadow-lg p-6 w-80">
                    <h3 class="text-lg font-semibold text-[#3E3A39] mb-3">Tambah Aroma</h3>
                    <input type="text" id="inputAromaBaru" x-model="newAroma" placeholder="Contoh: Citrus Fresh"
                        class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 mb-4 focus:ring-[#9BAF9A] focus:outline-none">
                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            @click="newAroma = ''; showAromaForm = false;"
                            class="px-4 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
                            Batal
                        </button>

                        <button type="button" id="simpanAroma"
                            class="px-4 py-1 rounded bg-[#9BAF9A] text-white hover:bg-[#8DA089]">Simpan</button>
                    </div>
                </div>
            </div>

            @if($errors->has('categories'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('categories') }}</p>
            @endif
        </div>

        <!-- Stok -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Stok</label>
            <input type="number" name="stok" min="0" value="{{ old('stok', $produk->stok) }}"
                class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]"
                placeholder="Masukkan jumlah stok tersedia" />
            @if($errors->has('stok'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('stok') }}</p>
            @endif
        </div>

        <!-- Gambar -->
        <div
            x-data="editProduk({{ Js::from(
        $produk->gambar 
            ? array_map(fn($g) => asset('storage/' . $g), $produk->gambar) 
            : []
    ) }})"
            class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Foto Produk</label>
            <input type="file" name="gambar[]" accept="image/*" multiple
                @change="updatePreview($event)" class="block w-full text-sm text-gray-600" />
            <!-- Error Message -->
            <p x-text="errorMessage" x-show="errorMessage"
                class="text-sm text-red-600 mt-1"></p>
            <!-- Preview Gambar -->
            <div class="flex flex-wrap gap-4 mt-4">
                <template x-for="(image, index) in images" :key="index">
                    <div class="relative w-24 h-24">
                        <img :src="image.url" alt="Preview" class="object-cover w-full h-full rounded-lg border border-[#D6C6B8]" />
                        <button type="button" @click="removeImage(index)" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">×</button>
                    </div>
                </template>
            </div>

            <!-- Hidden untuk gambar lama -->
            <input
                type="hidden"
                name="existing_gambar"
                x-bind:value="JSON.stringify(images.filter(i => i.isExisting).map(i => i.url.replace('{{ asset('storage') }}/', '')))">
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('produk.index') }}"
                class="px-6 py-2 rounded-lg bg-[#BFA6A0] text-white hover:bg-[#A89089] transition duration-200">Batal</a>
            <button type="submit"
                class="px-6 py-2 rounded-lg bg-[#9BAF9A] text-white hover:bg-[#8DA089] transition duration-200">Simpan</button>
        </div>
    </div>
</form>
@endsection