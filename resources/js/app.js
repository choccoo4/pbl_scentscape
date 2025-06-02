import './bootstrap';
import 'flowbite';


import Alpine from 'alpinejs';
import { registerForm } from './regist.js';
import { loginForm } from './login.js';
import { confirmLogout } from './logout';
import { cartRoot, cartItem } from './cart.js';
import { previewImages } from './produk-preview.js';
import { editProduk } from './edit-produk.js';
import './seller-dashboard-chart';
import './aroma.js';
import './produk.js';

window.Alpine = Alpine;

Alpine.data('registerForm', registerForm);
Alpine.data('loginForm', loginForm);
Alpine.data('confirmLogout', confirmLogout);
Alpine.data('cartRoot', cartRoot);
Alpine.data('cartItem', cartItem);
Alpine.data('previewImages', previewImages);
Alpine.data('editProduk', editProduk);


Alpine.start();
