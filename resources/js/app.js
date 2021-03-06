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
import 'bootstrap/dist/css/bootstrap.min.css';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import router from './routes.js';
import VueRouter from 'vue-router';
import 'vue-img-inputer/dist/index.css';
import {
    ClientTable
} from 'vue-tables-2';
import {
    VueSpinners
} from '@saeris/vue-spinners';
import VueFeatherIcon from 'vue-feather-icon';
import store from './vuex.js';
import Toasted from 'vue-toasted';
import Vuetify from 'vuetify';
import VueMoment from 'vue-moment';
import Vuelidate from 'vuelidate';
import Vuesax from 'vuesax';
import 'vuesax/dist/vuesax.css';
import VueSocketio from 'vue-socket.io';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'bootstrap/dist/css/bootstrap.css';
import datePicker from 'vue-bootstrap-datetimepicker'
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
 


window.Vue = require('vue');
Vue.use(BootstrapVue);
Vue.use(Card);
Vue.use(VueRouter);
Vue.use(ClientTable);
Vue.use(VueSpinners);
Vue.use(VueFeatherIcon);
Vue.use(Vuetify);
Vue.use(Vuelidate);
Vue.use(VueMoment);
Vue.use(Toasted);
Vue.use(Vuesax);
Vue.use(datePicker);
Vue.use(new VueSocketio({
    debug: true,
    connection: 'http://127.0.0.1:8080'
   }));
window.Event = new Vue();

Vue.component('navbarmenu', require('./components/NavbarMenu.vue'));
Vue.component('vue-layout', require('./Layout.vue'));
Vue.component('manager-list', require('./components/employee/EmployeeList.vue'));
Vue.component('user-edit', require('./components/employee/EditEmployee.vue'));
Vue.component('add-employee', require('./components/employee/AddEmployee.vue'));
Vue.component('table-list', require('./components/restaurant-table/RestaurantTableList.vue'));
Vue.component('list-orders', require('./components/cooks/ListOrders.vue'));
Vue.component('list-invoices', require('./components/cashiers/InvoiceList.vue'));
Vue.component('item-edit', require('./components/restaurant-menu/RestaurantMenuEdit.vue'));
Vue.component('item-add', require('./components/restaurant-menu/RestaurantMenuAdd.vue'));
Vue.component('item-list', require('./components/restaurant-menu/RestaurantMenuList.vue'));
Vue.component('paid-invoices', require('./components/cashiers/PaidInvoicesList.vue'));
Vue.component('all-invoices', require('./components/cashiers/AllInvoicesList.vue'));
Vue.component('invoice-payment', require('./components/cashiers/InvoicePayment.vue'));
Vue.component('table-edit', require('./components/restaurant-table/RestaurantTableEdit.vue'));
Vue.component('table-add', require('./components/restaurant-table/RestaurantTableAdd.vue'));
Vue.component('order-list',require('./components/cooks/ListOrders.vue'));
Vue.component('add_order', require('./components/waiters/AddOrder.vue'));
Vue.component('activate-account',require('./components/employee/activateAccount.vue'));

const app = new Vue({
    el: '#app',
    router,
    store,
    validations: {},
    created() {
        this.$store.commit('loadTokenAndUserFromSession');
    }
}).$mount('#app');

