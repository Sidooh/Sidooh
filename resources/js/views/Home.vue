<template>
    <div>

        <!--        <CRow>-->
        <!--            <CCol>-->
        <!--                -->
        <!--            </CCol>-->
        <!--        </CRow>-->

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
                        <button class="btn float-right btn-primary">
                            <CIcon name="cil-cloud-download"/>
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
                        <strong>{{ totalAmount }}</strong> <span title="Today's Transactions">({{
                            totalAmountToday
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

        <CRow>
            <CCol lg="3" sm="6">
                <CWidgetDropdown :header="totalActiveReferrals" color="primary" text="Invites">
                    <!--                    <template #default>-->
                    <!--                        <CDropdown-->
                    <!--                            color="transparent p-0"-->
                    <!--                            placement="bottom-end"-->
                    <!--                        >-->
                    <!--                            <template #toggler-content>-->
                    <!--                                <CIcon name="cil-settings"/>-->
                    <!--                            </template>-->
                    <!--                            <CDropdownItem>Action</CDropdownItem>-->
                    <!--                            <CDropdownItem>Another action</CDropdownItem>-->
                    <!--                            <CDropdownItem>Something else here...</CDropdownItem>-->
                    <!--                            <CDropdownItem disabled>Disabled action</CDropdownItem>-->
                    <!--                        </CDropdown>-->
                    <!--                    </template>-->
                    <template #footer>
                        <CChartLineSimple
                            :data-points="referralChartData"
                            :labels="referralChartLabels"
                            class="mt-3 mx-3"
                            label="Invites"
                            point-hover-background-color="primary"
                            pointed
                            style="height:70px"
                        />
                    </template>
                </CWidgetDropdown>
            </CCol>
        </CRow>

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
                            <CBadge :color="getBadge(data.item.status)">
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
// import { mapState } from 'vuex';
import {CChartLine} from '@coreui/vue-chartjs'
import {mapActions, mapGetters} from "vuex";
import CChartLineSimple from "../components/CChartLineSimple";

export default {
    name: "Home",

    components: {CChartLineSimple, CChartLine},
    data() {
        return {
            fields: [
                {key: 'id', /*_style: { width: '40%'}*/},
                {key: 'type',},
                {key: 'description'},
                {key: 'amount',},
                {key: 'status'},
                {key: 'created_at',},
                // {key: 'description'},
                // {key: 'content', format: 'trim:100'},
                // {key: 'created_at', label: 'Created', format: 'date:d/m/Y'},
                // {key: 'author_id', label: 'Author', type: 'relationship'},
                // {key: 'stage_id', label: 'Stage', type: 'relationship'},
                // {key: 'approved_by', label: 'Approver', type: 'relationship'},

                // {
                //     key: 'show_details',
                //     label: '',
                //     _style: { width: '1%' },
                //     sorter: false,
                //     filter: false
                // }
            ],

            options: {
                maintainAspectRatio: false,
                // elements: {
                //     line: {
                //         // tension: .3
                //     }
                // },
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
            this.processTransactionChartData()
        })
        this.fetchReferrals().then(() => {
            this.processReferralChartData()
        })
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

        totalTransactions() {
            return this.transactions.length
        },
        totalTransactionsToday() {
            return this.transactions.filter(item => this.isToday(new Date(item.created_at))).length
        },
        totalTransactionsThisMonth() {
            return this.transactions.filter(item => this.isThisMonth(new Date(item.created_at))).length
        },

        recentTransactions() {
            return this.transactions.sort((a, b) => b.id - a.id).slice(0, 15)
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

        datasets() {
            return [
                {
                    data: this.chartData1,
                    backgroundColor: '#008',
                    borderColor: '#00c',
                    label: 'Amount',
                    // cubicInterpolationMode: 'monotone',
                    fill: false,
                    // yAxisID: 'y',

                },

                {
                    data: this.chartData2,
                    backgroundColor: '#080',
                    borderColor: '#0c0',
                    label: 'Count',
                    // cubicInterpolationMode: 'monotone',
                    fill: false,
                    // yAxisID: 'y1',

                }
            ]
        }
    },


    methods: {
        ...mapActions('TransactionsIndex', {
            fetchTransactions: 'fetchData',
            processTransactionChartData: 'processChartData',
            setQuery: 'setQuery',
            resetState: 'resetState'
        }),
        ...mapActions('ReferralsIndex', {
            fetchReferrals: 'fetchData',
            processReferralChartData: 'processChartData'
        }),

        groupTransactions(e) {
            this.transactionsQuery.group = e
            this.processTransactionChartData()
        },

        isToday(someDate) {
            const today = new Date()
            return someDate.getDate() == today.getDate() &&
                someDate.getMonth() == today.getMonth() &&
                someDate.getFullYear() == today.getFullYear()
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

        getBadge(status) {
            return status === 'Active' ? 'success'
                : status === 'Inactive' ? 'secondary'
                    : status === 'Pending' ? 'warning'
                        : status === 'Banned' ? 'danger' : 'primary'
        }
    },

}
</script>

<style scoped>

</style>
