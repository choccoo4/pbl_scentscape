import './bootstrap';
import 'flowbite';

import Alpine from 'alpinejs';
import { registerForm } from './auth/regist.js';
import { loginForm } from './auth/login.js';
import { confirmLogout } from './auth/logout';
import { cartRoot, cartItem } from './buyer/cart.js';
import { previewImages } from './seller/produk-preview.js';
import { editProduk } from './seller/edit-produk.js';
import { forgotAlert } from './auth/forgot.js';
import { resetAlert } from './auth/reset.js';
import { confirmLogoutSeller } from './seller/logout.js';

import './seller/seller-dashboard-chart';
import './seller/aroma.js';
import './seller/produk.js';
import './buyer/profile.js';
import './buyer/product-card.js';
import './seller/profile-penjual.js';

window.forgotAlert = forgotAlert;
window.resetAlert = resetAlert;
window.confirmLogoutSeller = confirmLogoutSeller;



window.Alpine = Alpine;
window.confirmLogout = confirmLogout;

Alpine.data('registerForm', registerForm);
Alpine.data('loginForm', loginForm);
Alpine.data('confirmLogout', confirmLogout);
Alpine.data('cartRoot', cartRoot);
Alpine.data('cartItem', cartItem);
Alpine.data('previewImages', previewImages);
Alpine.data('editProduk', editProduk);


Alpine.start();
