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

window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(Card);
Vue.use(VueRouter);

window.api = new Api();
window.auth = new Auth();
window.Event = new Vue();
window.auth = auth;

Vue.component('menuitems',require('./components/NavbarMenu.vue'));
Vue.component('navbarmenu', require('./components/NavbarMenu.vue'));
Vue.component('vue-layout', require('./Layout.vue'));

const app = new Vue({
    el: '#app',
    router

});
