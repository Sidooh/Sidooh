<template>
    <div>

        <CRow>
            <CCol col="12">
                <h4 class="card-title">Invites</h4>
            </CCol>
            <CCol col="12" lg="3" sm="6">
                <CWidgetIcon
                    :header="todayActiveReferrals"
                    color="gradient-primary"
                    text="Today"
                >
                </CWidgetIcon>
            </CCol>
            <CCol col="12" lg="3" sm="6">
                <CWidgetIcon
                    :header="last7DaysActiveReferrals"
                    color="gradient-secondary"
                    text="Past 7 days"
                >
                </CWidgetIcon>
            </CCol>
            <CCol col="12" lg="3" sm="6">
                <CWidgetIcon
                    :header="last30DaysActiveReferrals"
                    color="gradient-info"
                    text="Past 30 days"
                >
                </CWidgetIcon>
            </CCol>
            <CCol col="12" lg="3" sm="6">
                <CWidgetIcon
                    :header="totalActiveReferrals"
                    color="gradient-warning"
                    text="Total"
                >
                </CWidgetIcon>
            </CCol>
        </CRow>


        <CRow>
            <CCol col="12">
                <h4 class="card-title">Earnings</h4>
            </CCol>
            <CCol col="12" lg="3" sm="6">
                <CWidgetIcon
                    :header="todayEarnings | numFormat('0,0.00')"
                    color="gradient-primary"
                    text="Today"
                >
                </CWidgetIcon>
            </CCol>
            <CCol col="12" lg="3" sm="6">
                <CWidgetIcon
                    :header="last7DaysEarnings | numFormat('0,0.00')"
                    color="gradient-secondary"
                    text="Past 7 days"
                >
                </CWidgetIcon>
            </CCol>
            <CCol col="12" lg="3" sm="6">
                <CWidgetIcon
                    :header="last30DaysEarnings | numFormat('0,0.00')"
                    color="gradient-info"
                    text="Past 30 days"
                >
                </CWidgetIcon>
            </CCol>
            <CCol col="12" lg="3" sm="6">
                <CWidgetIcon
                    :header="totalEarnings | numFormat('0,0.00')"
                    color="gradient-warning"
                    text="Total"
                >
                </CWidgetIcon>
            </CCol>
        </CRow>

        <CCard>
            <CCardBody>
                <CRow>
                    <CCol class="col-sm-5">
                        <h4 class="card-title mb-0">Transactions Summary</h4>
                        <div class="small text-muted">{{
                                transactionsQuery.group === 'd' ? 'Transactions done today' : (transactionsQuery.group === 'm' ? 'Transactions done this month' : 'Transactions done this year')
                            }}
                        </div>
                    </CCol>
                    <CCol class="d-none d-md-block col-sm-7">
                        <button class="btn float-right btn-primary" disabled @click="reloadChart">
                            <CIcon name="cil-reload"/>
                        </button>
                        <CButtonGroup class="float-right mr-3 btn-group">
                            <CButton class="btn mx-0 btn-outline-secondary"
                                     v-bind:class="[ transactionsQuery.group === 'd' ? 'active' : '' ]"
                                     @click="groupTransactions('d')">
                                Day
                            </CButton>
                            <button class="btn mx-0 btn-outline-secondary"
                                    v-bind:class="[ transactionsQuery.group === 'm' ? 'active' : '' ]"
                                    @click="groupTransactions('m')">
                                Month
                            </button>
                            <button class="btn mx-0 btn-outline-secondary"
                                    v-bind:class="[ transactionsQuery.group === 'y' ? 'active' : '' ]"
                                    @click="groupTransactions('y')">
                                Year
                            </button>
                        </CButtonGroup>
                    </CCol>
                </CRow>

                <CChartLine :datasets="datasets" :labels="chartLabels" :options="options"
                            style="height: 300px; margin-top: 40px;"/>

            </CCardBody>
            <CCardFooter>
                <CRow class="text-center">
                    <CCol sclass="mb-sm-2 mb-0 col-sm-12 col-md">
                        <div class="text-muted">Total Transactions</div>
                        <strong>{{ totalTransactions }}</strong> <span
                        title="Today's Transactions">({{ totalTransactionsToday }})</span>
                        <CProgress
                            :precision="1"
                            :value="totalTransactionsToday"
                            class="progress-xs mt-2"
                            color="success"
                        />
                    </CCol>
                    <CCol sclass="mb-sm-2 mb-0 col-sm-12 col-md">
                        <div class="text-muted">Total Amounts</div>
                        <strong>{{ totalAmount | numFormat('0,0.00') }}</strong> <span title="Today's Transactions">({{
                            totalAmountToday | numFormat('0,0.00')
                        }})</span>
                        <CProgress
                            :precision="1"
                            :value="totalAmountToday"
                            class="progress-xs mt-2"
                            color="success"
                        />
                    </CCol>
                </CRow>
            </CCardFooter>
        </CCard>

        <!--        <CRow>-->
        <!--            <CCol lg="3" sm="6">-->
        <!--                <CWidgetDropdown :header="totalActiveReferrals" color="primary" text="Invites">-->
        <!--                    &lt;!&ndash;                    <template #default>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                        <CDropdown&ndash;&gt;-->
        <!--                    &lt;!&ndash;                            color="transparent p-0"&ndash;&gt;-->
        <!--                    &lt;!&ndash;                            placement="bottom-end"&ndash;&gt;-->
        <!--                    &lt;!&ndash;                        >&ndash;&gt;-->
        <!--                    &lt;!&ndash;                            <template #toggler-content>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                                <CIcon name="cil-settings"/>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                            </template>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                            <CDropdownItem>Action</CDropdownItem>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                            <CDropdownItem>Another action</CDropdownItem>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                            <CDropdownItem>Something else here...</CDropdownItem>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                            <CDropdownItem disabled>Disabled action</CDropdownItem>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                        </CDropdown>&ndash;&gt;-->
        <!--                    &lt;!&ndash;                    </template>&ndash;&gt;-->
        <!--                    <template #footer>-->
        <!--                        <CChartLineSimple-->
        <!--                            :data-points="referralChartData"-->
        <!--                            :labels="referralChartLabels"-->
        <!--                            class="mt-3 mx-3"-->
        <!--                            label="Invites"-->
        <!--                            point-hover-background-color="primary"-->
        <!--                            pointed-->
        <!--                            style="height:70px"-->
        <!--                        />-->
        <!--                    </template>-->
        <!--                </CWidgetDropdown>-->
        <!--            </CCol>-->
        <!--        </CRow>-->

        <CCard>
            <CCardHeader>
                <slot name="header">
                    <CIcon name="cil-grid"/>
                    Recent Transactions
                </slot>
            </CCardHeader>
            <CCardBody>
                <CDataTable
                    :fields="fields"
                    :items="recentTransactions"
                    :items-per-page="8"
                    :pagination="{ doubleArrows: false, align: 'center'}"
                    clickable-rows
                    hover
                    items-per-page-select
                    sorter
                    striped
                    table-filter
                    @row-clicked="rowClicked"
                >
                    <template #status="data">
                        <td>
                            <CBadge :color="miscHelpers.getBadge(data.item.status)">
                                {{ data.item.status }}
                            </CBadge>
                        </td>
                    </template>
                </CDataTable>
            </CCardBody>
        </CCard>

        <!--        <h1>-->
        <!--            alksdasd-->
        <!--        </h1>-->
        <!--        <button class="btn" @click="$store.commit('INCREMENT')">INCREMENT</button>-->
    </div>
</template>

<script>
import {CChartLine} from '@coreui/vue-chartjs'
import {mapActions, mapGetters} from "vuex"
import CChartLineSimple from "../components/CChartLineSimple"

import miscHelpers from '../helpers/misc-helpers'

export default {
    name: "Home",

    components: {CChartLineSimple, CChartLine},
    data() {
        return {
            miscHelpers,
            fields: [
                {key: 'id', /*_style: { width: '40%'}*/},
                {key: 'type',},
                {key: 'description'},
                {key: 'amount',},
                {key: 'status'},
                {key: 'created_at',},
            ],

            options: {
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',

                        // grid line settings
                        grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },

                    },
                }
            },

        }
    },

    created() {

        this.fetchTransactions().then(() => {
            // TODO: If chart ends up null can we display no data instead of blank chart?
            this.processTransactionChartData()
        })
        // this.groupReferrals('y');
        this.fetchReferrals().then(() => {
            // this.processReferralChartData()
        })
        this.fetchEarnings()
    },

    destroyed() {
        //TODO: Maybe add this after setting up data persistence
        // this.resetState()
    },

    computed: {
        // ...mapState({
        //     count: state => state.count
        // }),
        ...mapGetters('TransactionsIndex', {
            transactions: 'data',
            transactionsChartData: 'chartData',
            transactionsQuery: 'query',
            transactionsTotal: "total",
            transactionsLoading: "loading"
        }),
        ...mapGetters('ReferralsIndex', {
            referrals: 'data',
            referralsChartData: 'chartData',
            activeReferrals: 'activeReferrals',
        }),
        ...mapGetters('EarningsIndex', {
            earnings: 'data',
        }),

        chartLabels() {
            return this.transactionsChartData.map(a => a.date)
        },
        chartData1() {
            return this.transactionsChartData.map(a => a.amount)
        },
        chartData2() {
            return this.transactionsChartData.map(a => a.count)
        },

        totalAmount() {
            return _.sum(this.transactions.map(a => a.amount))
        },
        totalAmountToday() {
            return _.sum(this.transactions.filter(item => this.isToday(new Date(item.created_at))).map(a => a.amount))
        },
        totalAmountThisMonth() {
            return _.sum(this.transactions.filter(item => this.isThisMonth(new Date(item.created_at))).map(a => a.amount))
        },

        todayTransactions() {
            return this.transactions.filter(item => this.isToday(new Date(item.created_at)))
        },

        totalTransactions() {
            return this.transactions.length
        },
        totalTransactionsToday() {
            return this.todayTransactions.length
        },
        totalTransactionsThisMonth() {
            return this.transactions.filter(item => this.isThisMonth(new Date(item.created_at))).length
        },

        recentTransactions() {
            return !_.isEmpty(this.todayTransactions) ?
                this.todayTransactions.sort((a, b) => b.id - a.id) :
                this.transactions.sort((a, b) => b.id - a.id)
        },

        todayActiveReferrals() {
            return this.activeReferrals.filter(item => this.isToday(new Date(item.updated_at))).length + ''
        },
        last7DaysActiveReferrals() {
            return this.activeReferrals.filter(item => this.isLast7Days(new Date(item.updated_at))).length + ''
        },
        last30DaysActiveReferrals() {
            return this.activeReferrals.filter(item => this.isLast30Days(new Date(item.updated_at))).length + ''
        },
        totalActiveReferrals() {
            return this.activeReferrals.length + ''
        },
        referralChartLabels() {
            return this.referralsChartData.map(a => a.date)
        },
        referralChartData() {
            return this.referralsChartData.map(a => a.count)
        },


        todayEarnings() {
            return _.sum(this.earnings.filter(item => this.isToday(new Date(item.created_at))).map(a => parseFloat(a.earnings))).toFixed(2)
        },
        last7DaysEarnings() {
            return _.sum(this.earnings.filter(item => this.isLast7Days(new Date(item.created_at))).map(a => parseFloat(a.earnings))).toFixed(2)
        },
        last30DaysEarnings() {
            return _.sum(this.earnings.filter(item => this.isLast30Days(new Date(item.created_at))).map(a => parseFloat(a.earnings))).toFixed(2)
        },
        totalEarnings() {
            return _.sum(this.earnings.map(a => parseFloat(a.earnings))).toFixed(2)
        },

        datasets() {
            return [
                {
                    data: this.chartData1,
                    backgroundColor: '#008',
                    borderColor: '#00c',
                    label: 'Amount',
                    fill: false,
                },

                {
                    data: this.chartData2,
                    backgroundColor: '#080',
                    borderColor: '#0c0',
                    label: 'Count',
                    fill: false,
                }
            ]
        }
    },


    methods: {
        ...mapActions('TransactionsIndex', {
            fetchTransactions: 'fetchData',
            processTransactionChartData: 'processChartData',
            setTransactionsQuery: 'setQuery',
            resetState: 'resetState'
        }),
        ...mapActions('ReferralsIndex', {
            fetchReferrals: 'fetchData',
            setReferralsQuery: 'setQuery',
            processReferralChartData: 'processChartData'
        }),
        ...mapActions('EarningsIndex', {
            fetchEarnings: 'fetchData',
        }),
        ...mapActions('loader', ['reset']),

        groupTransactions(e) {
            // const q = Object.assign({}, this.transactionsQuery, {group: e});

            // or
            const q = {...this.transactionsQuery, group: e}

            this.setTransactionsQuery(q);
            this.processTransactionChartData()
        },

        groupReferrals(e) {
            const q = Object.assign({}, this.referralsQuery, {group: e, yearLimit: false});

            // or
            // const q = {...this.transactionsQuery, { group: e} }

            this.setReferralsQuery(q);
            this.processReferralChartData()
        },

        reloadChart() {
            this.fetchTransactions().then(() => {
                this.processTransactionChartData()
            })
        },

        //TODO: Move the below to date helper
        isToday(someDate) {
            const today = new Date()
            return someDate.getDate() == today.getDate() &&
                someDate.getMonth() == today.getMonth() &&
                someDate.getFullYear() == today.getFullYear()
        },

        isLast7Days(someDate) {
            const sevenDaysAgo = new Date()
            sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7)

            return someDate >= sevenDaysAgo
        },

        isLast30Days(someDate) {
            const monthAgo = new Date()
            monthAgo.setDate(monthAgo.getDate() - 30)

            return someDate >= monthAgo
        },

        isThisMonth(someDate) {
            const today = new Date()
            return someDate.getMonth() == today.getMonth() &&
                someDate.getFullYear() == today.getFullYear()
        },

        rowClicked(item, index, e, detailsClick = false) {
            this.$emit(
                'row-clicked', item, index, e
            )
        },

    },

}
</script>

<style scoped>

</style>
