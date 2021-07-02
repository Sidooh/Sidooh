require('./bootstrap')

// window.Vue = require('vue');
window.purify = o => JSON.parse(JSON.stringify(o))

import Vue from "vue"
import VueRouter from "vue-router"
import CoreuiVue from '@coreui/vue'
import "@coreui/coreui/dist/css/coreui.css"
import {iconsSet as icons} from './assets/icons/icons.js'
import Notifications from 'vue-notification'
import VueTelInput from 'vue-tel-input'
import 'vue-tel-input/dist/vue-tel-input.css'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import numeral from 'numeral'
import numFormat from 'vue-filter-number-format'


import router from "./router"
import store from "./store"
import App from './App'
import * as Sentry from "@sentry/vue"
import {Integrations} from "@sentry/tracing"

import helpers from './helpers'

Sentry.init({
    Vue,
    dsn: "https://ca625ff84c4546b68413a2b2f4f6737e@o802918.ingest.sentry.io/5831082",
    integrations: [new Integrations.BrowserTracing()],

    // Set tracesSampleRate to 1.0 to capture 100%
    // of transactions for performance monitoring.
    // We recommend adjusting this value in production
    tracesSampleRate: 1.0,
});

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
Vue.use(VueSweetalert2);
Vue.use(require('vue-moment'));
Vue.filter('numFormat', numFormat(numeral));

Vue.use(helpers)

Vue.config.productionTip = false
Vue.config.performance = true

// strict: process.env.NODE_ENV !== 'production'

window.addEventListener('unload', store.commit('loader/reset'))

const app = new Vue({
    el: '#app',
    router,
    store,
    icons,
    components: {App}
});
