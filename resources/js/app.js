require('./bootstrap');

// window.Vue = require('vue');

import Vue from "vue";
import VueRouter from "vue-router";
import CoreuiVue from '@coreui/vue';
import "@coreui/coreui/dist/css/coreui.css";
import {iconsSet as icons} from './assets/icons/icons.js';
import Notifications from 'vue-notification';

import router from "./router";
import store from "./store";
import App from './App';

Vue.use(VueRouter);
Vue.use(CoreuiVue);
Vue.use(Notifications);

Vue.config.productionTip = false

const app = new Vue({
    el: '#app',
    router,
    store,
    icons,
    components: {App}
});
