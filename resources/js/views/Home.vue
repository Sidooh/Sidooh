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
                        <div class="small text-muted">November 2017</div>
                    </CCol>
                    <CCol class="d-none d-md-block col-sm-7">
                        <button class="btn float-right btn-primary">
                            <CIcon name="cil-cloud-download"/>
                        </button>
                        <CButtonGroup class="float-right mr-3 btn-group">
                            <CButton class="btn mx-0 btn-outline-secondary" @click="groupTransactions('d')">
                                Day
                            </CButton>
                            <button class="btn mx-0 btn-outline-secondary" @click="groupTransactions('m')">
                                Month
                            </button>
                            <button class="btn mx-0 btn-outline-secondary" @click="groupTransactions('y')">
                                Year
                            </button>
                        </CButtonGroup>
                    </CCol>
                </CRow>

                <CChartLine :datasets="datasets" :labels="chartLabels" :options="options"
                            style="height: 400px; margin-top: 40px;"/>

            </CCardBody>
            <CCardFooter>
                <CRow class="text-center">
                    <CCol sclass="mb-sm-2 mb-0 col-sm-12 col-md">
                        <div class="text-muted">Visits</div>
                        <strong>29.703 Users (40%)</strong>
                        <CProgress :value="20"/>
                    </CCol>
                    <CCol sclass="mb-sm-2 mb-0 col-sm-12 col-md">
                        <div class="text-muted">Pageviews</div>
                        <strong>29.03 Users (20%)</strong>
                        <CProgress :value="80"/>
                    </CCol>
                </CRow>
            </CCardFooter>
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

export default {
    name: "Home",

    components: {CChartLine},
    data() {
        return {
            // query: {sort: 'id', order: 'desc', group: 'd', type: 'PAYMENT'},

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
        this.fetchData()
    },

    destroyed() {
        //TODO: Maybe add this after setting up data persistence
        // this.resetState()
    },

    computed: {
        // ...mapState({
        //     count: state => state.count
        // }),
        ...mapGetters('TransactionsIndex', ['data', 'query', "total", "loading"]),

        groupedData() {
            var resultArr = [];
            var dateArr = [];

            this.data.forEach(item => {
                var date = new Date(item.created_at).toISOString().replace(/T/, ' ').split(' ')[0];

                var index = dateArr.indexOf(date);
                if (index == -1) {
                    dateArr.push(date);
                    var obj = {date: date, amount: item.amount, count: 1};
                    resultArr.push(obj);
                } else {
                    resultArr[index].amount += item.amount;
                    resultArr[index].count += item.count ?? 0;
                }
            });

            return resultArr
        },

        chartLabels() {
            return this.groupedData.map(a => a.date)
        },
        chartData() {
            return this.groupedData.map(a => a.amount)
        },
        chartData2() {
            return this.groupedData.map(a => a.count)
        },

        totalAmount() {
            return _.sum(this.chartData)
        },

        datasets() {
            return [
                {
                    data: this.chartData,
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

    // watch: {
    //     query: {
    //         handler(query) {
    //             this.setQuery(query)
    //         },
    //         deep: true
    //     }
    // },

    methods: {
        ...mapActions('TransactionsIndex', ['fetchData', 'setQuery', 'resetState']),

        groupTransactions(e) {
            this.query.group = e
        }
    },

}
</script>

<style scoped>

</style>
