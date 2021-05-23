import {BASE_URL} from "./constants";

require('./bootstrap');

// window.Vue = require('vue');

import Vue from "vue";
import VueRouter from "vue-router";
import CoreuiVue from '@coreui/vue';
import "@coreui/coreui/dist/css/coreui.css";
import {iconsSet as icons} from './assets/icons/icons.js';
import axios from 'axios';

import router from "./router";
import store from "./store";
import App from './App';

Vue.use(VueRouter);
Vue.use(CoreuiVue);

axios.defaults.withCredentials = true
axios.defaults.baseURL = BASE_URL;
axios.interceptors.response.use(
    (response) => {
        return response;
    },
    function (error) {
        if (error.response.status === 401 || error.response.status === 419) {
            store.dispatch("auth/logout");
            return router.push('/login')
        }


        if (error.response.status === 422) {
            //TODO: Add error global alert
            console.log(error)
        }

        return Promise.reject(error.response);

        // if (error) {
        //     const originalRequest = error.config;
        //     if (error.response.status === 401 && !originalRequest._retry) {
        //
        //         originalRequest._retry = true;
        //         store.dispatch('LogOut')
        //         return router.push('/login')
        //     }
        // }
    })

Vue.config.productionTip = false

const app = new Vue({
    el: '#app',
    router,
    store,
    icons,
    components: {App}
});
