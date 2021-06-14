<template>
    <CContainer>
        <CRow class="justify-content-center">
            <CCol md="5" sm="6">
                <CCardGroup>
                    <CCard class="p-4">
                        <CCardBody>
                            <CForm @submit.prevent="submit">
                                <h1>Top Up Voucher</h1>
                                <p class="text-muted">Kindly fill in the required details</p>

                                <p v-if="showError" id="error" class="alert-warning">Some details were not filled in
                                    correctly</p>
                                <p v-if="error" class="alert-warning">
                                    {{ error }}
                                </p>

                                <!--                                Amount-->

                                <div class="mt-4">
                                    <span>Amount</span>
                                    <CRow>
                                        <CCol v-for="(a, key) in voucherAmounts" class="mb-3" md="4" sm="6"
                                              xl="3">
                                            <CButton :key="key" block color="primary" shape="pill"
                                                     @click="checkAmount(key)">{{ a }}
                                            </CButton>
                                        </CCol>
                                    </CRow>

                                    <CInput
                                        v-model="form.amount"
                                        :disabled="!otherAmount"
                                        class="mb-0 mt-3"
                                        max="10000"
                                        min="10"
                                        placeholder="amount"
                                        type="number"
                                        @update:value="checkAmount"
                                    >
                                        <template #prepend-content>
                                            <CIcon name="cil-dollar"/>
                                        </template>
                                    </CInput>
                                    <p v-if="validation.amount" id="amountError" class="alert-warning">
                                        {{ validation.amount }}
                                    </p>
                                </div>

                                <CRow>
                                    <CCol class="text-left mt-3" col="12">
                                        <CButton :disabled="!validForm" color="primary" sclass="px-4 mt-3"
                                                 type="submit">Top Up
                                        </CButton>
                                        <CButton color="danger" ssize="sm" type="reset">
                                            <!--                                            <CIcon name="cil-ban"/>-->
                                            Reset
                                        </CButton>
                                    </CCol>
                                </CRow>

                            </CForm>
                        </CCardBody>
                    </CCard>
                </CCardGroup>
            </CCol>
        </CRow>
    </CContainer>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import Vue from "vue";

export default {
    name: 'Airtime',

    data() {
        return {
            form: {
                // other_phone: null,
                amount: "",
                // purchaseMethod: "MPESA"
            },

            voucherAmounts: {
                100: '100', 200: '200', 500: '500', 1000: '1000', 2500: '2500', 10000: '10000', '-1': 'Other'
            },

            otherAmount: false,
            otherNumber: false,
            options: ['MPesa', 'Voucher'],
            selectedOption: 'MPesa',

            validation: {
                // other_phone: '',
                amount: '',
                // purchaseMethod: '',
            },

            showError: false,
            loading: false,
            message: '',
            error: null
        };
    },

    computed: {
        ...mapGetters("Purchases", ["errors"]),

        validForm() {
            return !this.validation.amount &&
                !this.validation.purchaseMethod &&
                (this.otherNumber ? !this.validation.other_phone : true) && this.form.amount
        },
    },

    methods: {
        ...mapActions('Purchases', [
            "buyVoucher",
        ]),

        checkAmount(amount) {
            if (amount >= 100 && amount <= 150000) {
                let amountRegex = /^\d+$/

                if (amountRegex.test(amount)) {
                    this.validation.amount = ''
                    this.form.amount = amount;
                } else {
                    this.validation.amount = "Please only put whole numbers"
                }

            } else if (amount === '-1') {
                this.otherAmount = true
            } else {
                this.validation.amount = "Amount should be min of 100 and max of 150000"
            }
        },

        setOtherAmount(e) {
            this.otherAmount = e
        },

        async submit() {
            try {
                await this.buyVoucher(this.form).then(
                    (d) => {
                        console.log('success', d)
                        this.showError = false
                        Vue.swal({
                            title: d.status,
                            text: d.message,
                            icon: 'success',
                        });

                        this.$router.push({name: 'voucher_status', params: {id: d.data.id}});
                    },
                    error => {
                        console.log('error', error)

                        if (error.error) {
                            this.showError = true
                        }

                        this.loading = false;
                        this.message =
                            (error.response && error.response.data) ||
                            error.message || error.error ||
                            error.toString();
                    });

            } catch (error) {
                console.log('purchaseVoucherVueError', error)
            }
        },
    },

}
</script>
