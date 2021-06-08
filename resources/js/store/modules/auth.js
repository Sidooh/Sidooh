import AuthService from '../../services/auth';

const token = localStorage.getItem('token');
const account = localStorage.getItem('token');

const initialState = token
    ? {isAuthenticated: true, token, errors: {}, registrationStep: 1}
    : {isAuthenticated: false, token: null, errors: {}, registrationStep: 1};


const state = initialState;

const getters = {
    isAuthenticated(state) {
        return state.isAuthenticated;
    },

    errors: state => state.errors,

    registrationStep: state => state.registrationStep,

    user: state => state.user
}

const actions = {
    setRegistrationStep({state}, step) {
        state.registrationStep = step
    },

    async login({commit}, user) {
        try {
            const response = await AuthService.login(user);

            commit('LOGIN_SUCCESS', response);
            return Promise.resolve(response);

        } catch (e) {

            if (e.status === 422) {
                commit('LOGIN_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
            }

        }

    },

    async logout({commit}) {
        await AuthService.logout();
        commit('LOGOUT');
    },

    registerCheckPhone({commit}, phone) {
        return AuthService.registerCheckPhone(phone).then(
            response => {
                commit('REGISTER_CHECK_PHONE_SUCCESS');
                return Promise.resolve(response.data);
            },
            error => {
                commit('REGISTER_CHECK_PHONE_FAILURE');
                return Promise.reject(error);
            }
        );
    },

    register({commit}, user) {
        return AuthService.register(user).then(
            response => {
                commit('REGISTER_SUCCESS');
                return Promise.resolve(response.data);
            },
            error => {
                commit('REGISTER_FAILURE');
                return Promise.reject(error);
            }
        );
    }
}

const mutations = {
    LOGIN_SUCCESS(state, data) {
        state.isAuthenticated = true;
        state.user = data.user;
        state.errors = {};
    },
    LOGIN_FAILURE(state, errors) {
        state.isAuthenticated = false;
        state.user = null;
        state.errors = errors;
    },
    LOGOUT(state) {
        state.isAuthenticated = false;
        state.user = null;
    },
    REGISTER_CHECK_PHONE_SUCCESS(state) {
        // state.isAuthenticated = false;
    },
    REGISTER_CHECK_PHONE_FAILURE(state) {
        state.isAuthenticated = false;
    },
    REGISTER_SUCCESS(state) {
        state.isAuthenticated = false;
    },
    REGISTER_FAILURE(state) {
        state.isAuthenticated = false;
    }
}


export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
