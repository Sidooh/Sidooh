import AuthService from '../../services/auth';

const user = JSON.parse(localStorage.getItem('user'));

const initialState = user
    ? {isAuthenticated: true, user, errors: {}}
    : {isAuthenticated: false, user: null, errors: {}};


const state = initialState;

const getters = {
    isAuthenticated(state) {
        return state.isAuthenticated;
    },

    errors: state => state.errors
}

const actions = {
    async login({commit}, user) {
        try {
            const response = await AuthService.login(user);

            commit('LOGIN_SUCCESS', response.user);
            return Promise.resolve(response);

        } catch (e) {

            if (e.status === 422) {
                commit('LOGIN_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
            }

        }

    },

    logout({commit}) {
        AuthService.logout();
        commit('logout');
    },

    register({commit}, user) {
        return AuthService.register(user).then(
            response => {
                commit('registerSuccess');
                return Promise.resolve(response.data);
            },
            error => {
                commit('registerFailure');
                return Promise.reject(error);
            }
        );
    }
}

const mutations = {
    LOGIN_SUCCESS(state, user) {
        state.isAuthenticated = true;
        state.user = user;
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
