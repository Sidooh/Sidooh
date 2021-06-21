import PurchaseService from '../../../services/purchase';
import Vue from "vue";

const initialState = {
    all: [],
    status: {},
    loading: false,
    errors: {},
    states: ['completed', 'success'],
}

const state = initialState;

const getters = {
    data: state => {
        let rows = state.all
        //
        // if (state.query.sort) {
        //     rows = _.orderBy(state.all, state.query.sort, state.query.order)
        // }
        //
        // return rows.slice(state.query.offset, state.query.offset + state.query.limit)

        rows = rows.filter(item => item.type === state.query.type)

//    Filter data by status
        rows = rows.filter(item => state.states.includes(item.status))

        return rows
    },

    status: state => state.status,

    errors: state => state.errors,

    query: state => state.query,
    total: state => state.all.length,
    loading: state => state.loading,
}

const actions = {
    async buyAirtime({commit}, form) {
        commit('LOADING', true)

        try {
          const response = await PurchaseService.airtime(form);

          commit('PURCHASE_SUCCESS', response);

          commit('LOADING', false)
          return Promise.resolve(response);

        } catch (e) {

          if (e.status === 422) {
            commit('PURCHASE_FAILURE', e.data.errors ?? e.data.error);
            return Promise.reject(e.data);
          }

          commit('LOADING', false)
          return Promise.reject(e);
        }

    },

    async checkAirtimeStatus({commit}, transactionId) {
        commit('LOADING', true)

        try {
            const response = await PurchaseService.airtimeStatus(transactionId);

            commit('PURCHASE_STATUS_SUCCESS', response.data);
            return Promise.resolve(response.data);

        } catch (e) {

            if (e.status === 422) {
                commit('PURCHASE_STATUS_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
            }

            if (e.status === 404) {
                commit('PURCHASE_STATUS_FAILURE', 'Not Found');
                // TODO: Is this necessary?
                // Vue.swal({
                //     title: 'Not Found',
                //     text: "The record was not found.",
                //     icon: 'warning',
                // });
            }

        }

        commit('LOADING', false)
    },

    async buyVoucher({commit}, form) {
        commit('LOADING', true)

        try {
            const response = await PurchaseService.voucher(form);

            commit('PURCHASE_SUCCESS', response);
            return Promise.resolve(response);

        } catch (e) {

            if (e.status === 422) {
                commit('PURCHASE_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
            }

        }

        commit('LOADING', false)

        return Promise.reject();
    },

    async checkVoucherStatus({commit}, transactionId) {
        commit('LOADING', true)

        try {
            const response = await PurchaseService.voucherStatus(transactionId);

            commit('PURCHASE_STATUS_SUCCESS', response.data);
            return Promise.resolve(response.data);

        } catch (e) {

            if (e.status === 422) {
                commit('PURCHASE_STATUS_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
            }

            if (e.status === 404) {
                commit('PURCHASE_STATUS_FAILURE', 'Not Found');
            }

        }

        commit('LOADING', false)
    },

    setQuery({commit}, value) {
        commit('SET_QUERY', purify(value))
    },

    resetState({commit}) {
        commit('RESET_STATE')
    }
}

const mutations = {
    PURCHASE_SUCCESS(state, purchases) {
        state.all = purchases;
        state.errors = {};
    },
    PURCHASE_FAILURE(state, errors) {
        state.all = null;
        state.errors = errors;
    },
    PURCHASE_STATUS_SUCCESS(state, purchases) {
        state.status = purchases;
        state.errors = {};
    },
    PURCHASE_STATUS_FAILURE(state, errors) {
        state.status = null;
        state.errors = errors;
    },
    LOADING(state, loading) {
        state.loading = loading
    },
    SET_QUERY(state, query) {
        state.query = query
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
