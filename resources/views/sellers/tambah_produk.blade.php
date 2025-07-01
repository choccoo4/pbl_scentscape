@extends('layouts.seller')
@section('title', 'Add Product - Scentscape')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
<form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="max-w-3xl mx-auto p-6 bg-[#F6F1EB] rounded-2xl shadow-lg mt-6">
        <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2 text-[#3E3A39]">
            🎁 Add Product
        </h2>

        <!-- Product Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Product Name</label>
            <input type="text" name="nama_produk" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Enter product name" />
            @if($errors->has('nama_produk'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('nama_produk') }}</p>
            @endif
        </div>

        <!-- Product Description -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Product Description</label>
            <textarea rows="5" name="deskripsi" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Write full description, including scent character (top, middle, base notes), usage condition, and more..."></textarea>
            <p class="text-xs text-[#3E3A39] mt-1">The description will be displayed as entered (paragraph, list, etc.).</p>
            @if($errors->has('deskripsi'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('deskripsi') }}</p>
            @endif
        </div>

        <!-- Gender Label -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Gender Label</label>
            <select name="label_kategori" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]">
                <option value="" disabled selected>Select Gender Label</option>
                @foreach($labelKategoriList as $label)
                <option value="{{ $label }}">{{ $label }}</option>
                @endforeach
            </select>
            @if($errors->has('label_kategori'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('label_kategori') }}</p>
            @endif
        </div>

        <!-- Perfume Type -->
        <div class="mb-4">
            <label for="tipe_parfum" class="block text-sm font-medium text-[#3E3A39] mb-1">
                Product Type
            </label>
            <select id="tipe_parfum" name="tipe_parfum"
                class="w-full border border-[#9BAF9A] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]">
                <option value="" disabled selected>Select Perfume Type</option>
                <option value="Eau De Parfum (EDP)">Eau De Parfum (EDP)</option>
                <option value="Eau De Toilette (EDT)">Eau De Toilette (EDT)</option>
                <option value="Body Mist">Body Mist</option>
                <option value="Cologne">Cologne</option>
                <option value="Perfume Oil">Perfume Oil</option>
                <option value="Solid Perfume">Solid Perfume</option>
            </select>
            @if($errors->has('tipe_parfum'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('tipe_parfum') }}</p>
            @endif
        </div>

        <!-- Volume -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Volume</label>
            <input type="text" name="volume" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="e.g.: 50ml" />
            @if($errors->has('volume'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('volume') }}</p>
            @endif
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Price</label>
            <input type="number" name="harga" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Enter product price" />
            @if($errors->has('harga'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('harga') }}</p>
            @endif
        </div>

        <!-- Scent Category -->
        <div x-data="{
            selected: [],
            showAromaForm: false,
            newAroma: '',
            selectedKategori: '',
            categories: @js($categories),
            kategoriList: @js($kategoriList)
        }"
            x-init="
            window.selected = selected;
            window.getAromaForm = () => $el;
            window.closeAromaForm = () => { showAromaForm = false; newAroma = ''; };"
            x-ref="modalAroma"
            class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-2">Scent Category</label>
            <div class="flex flex-wrap gap-2">
                <!-- Button to add new scent -->
                <button type="button" @click="showAromaForm = true"
                    class="w-8 h-8 rounded-full flex items-center justify-center bg-[#9BAF9A] text-white text-lg hover:bg-[#8DA089] shadow">
                    +
                </button>

                <!-- All categories -->
                <template x-for="category in categories" :key="category">
                    <button type="button"
                        @click="selected.includes(category) ? selected = selected.filter(i => i !== category) : selected.push(category)"
                        :class="selected.includes(category) ? 'bg-[#9BAF9A] text-white' : 'bg-[#F6F1EB] text-[#3E3A39]'"
                        class="border border-[#9BAF9A] px-3 py-1 rounded-full text-sm"
                        x-text="category">
                    </button>
                </template>
            </div>

            <!-- Hidden inputs -->
            <template x-for="item in selected" :key="item">
                <input type="hidden" name="categories[]" :value="item">
            </template>

            <!-- Modal to add new scent -->
            <div x-show="showAromaForm" @click.outside="showAromaForm = false"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
                <div class="bg-white rounded-xl shadow-lg p-6 w-80">
                    <h3 class="text-lg font-semibold text-[#3E3A39] mb-3">Add New Scent</h3>
                    <input type="text" id="inputAromaBaru" x-model="newAroma" placeholder="Example: Citrus Fresh"
                        class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 mb-4 focus:ring-[#9BAF9A] focus:outline-none">
                    <select x-model="selectedKategori" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 mb-4">
                        <option value="">-- Select Main Category --</option>
                        <template x-for="kat in kategoriList" :key="kat.id">
                            <option :value="kat.id" x-text="kat.nama"></option>
                        </template>
                    </select>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="BatalSimpanAroma"
                            class="px-4 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</button>

                        <button type="button" id="simpanAroma"
                            class="px-4 py-1 rounded bg-[#9BAF9A] text-white hover:bg-[#8DA089]">Save</button>
                    </div>
                </div>
            </div>
            @if($errors->has('categories'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('categories') }}</p>
            @endif
        </div>

        <!-- Stock -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Stock</label>
            <input type="number" name="stok" min="0" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Enter available stock" />
            @if($errors->has('stok'))
            <p class="text-sm text-red-600 mt-1">{{ $errors->first('stok') }}</p>
            @endif
        </div>

        <!-- Images -->
        <div x-data="previewImages()" class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Product Images</label>
            <input type="file" name="gambar[]" multiple accept="image/*"
                @change="preview($event)"
                class="block w-full text-sm text-gray-600" />

            <p class="text-xs text-[#3E3A39] mt-1">Upload up to 4 images (max 2MB each)</p>

            @if($errors->has('gambar') || $errors->has('gambar.*'))
            <ul class="text-sm text-red-600 mt-1 space-y-1">
                @foreach ($errors->get('gambar') as $err)
                <li>{{ $err }}</li>
                @endforeach
                @foreach ($errors->get('gambar.*') as $fieldErrors)
                @foreach ($fieldErrors as $err)
                <li>{{ $err }}</li>
                @endforeach
                @endforeach
            </ul>
            @endif

            <template x-if="errorMessage">
                <p class="text-sm text-red-600 mt-1" x-text="errorMessage"></p>
            </template>

            <!-- Preview -->
            <div class="mt-4 flex flex-wrap gap-2">
                <template x-for="(image, index) in images" :key="index">
                    <div class="relative w-24 h-24 border rounded overflow-hidden group">
                        <img :src="image" alt="Preview" class="w-full h-full object-cover">
                        <button
                            type="button"
                            @click="removeImage(index)"
                            class="absolute top-1 right-1 bg-[#BFA6A0] text-white text-xs rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                            title="Remove image"><i class="fas fa-xmark"></i>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('produk.index') }}"
                class="px-6 py-2 rounded-lg bg-[#BFA6A0] text-white hover:bg-[#A89089] transition duration-200">Cancel</a>
            <button type="submit"
                class="px-6 py-2 rounded-lg bg-[#9BAF9A] text-white hover:bg-[#8DA089] transition duration-200">Save</button>
        </div>
    </div>
</form>
@endsection
