import Vue from "vue";
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

import auth from './modules/auth';
import {loader} from "./modules/loader";
import TransactionsIndex from "./modules/Transactions";
import ReferralsIndex from "./modules/Referrals";
import EarningsIndex from "./modules/Earnings";
import Purchases from "./modules/Purchases";
import Accounts from "./modules/Accounts";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        sidebarShow: 'responsive',
        sidebarMinimize: false
    },
    mutations: {
        toggleSidebarDesktop(state) {
            const sidebarOpened = [true, 'responsive'].includes(state.sidebarShow)
            state.sidebarShow = sidebarOpened ? false : 'responsive'
        },
        toggleSidebarMobile(state) {
            const sidebarClosed = [false, 'responsive'].includes(state.sidebarShow)
            state.sidebarShow = sidebarClosed ? true : 'responsive'
        },
        set(state, [variable, value]) {
            state[variable] = value
        }
    },
    actions: {},

    modules: {
        auth,
        loader,
        TransactionsIndex,
        ReferralsIndex,
        EarningsIndex,
        Purchases,
        Accounts,
    },
    plugins: [createPersistedState()],
    strict: process.env.NODE_ENV !== 'production',
})

export default store;
