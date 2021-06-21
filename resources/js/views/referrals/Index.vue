<template>
    <div>
        <CCard>
            <CCardBody>
                <CRow>
                    <CCol class="col-sm-5">
                        <h4 class="card-title mb-0">Invites Summary</h4>
                        <div class="small text-muted">{{
                                referralsQuery.group === 'd' ? 'Invites done today' : (referralsQuery.group === 'm' ? 'Invites done this month' : 'Invites done this year')
                            }}
                        </div>
                    </CCol>
                    <CCol class="d-none d-md-block col-sm-7">
                        <button class="btn float-right btn-primary">
                            <CIcon name="cil-cloud-download"/>
                        </button>
                        <CButtonGroup class="float-right mr-3 btn-group">
                            <CButton class="btn mx-0 btn-outline-secondary"
                                     v-bind:class="[ referralsQuery.group === 'd' ? 'active' : '' ]"
                                     @click="groupReferrals('d')">
                                Day
                            </CButton>
                            <button class="btn mx-0 btn-outline-secondary"
                                    v-bind:class="[ referralsQuery.group === 'm' ? 'active' : '' ]"
                                    @click="groupReferrals('m')">
                                Month
                            </button>
                            <button class="btn mx-0 btn-outline-secondary"
                                    v-bind:class="[ referralsQuery.group === 'y' ? 'active' : '' ]"
                                    @click="groupReferrals('y')">
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
                        <div class="text-muted">Total Invites</div>
                        <strong>{{ totalReferrals }}</strong> <span
                        title="Today's Invites">({{ totalReferralsToday }})</span>
                        <CProgress
                            :precision="1"
                            :value="totalReferrals"
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
                    My Invites
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
                {key: 'id', /*_style: { width: '40%'}*/},
                {key: 'referee_phone'},
                // {key: 'description'},
                // {key: 'amount',},
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
        this.groupReferrals('y');
        this.fetchReferrals().then(() => {
            this.processReferralChartData()
        })
    },

    destroyed() {
        //TODO: Maybe add this after setting up data persistence
        this.resetState()
    },

    computed: {
        ...mapGetters('ReferralsIndex', {
            data: 'data',
            referralsChartData: 'chartData',
            referralsQuery: 'query',
            referralsTotal: "total",
            activeReferrals: 'activeReferrals',
        }),

        chartLabels() {
            return this.referralsChartData.map(a => a.date)
        },
        chartData() {
            return this.referralsChartData.map(a => a.count)
        },

        totalReferrals() {
            return this.data.length
        },
        totalReferralsToday() {
            return this.data.filter(item => this.isToday(new Date(item.created_at))).length
        },
        totalReferralsThisMonth() {
            return this.data.filter(item => this.isThisMonth(new Date(item.created_at))).length
        },

        datasets() {
            return [
                {
                    data: this.chartData,
                    backgroundColor: '#008',
                    borderColor: '#00c',
                    label: 'Count',
                    // cubicInterpolationMode: 'monotone',
                    fill: false,
                    // yAxisID: 'y',

                },
            ]
        }
    },

    methods: {
        ...mapActions('ReferralsIndex', {
            fetchReferrals: 'fetchData',
            processReferralChartData: 'processChartData',
            setQuery: 'setQuery',
            resetState: 'resetState'
        }),

        groupReferrals(e) {
            const q = Object.assign({}, this.referralsQuery, {group: e, yearLimit: true});

            // or
            // const q = {...this.referralsQuery, { group: e} }

            this.setQuery(q);
            this.processReferralChartData()
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
            return status === 'success' ? 'success'
                : status === 'pending' ? 'secondary'
                    : status === 'reimbursed' ? 'warning'
                        : status === 'failed' ? 'danger' : 'primary'
        }
    },

}
</script>

<style scoped>

</style>
