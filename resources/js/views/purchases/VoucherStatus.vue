<template>
    <!--    <div class="c-app flex-row align-items-center">-->
    <CContainer>
        <CRow class="justify-content-center">
            <CCol col="12" md="6">
                <CCard v-if="status">
                    <CCardHeader>
                        <CIcon name="cil-justify-center"/>
                        Voucher <small>Status</small>

                        <span v-if="timerEnabled" class="text-right float-right">Refreshing in {{ timerCount }}</span>
                    </CCardHeader>
                    <CCardBody>
                        <div v-if="status.payment.stk_request">
                            <CAlert :color="getColour(status.payment.stk_request.status)" show>
                                <h4 class="alert-heading">STK Push</h4>
                                <p>
                                    {{
                                        status.payment.stk_request.status
                                    }}

                                    <span v-if="status.payment.stk_request.status === 'Failed'">
                                        - <b>{{
                                            status.payment.stk_request.response.ResultDesc
                                        }}</b>
                                    </span>
                                </p>

                                <hr>
                                <p class="mb-0">
                                    {{
                                        status.payment.stk_request.updated_at | moment("from")
                                    }}
                                </p>
                            </CAlert>
                        </div>
                    </CCardBody>

                    <CCardBody>
                        <div v-if="status.payment">
                            <CAlert :color="getColour(status.payment.status)" show>
                                <h4 class="alert-heading">Payment</h4>
                                <p>
                                    {{
                                        status.payment.status
                                    }}
                                </p>
                                <hr>
                                <p class="mb-0">
                                    {{
                                        status.payment.updated_at | moment("from")
                                    }}
                                </p>
                            </CAlert>
                        </div>
                    </CCardBody>

                    <CCardBody>
                        <div v-if="completed">
                            <CButton :to="{ name: 'finances' }" color="success" size="sm">
                                <CIcon name="cil-info"/>
                                Check voucher balance
                            </CButton>
                        </div>
                    </CCardBody>
                </CCard>

                <CCard v-else>
                    <CCardBody>
                        <CCardText>
                            <b>Oops!</b>

                            The item you are looking for does not exist.
                        </CCardText>
                        <CButton :to="{ name: 'dashboard' }" color="danger" size="sm">
                            <CIcon name="cil-ban"/>
                            Go home
                        </CButton>
                    </CCardBody>
                </CCard>
            </CCol>
        </CRow>
    </CContainer>
    <!--    </div>-->
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import Vue from "vue";

export default {
    name: 'AirtimeStatus',

    data() {
        return {
            steps: 3,
            timerCount: 30,
            timerEnabled: true,
        };
    },

    beforeRouteUpdate(to, from, next) {
        // react to route changes...
        // don't forget to call next()
        this.checkVoucherStatus(this.$route.params.id)
        next()
    },

    computed: {
        ...mapGetters("Purchases", ["status", "errors"]),

        completed() {
            return this.status.payment.status === 'Complete' && this.status.payment.stk_request.status === 'Paid'
        }
    },

    watch: {

        timerEnabled(value) {
            if (value) {
                setTimeout(() => {
                    this.timerCount--;
                }, 1000);
            }
        },

        timerCount: {
            handler(value) {

                if (value > 0 && this.timerEnabled) {
                    setTimeout(() => {
                        this.timerCount--;
                    }, 1000);
                }

                if (value === 0) {
                    this.checkVoucherStatus(this.$route.params.id)
                    this.timerEnabled = false
                }

            },
            immediate: true // This ensures the watcher is triggered upon creation
        }

    },

    mounted() {
        this.checkVoucherStatus(this.$route.params.id)

        this.timerEnabled = true;
    },

    methods: {
        ...mapActions('Purchases', [
            "checkVoucherStatus",
        ]),

        getColour(status) {
            status = status.toLowerCase().trim()

            return ['success', 'paid', 'complete'].includes(status) ? 'success'
                : ['pending', 'sent'].includes(status) ? 'secondary'
                    : status === 'reimbursed' ? 'warning'
                        : status === 'failed' ? 'danger' : 'primary'
        }

    },

}
</script>
