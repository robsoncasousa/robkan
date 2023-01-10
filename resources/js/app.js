import VueJSModal from "vue-js-modal";

require('./bootstrap');
import Vue from 'vue';

require('vue-js-modal')

Vue.use(VueJSModal)
Vue.component('v-header', require('./components/Header.vue').default);

window.Vue = require('vue');

import router from "./router";

const app = new Vue({
    el: '#app',
    router,
});
