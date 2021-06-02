import TransactionService from '../../../services/transaction';

const initialState = {
    all: [],
    loading: false,
    query: {sort: 'id', order: 'desc', group: 'd', type: 'PAYMENT'},
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

        return rows
    },

    query: state => state.query,
    total: state => state.all.length,
    loading: state => state.loading,
}

const actions = {
    async fetchData({commit, state}) {
        commit('LOADING', true)

        try {
            const response = await TransactionService.all();

            commit('TRANSACTION_INDEX_SUCCESS', response.data);
            return Promise.resolve(response.data);

        } catch (e) {

            if (e.status === 422) {
                commit('TRANSACTION_INDEX_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
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
    TRANSACTION_INDEX_SUCCESS(state, transactions) {
        state.all = transactions;
        state.errors = {};
    },
    TRANSACTION_INDEX_FAILURE(state, errors) {
        state.all = null;
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
