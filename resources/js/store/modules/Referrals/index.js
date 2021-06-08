import ReferralService from '../../../services/referral';

const initialState = {
    all: [],
    chartData: [],
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

    activeReferrals: state => {
        return state.all.filter(item => state.states.includes(item.status))
    },

    chartData: state => state.chartData,

    query: state => state.query,
    total: state => state.all.length,
    loading: state => state.loading,
}

const actions = {
    async fetchData({commit, state}) {
        commit('LOADING', true)

        try {
            const response = await ReferralService.all();

            commit('REFERRAL_INDEX_SUCCESS', response.data);
            return Promise.resolve(response.data);

        } catch (e) {

            if (e.status === 422) {
                commit('REFERRAL_INDEX_FAILURE', e.data.errors ?? e.data.error);
                return Promise.reject(e.data);
            }

        }

        commit('LOADING', false)
    },

    processChartData({commit, state}) {
        let data = []

        //    Get Y, M, D attributes first
        state.all.forEach(item => {
            const x = _.pick(item, 'id', 'status', 'created_at')

            const splitDateTime = x.created_at.split(' ')
            const splitDate = splitDateTime[0]
            const splitTime = splitDateTime[1]

            x.year = splitDate.split('-')[0]
            x.month = splitDate.split('-')[1]
            x.day = splitDate.split('-')[2]
            x.hour = splitTime.split(':')[0]
            x.fullMonth = new Date(x.created_at).toLocaleString('default', {month: 'long'})

            data.push(x)
        })

        console.log(data)


        //    Filter data by type
        // data = data.filter(item => item.type === state.query.type)

        //    Filter data by status
        data = data.filter(item => state.states.includes(item.status))

        //    Group data by d,m,y and perform sum and count
        // TODO: For the below code can it be added to a utils module?
        var resultArr = [];
        var dateArr = [];

        // TODO: Should we filter this month or last 30 days? similar to day and year....
        let dateFilter = null
        let currentYear = new Date().getFullYear()
        let currentMonth = new Date().getMonth() + 1
        let currentDay = new Date().getDay()

        console.log(data, currentYear)

        // TODO: Should we limit to year for referrals?

        // switch (state.query.group) {
        //     case 'y':
        dateFilter = 'fullMonth'
        //         data = data.filter(item => item.year == currentYear)
        //         break
        //     case 'm':
        //         dateFilter = 'day'
        //         data = data.filter(item => item.year == currentYear && item.month == currentMonth)
        //         break
        //     case 'd':
        //         dateFilter = 'hour'
        //         data = data.filter(item => item.year == currentYear && item.month == currentMonth && item.year == currentDay)
        //         break
        // }

        data.forEach(item => {
            var date = item[dateFilter];

            var index = dateArr.indexOf(date);
            if (index == -1) {
                dateArr.push(date);
                var obj = {date: date, count: 1};
                resultArr.push(obj);
            } else {
                resultArr[index].count += 1;
            }
        });
        console.log(data)

        commit('REFERRAL_UPDATE_CHART_DATA', resultArr);
    },

    setQuery({commit}, value) {
        commit('SET_QUERY', purify(value))
    },

    resetState({commit}) {
        commit('RESET_STATE')
    }
}

const mutations = {
    REFERRAL_INDEX_SUCCESS(state, referrals) {
        state.all = referrals;
        state.errors = {};
    },
    REFERRAL_INDEX_FAILURE(state, errors) {
        state.all = null;
        state.errors = errors;
    },
    REFERRAL_UPDATE_CHART_DATA(state, data) {
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
