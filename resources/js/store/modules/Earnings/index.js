import EarningService from '../../../services/earning';
import logger from "../../../helpers/logger";

const initialState = {
    all: [],
    chartData: [],
    loading: false,
    query: {sort: 'id', order: 'desc', group: 'y', yearLimit: false},
    types: ['self', 'referral'],
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

    //TODO: What is the difference between this and data? Can data be used across?
    earnings: state => state.all.sort((a, b) => b.id - a.id),

    myEarnings: state => _.sum(state.all.filter(item => item.type === 'SELF').map(a => parseFloat(a.earnings))),
    myInviteEarnings: state => _.sum(state.all.filter(item => item.type === 'REFERRAL').map(a => parseFloat(a.earnings))),
    // myTotalEarnings: state => getters.myEarnings + getters.myInviteEarnings,

    chartData: state => state.chartData,

    query: state => state.query,
    total: state => state.all.length,
    loading: state => state.loading,
}

const actions = {
    async fetchData({commit, state}) {
        commit('LOADING', true)

        try {
            const response = await EarningService.all();

            commit('EARNING_INDEX_SUCCESS', response.data);
            return Promise.resolve(response.data);

        } catch (e) {

            if (e.status === 422) {
                commit('EARNING_INDEX_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
            }

        }

        commit('LOADING', false)
    },

    processChartData({commit, state}) {
        let data = []

        //    Get Y, M, D attributes first
        state.all.forEach(item => {
            const x = _.pick(item, 'id', 'type', 'earnings', 'created_at')

            const splitDateTime = x.created_at.split(' ')
            const splitDate = splitDateTime[0]
            const splitTime = splitDateTime[1]

            x.year = splitDate.split('-')[0]
            x.month = splitDate.split('-')[1]
            x.day = splitDate.split('-')[2]
            x.hour = splitTime.split(':')[0]
            x.fullMonth = new Date(x.created_at).toLocaleString('default', {month: 'long'})

            x.earnings = parseFloat(x.earnings).toFixed(4)
            data.push(x)
        })

        logger.log(data)
        data = _.orderBy(data, 'id', 'asc')


        //    Filter data by type
        // data = data.filter(item => item.type === state.query.type)

        //    Filter data by status
        data = data.filter(item => state.types.includes(item.type.toLowerCase()))

        //    Group data by d,m,y and perform sum and count
        // TODO: For the below code can it be added to a utils module?
        var resultArr = [];
        var dateArr = [];

        // TODO: Should we filter this month or last 30 days? similar to day and year....
        let dateFilter = null
        let currentYear = new Date().getFullYear()
        let currentMonth = new Date().getMonth() + 1
        let currentDay = new Date().getDate()

        // logger.log(data, currentDay)

        // TODO: Should we limit to year for earnings?

        if (state.query.yearLimit) {
            data = data.filter(item => item.year == currentYear)
        }

        switch (state.query.group) {
            case 'y':
                dateFilter = 'fullMonth'
                break
            case 'm':
                dateFilter = 'day'
                data = data.filter(item => item.month == currentMonth)
                break
            case 'd':
                dateFilter = 'hour'
                data = data.filter(item => item.month == currentMonth && item.day == currentDay)
                break
        }

        data.forEach(item => {

            let date;
            if (!state.query.yearLimit && state.query.group === 'y') {
                date = item[dateFilter] + ' ' + item.year;
            } else {
                date = item[dateFilter];
            }

            // logger.log(dateFilter, item[dateFilter], !state.query.yearLimit && state.query.group === 'y')
            // logger.log(date, state.query)

            const index = dateArr.indexOf(date);
            if (index == -1) {
                dateArr.push(date);
                const obj = {date: date, amount: item.earnings, count: 1};
                resultArr.push(obj);
            } else {
                resultArr[index].amount += item.earnings;
                resultArr[index].count += 1;
            }
        });
        // logger.log(data)

        commit('EARNING_UPDATE_CHART_DATA', resultArr);
    },

    setQuery({commit}, value) {
        commit('SET_QUERY', purify(value))
    },

    resetState({commit}) {
        commit('RESET_STATE')
    }
}

const mutations = {
    EARNING_INDEX_SUCCESS(state, earnings) {
        //TODO: Find out why the each parsing is not working below
        state.all = earnings;
        state.errors = {};
    },
    EARNING_INDEX_FAILURE(state, errors) {
        state.all = null;
        state.errors = errors;
    },
    EARNING_UPDATE_CHART_DATA(state, data) {
        state.chartData = data;
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
