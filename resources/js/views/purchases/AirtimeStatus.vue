<template>
    <!--    <div class="c-app flex-row align-items-center">-->
    <CContainer>
        <CRow class="justify-content-center">
            <CCol col="12" md="6">
                <CCard v-if="status">
                    <CCardHeader>
                        <CIcon name="cil-justify-center"/>
                        Airtime <small>Status</small>

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
                        <div v-if="status.airtime">
                            <div v-if="status.airtime.errorMessage === 'None'">
                                <div v-if="status.airtime.response">

                                    <CAlert :color="getColour(status.airtime.response.status)" show>
                                        <h4 class="alert-heading">Airtime</h4>
                                        <p>
                                            {{
                                                status.airtime.response.status
                                            }}
                                        </p>
                                        <hr>
                                        <p class="mb-0">
                                            {{
                                                status.airtime.response.updated_at | moment("from")
                                            }}
                                        </p>
                                    </CAlert>

                                </div>
                            </div>
                            <div v-else>
                                <CAlert :color="getColour('failed')" show>
                                    <h4 class="alert-heading">Airtime</h4>
                                    <p>
                                        {{
                                            status.airtime.errorMessage
                                        }}
                                    </p>
                                    <hr>
                                    <p class="mb-0">
                                        {{
                                            status.airtime.updated_at | moment("from")
                                        }}
                                    </p>
                                </CAlert>
                            </div>

                        </div>
                        <div v-else>
                            <CAlert :color="getColour('pending')" show>
                                <h4 class="alert-heading">Airtime</h4>
                                <p>
                                    Not Requested
                                </p>
                                <hr>
                                <p class="mb-0">
                                    {{
                                        status.updated_at | moment("from")
                                    }}
                                </p>
                            </CAlert>
                        </div>
                    </CCardBody>
                </CCard>

                <CCard v-else>
                    <CCardBody>
                        <CCardHeader>
                            <CIcon name="cil-justify-center"/>
                            Airtime <small>Status</small>

                            <span v-if="timerEnabled" class="text-right float-right">Refreshing in {{
                                    timerCount
                                }}</span>
                        </CCardHeader>
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
        this.checkAirtimeStatus(this.$route.params.id)
        next()
    },

    computed: {
        ...mapGetters("Purchases", ["status", "errors"]),

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
                    this.checkAirtimeStatus(this.$route.params.id)
                    this.timerEnabled = false
                }

            },
            immediate: true // This ensures the watcher is triggered upon creation
        }

    },

    mounted() {
        this.checkAirtimeStatus(this.$route.params.id)

        this.timerEnabled = true;
    },

    methods: {
        ...mapActions('Purchases', [
            "checkAirtimeStatus",
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
