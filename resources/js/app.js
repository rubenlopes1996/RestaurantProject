/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import {
    Card
} from 'bootstrap-vue/es/components';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import router from './routes.js';
import VueRouter from 'vue-router';
import Auth from './auth.js';
import Api from './api.js';
import {
    ServerTable,
    ClientTable,
    Event
} from 'vue-tables-2';
import {
    VueSpinners
} from '@saeris/vue-spinners';

window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(Card);
Vue.use(VueRouter);
Vue.use(ClientTable);
Vue.use(VueSpinners);

window.api = new Api();
window.auth = new Auth();
window.Event = new Vue();
window.auth = auth;

Vue.component('menuitems', require('./components/NavbarMenu.vue'));
Vue.component('navbarmenu', require('./components/NavbarMenu.vue'));
Vue.component('vue-layout', require('./Layout.vue'));
Vue.component('manager-list', require('./components/employee/EmployeeList.vue'));
Vue.component('user-edit', require('./components/employee/editEmployee.vue'));
Vue.component('add-employee', require('./components/employee/AddEmployee.vue'));
Vue.component('list-orders', require('./components/cooks/ListOrders.vue'));
Vue.component('list-invoices', require('./components/cashiers/InvoiceList.vue'));

const app = new Vue({
    el: '#app',
    router
});
