import Vue from "vue";
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

import {auth} from './modules/auth';

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
        auth
    },
    plugins: [createPersistedState()]
})

export default store;
