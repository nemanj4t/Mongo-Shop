
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vuex from 'vuex';
import StoreData from './store';
import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';


import categories from './components/CategoriesComponent';


require('./bootstrap');

window.Vue = require('vue');
Vue.use(VueRouter);



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(Vuex);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('categories', require('./components/CategoriesComponent.vue').default);
Vue.component('shopping-cart', require('./components/ShoppingCart.vue').default);
Vue.component('wish-list', require('./components/WishList.vue').default);
Vue.component('wish-list-index', require('./components/WishListIndex.vue').default);
Vue.component('product', require('./components/Product.vue').default);
Vue.component('products', require('./components/Products.vue').default);
Vue.component('admin-panel', require('./components/admin-components/AdminPanel.vue').default);
Vue.component('CategoryCreate', require('./components/admin-components/category/Create.vue').default);
Vue.component('ProductCreate', require('./components/admin-components/product/Create.vue').default);
Vue.component('CategoryManage', require('./components/admin-components/category/Manage.vue').default);
Vue.component('CategoryEdit', require('./components/admin-components/category/Edit.vue').default);
Vue.component('ProductManage', require('./components/admin-components/product/Manage.vue').default);
Vue.component('ProductEdit', require('./components/admin-components/product/Edit.vue').default);
Vue.component('UserManage', require('./components/admin-components/user/Manage.vue').default);
Vue.component('card-element', require('./components/checkout-components/CardElement.vue').default);
Vue.component('payment-form', require('./components/checkout-components/PaymentForm.vue').default);

const router = new VueRouter({
    routes
  });

Vue.use(router);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const store = new Vuex.Store(StoreData);

const app = new Vue({
    el: '#app',
    router,
    store
});
