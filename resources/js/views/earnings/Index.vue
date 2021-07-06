<template>
    <div>
        <CCard>
            <CCardBody>
                <CRow>
                    <CCol class="col-sm-5">
                        <h4 class="card-title mb-0">Earnings Summary</h4>
                        <div class="small text-muted">{{
                                earningsQuery.group === 'd' ? 'Earnings today' : (earningsQuery.group === 'm' ? 'Earnings this month' : 'Earnings this year')
                            }}
                        </div>
                    </CCol>
                    <CCol class="d-none d-md-block col-sm-7">
                        <!--                        <button class="btn float-right btn-primary">-->
                        <!--                            <CIcon name="cil-reload"/>-->
                        <!--                        </button>-->
                        <CButtonGroup class="float-right mr-3 btn-group">
                            <CButton class="btn mx-0 btn-outline-secondary"
                                     v-bind:class="[ earningsQuery.group === 'd' ? 'active' : '' ]"
                                     @click="groupEarnings('d')">
                                Day
                            </CButton>
                            <button class="btn mx-0 btn-outline-secondary"
                                    v-bind:class="[ earningsQuery.group === 'm' ? 'active' : '' ]"
                                    @click="groupEarnings('m')">
                                Month
                            </button>
                            <button class="btn mx-0 btn-outline-secondary"
                                    v-bind:class="[ earningsQuery.group === 'y' ? 'active' : '' ]"
                                    @click="groupEarnings('y')">
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
                        <div class="text-muted">Number of Earnings</div>
                        <strong>{{ formatNumber(totalEarnings) | numFormat('0,0') }}</strong> <span
                        title="Today's Number of Earnings">({{
                            formatNumber(totalEarningsToday) | numFormat('0,0')
                        }})</span>
                        <CProgress
                            :precision="1"
                            :value="totalEarnings"
                            class="progress-xs mt-2"
                            color="success"
                        />
                    </CCol>
                    <CCol sclass="mb-sm-2 mb-0 col-sm-12 col-md">
                        <div class="text-muted">Total Amounts</div>
                        <strong>{{ formatNumber(totalAmount) | numFormat('0,0.0000') }}</strong> <span
                        title="Today's Transactions">({{
                            formatNumber(totalAmountToday) | numFormat('0,0.0000')
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

        <CCard>
            <CCardHeader>
                <slot name="header">
                    <CIcon name="cil-grid"/>
                    My Earnings
                </slot>
            </CCardHeader>
            <CCardBody>
                <CDataTable
                    :fields="fields"
                    :items="data"
                    :items-per-page="15"
                    :pagination="{ doubleArrows: false, align: 'center'}"
                    clickable-rows
                    hover
                    items-per-page-select
                    sorter
                    striped
                    table-filter
                    @row-clicked="rowClicked"
                >
                    <template #account="data">
                        <td>
                            {{ data.item.account.id }}
                        </td>
                    </template>
                    <template #type="data">
                        <td>
                            <CBadge :color="getBadge(data.item.type)">
                                {{ data.item.type }}
                            </CBadge>
                        </td>
                    </template>
                </CDataTable>
            </CCardBody>
        </CCard>
    </div>
</template>

<script>
import {CChartLine} from '@coreui/vue-chartjs'
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Index",

    components: {CChartLine},
    data() {
        return {
            fields: [
                // {key: 'id', /*_style: { width: '40%'}*/},
                // {key: 'type',},
                // {key: 'description'},
                {key: 'earnings', label: 'Amount'},
                {key: 'type',},
                {key: 'account', label: 'Invitee'},
                {key: 'created_at', label: 'Date'},
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
        // this.groupEarnings('y');
        this.fetchEarnings().then(() => {
            this.processEarningChartData()
        })
    },

    destroyed() {
        //TODO: Maybe add this after setting up data persistence
        // this.resetState()
    },

    computed: {
        ...mapGetters('EarningsIndex', {
            data: 'data',
            earningsChartData: 'chartData',
            earningsQuery: 'query',
            earningsTotal: "total",
        }),

        chartLabels() {
            return this.earningsChartData.map(a => a.date)
        },
        chartData1() {
            return this.earningsChartData.map(a => parseFloat(a.amount).toFixed(4))
        },
        chartData2() {
            return this.earningsChartData.map(a => a.count)
        },

        totalAmount() {
            return _.sum(this.data.map(a => parseFloat(a.earnings)))
        },
        totalAmountToday() {
            return _.sum(this.data.filter(item => this.isToday(new Date(item.created_at))).map(a => parseFloat(a.earnings)))
        },
        totalAmountThisMonth() {
            return _.sum(this.data.filter(item => this.isThisMonth(new Date(item.created_at))).map(a => parseFloat(a.earnings)))
        },

        totalEarnings() {
            return this.data.length
        },
        totalEarningsToday() {
            return this.data.filter(item => this.isToday(new Date(item.created_at))).length
        },
        totalEarningsThisMonth() {
            return this.data.filter(item => this.isThisMonth(new Date(item.created_at))).length
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
        ...mapActions('EarningsIndex', {
            fetchEarnings: 'fetchData',
            processEarningChartData: 'processChartData',
            setQuery: 'setQuery',
            resetState: 'resetState'
        }),

        groupEarnings(e) {
            const q = Object.assign({}, this.earningsQuery, {group: e, yearLimit: false});

            // or
            // const q = {...this.earningsQuery, { group: e} }

            this.setQuery(q);
            this.processEarningChartData()
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
            status = status.toLowerCase()
            return status === 'self' ? 'success'
                : status === 'referral' ? 'primary'
                    : status === 'reimbursed' ? 'warning'
                        : status === 'failed' ? 'danger' : 'secondary'
        },

        formatNumber(e, dp = 4) {
            return e.toFixed(dp)
        }

    },

}
</script>

<style scoped>

</style>
