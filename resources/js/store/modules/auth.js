import AuthService from '../../services/auth';

const token = localStorage.getItem('token');

const initialState = token
    ? {authenticated: true, token, errors: {}, registrationStep: 1}
    : {authenticated: false, token: null, errors: {}, registrationStep: 1};


const state = initialState;

const getters = {
    isAuthenticated(state) {
        return state.authenticated && !!token;
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
    },

    reset({commit}) {
        commit('RESET_STATE')
    }
}

const mutations = {
    LOGIN_SUCCESS(state, data) {
        state.authenticated = true;
        // state.token = data.token;
        state.errors = {};
    },
    LOGIN_FAILURE(state, errors) {
        state.authenticated = false;
        state.token = null;
        state.errors = errors;
    },
    LOGOUT(state) {
        state.authenticated = false;
        state.token = null;
    },
    REGISTER_CHECK_PHONE_SUCCESS(state) {
        // state.isAuthenticated = false;
    },
    REGISTER_CHECK_PHONE_FAILURE(state) {
        state.authenticated = false;
    },
    REGISTER_SUCCESS(state) {
        state.authenticated = false;
    },
    REGISTER_FAILURE(state) {
        state.authenticated = false;
    },
    RESET_STATE(state) {
        state = Object.assign(state, initialState)
    }
}


export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
