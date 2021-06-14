<template>
    <div>

        <CCardGroup class="mb-4">
            <CWidgetProgressIcon
                :header="balances.voucher.balance + ''"
                color="gradient-info"
                inverse
                text="VOUCHER"
            >
                <CIcon height="36" name="cil-people"/>
            </CWidgetProgressIcon>
            <CWidgetProgressIcon
                v-for="acc in balances.sub_accounts"
                :color="getColour(acc.type)"
                :header="acc.balance + ''"
                :text="acc.type"
            >
                <CIcon :name="getIcon(acc.type)" height="36"/>
            </CWidgetProgressIcon>
        </CCardGroup>

    </div>
</template>

<script>
import {CChartLine} from '@coreui/vue-chartjs'
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Index",

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
            }
        }
    },

    mounted() {
        this.getAccountBalances()
    },

    destroyed() {
        //TODO: Maybe add this after setting up data persistence
        // this.resetState()
    },

    computed: {
        ...mapGetters('Accounts', ['balances']),

    },


    methods: {
        ...mapActions('Accounts', ['getAccountBalances']),

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
