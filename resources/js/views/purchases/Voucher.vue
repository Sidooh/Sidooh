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
                                        <CCol v-for="(a, key) in voucherAmounts" v-bind:key="key" class="mb-3" md="4"
                                              sm="6" v-bind:data="a"
                                              xl="3">
                                            <CButton :key="key" block color="primary" shape="pill" variant="outline"
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

                                <div class="mt-3">
                                    <CRow class="form-group mb-0" form>
                                        <CCol class="col-form-label" md="6" tag="label">
                                            Other Mpesa Number?
                                        </CCol>
                                        <!--                                    try 3d variant and label-->
                                        <CCol md="6">
                                            <CSwitch
                                                :checked="mpesaNumber"
                                                class="mr-1"
                                                color="info"
                                                shape="pill"
                                                slabelOn="Buy for other"
                                                variant="outline"
                                                @update:checked="setMpesaNumber"
                                            />
                                        </CCol>

                                        <CCol v-if="mpesaNumber">
                                            <vue-tel-input :invalidMsg="error" class="mt-3"
                                                           @validate="checkMpesaPhone"></vue-tel-input>
                                            <p v-if="errors.mpesaPhone" id="mpesaPhoneError" class="alert-warning">
                                                {{
                                                    errors.mpesaPhone[0]
                                                }}
                                            </p>
                                            <p v-if="validation.mpesa_phone" id="mpesaNumberError"
                                               class="alert-warning">
                                                {{ validation.mpesa_phone }}
                                            </p>
                                        </CCol>
                                    </CRow>
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
                mpesa_phone: null
            },

            voucherAmounts: {
                100: '100', 200: '200', 500: '500', 1000: '1000', 2500: '2500', 10000: '10000', '-1': 'Other'
            },

            otherAmount: false,
            otherNumber: false,
            mpesaNumber: false,
            options: ['MPesa', 'Voucher'],
            selectedOption: 'MPesa',

            validation: {
                // other_phone: '',
                amount: '',
                // purchaseMethod: '',
                mpesa_phone: ''
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
                (this.mpesaNumber ? !this.validation.mpesa_phone : true) && this.form.amount
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

        checkMpesaPhone(phoneObject) {
            if (phoneObject.number)
                if (phoneObject.valid) {
                    let safRegex = /^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$/
                    //
                    if (safRegex.test(phoneObject.number)) {
                        this.validation.mpesa_phone = ''
                        this.error = null
                        this.form.mpesa_phone = phoneObject.number.replace("+", "");
                    } else {
                        this.validation.mpesa_phone = "Enter a valid Mpesa Number"
                    }

                } else {
                    this.validation.mpesa_phone = "Number seems to be invalid. Please try again."
                }
            // }
        },


        setOtherAmount(e) {
            this.otherAmount = e
        },

        setMpesaNumber(e) {
            this.mpesaNumber = e
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
