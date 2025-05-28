import './bootstrap';
import 'flowbite';


import Alpine from 'alpinejs';
import { registerForm } from './regist.js';
import { loginForm } from './login.js';
import { cartRoot, cartItem } from './cart.js';
import './seller-dashboard-chart';
import './tambah-produk.js';



window.Alpine = Alpine;

Alpine.data('registerForm', registerForm);
Alpine.data('loginForm', loginForm);
Alpine.data('cartRoot', cartRoot);
Alpine.data('cartItem', cartItem);

Alpine.start();
