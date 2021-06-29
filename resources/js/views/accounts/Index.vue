<template>
    <div>

        <CCardText>Account Balances</CCardText>
        <CCardGroup class="mb-4">
            <CWidgetProgressIcon
                :header="balances.voucher.balance | numFormat('0,0')"
                color="gradient-info"
                inverse
                text="VOUCHER"
            >
                <CIcon height="36" name="cil-people"/>
            </CWidgetProgressIcon>
            <CWidgetProgressIcon
                v-for="acc in balances.sub_accounts"
                v-bind:key="acc.id" v-bind:data="acc"
                :color="getColour(acc.type)"
                :header="acc.balance | numFormat('0,0.0000')"
                :text="acc.type"
            >
                <CIcon :name="getIcon(acc.type)" height="36"/>
            </CWidgetProgressIcon>
        </CCardGroup>

        <CCardText>Earnings</CCardText>

        <CRow>
            <CCol lg="4" sm="4">
                <CWidgetSimple :text="myTotalEarnings | numFormat('0,0.00')" header="Total">
                    <CChartBarSimple background-color="info" style="height:40px"/>
                </CWidgetSimple>
            </CCol>
            <CCol lg="4" sm="4">
                <CWidgetSimple :text="myEarnings | numFormat('0,0.00')" header="Self">
                    <CChartBarSimple background-color="primary" style="height:40px"/>
                </CWidgetSimple>
            </CCol>
            <CCol lg="4" sm="4">
                <CWidgetSimple :text="myInviteEarnings | numFormat('0,0.00')" header="Invites">
                    <CChartBarSimple background-color="success" style="height:40px"/>
                </CWidgetSimple>
            </CCol>
        </CRow>

    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CChartBarSimple from "../../components/CChartBarSimple";

export default {
    name: "Index",
    components: {CChartBarSimple},
    data() {
        return {
            items: {
                CURRENT: {
                    icon: 'cil-userFollow',
                    colour: 'gradient-success',
                },
                INTEREST: {
                    icon: 'cil-chartPie',
                    colour: 'gradient-primary',
                },
                SAVINGS: {
                    icon: 'cil-speedometer',
                    colour: 'gradient-warning',
                }
            },

            fields: [
                // {key: 'id', /*_style: { width: '40%'}*/},
                // {key: 'type',},
                // {key: 'description'},
                {key: 'earnings', label: 'amount'},
                {key: 'type',},
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
        }
    },

    mounted() {
        this.getAccountBalances()
        this.getEarnings()
    },

    destroyed() {
        //TODO: Maybe add this after setting up data persistence
        // this.resetState()
    },

    computed: {
        ...mapGetters('Accounts', ['balances']),
        ...mapGetters('EarningsIndex', ['earnings', 'myEarnings', 'myInviteEarnings']),

        myTotalEarnings() {
            return (parseFloat(this.myEarnings) + parseFloat(this.myInviteEarnings)).toFixed(4)
        }
    },

    methods: {
        ...mapActions('Accounts', ['getAccountBalances', 'getEarningsSummary']),
        ...mapActions('EarningsIndex', {
            getEarnings: "fetchData"
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
            status = status.toLowerCase()
            return status === 'self' ? 'success'
                : status === 'referral' ? 'primary'
                    : status === 'reimbursed' ? 'warning'
                        : status === 'failed' ? 'danger' : 'secondary'
        },

        getColour(type) {
            return this.items[type].colour
        },

        getIcon(type) {
            return this.items[type].icon
        },
    },

}
</script>

<style scoped>

</style>
