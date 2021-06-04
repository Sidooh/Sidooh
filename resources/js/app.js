require('./bootstrap');

// window.Vue = require('vue');
window.purify = o => JSON.parse(JSON.stringify(o))

import Vue from "vue";
import VueRouter from "vue-router";
import CoreuiVue from '@coreui/vue';
import "@coreui/coreui/dist/css/coreui.css";
import {iconsSet as icons} from './assets/icons/icons.js';
import Notifications from 'vue-notification';
import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';

import router from "./router";
import store from "./store";
import App from './App';

Vue.use(VueRouter);
Vue.use(CoreuiVue);
Vue.use(Notifications);
Vue.use(VueTelInput, {
    defaultCountry: 'KE',
    onlyCountries: ['KE'],
    invalidMsg: 'Phone number does not match format required.',
    dropdownOptions: {
        showDialCodeInSelection: true,
    }

})

Vue.config.productionTip = false
Vue.config.performance = true

strict: process.env.NODE_ENV !== 'production'

const app = new Vue({
    el: '#app',
    router,
    store,
    icons,
    components: {App}
});
