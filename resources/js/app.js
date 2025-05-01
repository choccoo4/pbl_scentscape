import './bootstrap';

import Alpine from 'alpinejs';
import { registerForm } from './regist.js';
import { loginForm } from './login.js';
import { cartRoot, cartItem } from './cart.js';




window.Alpine = Alpine;

Alpine.data('registerForm', registerForm);
Alpine.data('loginForm', loginForm);
Alpine.data('cartRoot', cartRoot);
Alpine.data('cartItem', cartItem);

Alpine.start();
