<template>
    <div>
        <!--        <CRow>-->
        <!--            <CCol sm="6" lg="3">-->
        <!--                <CWidgetDropdown color="primary" :header="totalActiveReferrals" text="Invites">-->
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
        <!--                            pointed-->
        <!--                            class="mt-3 mx-3"-->
        <!--                            style="height:70px"-->
        <!--                            :data-points="referralChartData"-->
        <!--                            point-hover-background-color="primary"-->
        <!--                            label="Invites"-->
        <!--                            :labels="referralChartLabels"-->
        <!--                        />-->
        <!--                    </template>-->
        <!--                </CWidgetDropdown>-->
        <!--            </CCol>-->
        <!--        </CRow>-->

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
                    :items="referrals"
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

        }
    },

    created() {
        this.fetchReferrals()
    },

    destroyed() {
        //TODO: Maybe add this after setting up data persistence
        // this.resetState()
    },

    computed: {
        ...mapGetters('ReferralsIndex', {
            data: 'data'
        }),

        totalReferrals() {
            return this.data.length
        },
        totalReferralsToday() {
            return this.data.filter(item => this.isToday(new Date(item.created_at))).length
        },
        totalReferralsThisMonth() {
            return this.data.filter(item => this.isThisMonth(new Date(item.created_at))).length
        },

        referrals() {
            return this.data.sort((a, b) => b.id - a.id)
        },

    },


    methods: {
        ...mapActions('ReferralsIndex', {
            fetchReferrals: 'fetchData',
            setQuery: 'setQuery',
            resetState: 'resetState'
        }),

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
