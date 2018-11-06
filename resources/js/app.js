
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import { Card } from 'bootstrap-vue/es/components';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

Vue.use(Card);

window.Vue = require('vue');

Vue.component('menuitems', require('./components/MenuItems.vue'));

const app = new Vue({
    el: '#app',
    data: {
        items:[],
    }

});
