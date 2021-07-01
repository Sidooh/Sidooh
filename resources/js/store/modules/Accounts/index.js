import AccountService from '../../../services/account';
import logger from "../../../helpers/logger";

const initialState = {
    all: [],
    balances: {},
    earnings: {},
    myTotalEarnings: 0,
    myEarnings: 0,
    myInviteEarnings: 0,
    loading: false,
    query: {sort: 'id', order: 'desc', group: 'y', type: 'PAYMENT'},
    states: ['active'],
}

const state = initialState;

const getters = {
    data: state => {
        let rows = state.all
        //
        if (state.query.sort) {
            rows = _.orderBy(state.all, state.query.sort, state.query.order)
        }
        //
        // return rows.slice(state.query.offset, state.query.offset + state.query.limit)

        // rows = rows.filter(item => item.type === state.query.type)

//    Filter data by status
//         rows = rows.filter(item => state.states.includes(item.status))

        return rows
    },

    balances: state => state.balances,

    voucherBalance: state => state.balances.voucher.balance,

    chartData: state => state.chartData,

    query: state => state.query,
    total: state => state.all.length,
    loading: state => state.loading,
}

const actions = {
    async getAccountBalances({commit}) {
        commit('LOADING', true)

        try {
            const response = await AccountService.balances();

            commit('ACCOUNT_BALANCES_SUCCESS', response.data);
            return Promise.resolve(response.data);

        } catch (e) {

            if (e.status === 422) {
                commit('ACCOUNT_BALANCES_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
            }

        }

        commit('LOADING', false)
    },

    async getEarningsSummary({commit}) {
        commit('LOADING', true)

        try {
            const response = await AccountService.earningsSummary();

            commit('EARNINGS_SUCCESS', response.data);
            commit('LOADING', false)
            return Promise.resolve(response.data);

        } catch (e) {

            commit('EARNINGS_FAILURE', e.data.errors ?? e.data.error);
            commit('LOADING', false)
            return Promise.reject(e.data);

        }

    },

    // processChartData({commit, state}) {
    //     let data = []
    //
    //     //    Get Y, M, D attributes first
    //     state.all.forEach(item => {
    //         const x = _.pick(item, 'id', 'status', 'created_at')
    //
    //         const splitDateTime = x.created_at.split(' ')
    //         const splitDate = splitDateTime[0]
    //         const splitTime = splitDateTime[1]
    //
    //         x.year = splitDate.split('-')[0]
    //         x.month = splitDate.split('-')[1]
    //         x.day = splitDate.split('-')[2]
    //         x.hour = splitTime.split(':')[0]
    //         x.fullMonth = new Date(x.created_at).toLocaleString('default', {month: 'long'})
    //
    //         data.push(x)
    //     })
    //
    //     logger.log(data)
    //
    //
    //     //    Filter data by type
    //     // data = data.filter(item => item.type === state.query.type)
    //
    //     //    Filter data by status
    //     data = data.filter(item => state.states.includes(item.status))
    //
    //     //    Group data by d,m,y and perform sum and count
    //     // TODO: For the below code can it be added to a utils module?
    //     var resultArr = [];
    //     var dateArr = [];
    //
    //     // TODO: Should we filter this month or last 30 days? similar to day and year....
    //     let dateFilter = null
    //     let currentYear = new Date().getFullYear()
    //     let currentMonth = new Date().getMonth() + 1
    //     let currentDay = new Date().getDay()
    //
    //     logger.log(data, currentYear)
    //
    //     // TODO: Should we limit to year for accounts?
    //
    //     // switch (state.query.group) {
    //     //     case 'y':
    //     dateFilter = 'fullMonth'
    //     //         data = data.filter(item => item.year == currentYear)
    //     //         break
    //     //     case 'm':
    //     //         dateFilter = 'day'
    //     //         data = data.filter(item => item.year == currentYear && item.month == currentMonth)
    //     //         break
    //     //     case 'd':
    //     //         dateFilter = 'hour'
    //     //         data = data.filter(item => item.year == currentYear && item.month == currentMonth && item.year == currentDay)
    //     //         break
    //     // }
    //
    //     data.forEach(item => {
    //         var date = item[dateFilter];
    //
    //         var index = dateArr.indexOf(date);
    //         if (index == -1) {
    //             dateArr.push(date);
    //             var obj = {date: date, count: 1};
    //             resultArr.push(obj);
    //         } else {
    //             resultArr[index].count += 1;
    //         }
    //     });
    //     logger.log(data)
    //
    //     commit('ACCOUNT_UPDATE_CHART_DATA', resultArr);
    // },

    setQuery({commit}, value) {
        commit('SET_QUERY', purify(value))
    },

    resetState({commit}) {
        commit('RESET_STATE')
    }
}

const mutations = {
    ACCOUNT_BALANCES_SUCCESS(state, accounts) {
        state.balances = accounts;
        state.errors = {};
    },
    ACCOUNT_BALANCES_FAILURE(state, errors) {
        state.balances = null;
        state.errors = errors;
    },
    ACCOUNT_UPDATE_CHART_DATA(state, data) {
        state.chartData = data;
    },
    EARNINGS_SUCCESS(state, account) {
        state.earnings = account.earnings;
        state.myTotalEarnings = account.total_earnings
        state.myEarnings = account.self_earnings
        state.myInviteEarnings = account.referral_earnings
        state.errors = {};
    },
    EARNINGS_FAILURE(state, errors) {
        state.earnings = null;
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
