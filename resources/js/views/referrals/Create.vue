<template>
    <CContainer>
        <CRow class="justify-content-center">
            <CCol md="5" sm="6">
                <CCardGroup>
                    <CCard class="p-4">
                        <CCardBody>
                            <CForm @submit.prevent="submit">
                                <h1>Invite</h1>
                                <p class="text-muted">Kindly fill in the required details</p>

                                <p v-if="showError" id="error" class="alert-warning">Some details were not filled in
                                    correctly</p>
                                <p v-if="error" class="alert-warning">
                                    {{ error }}
                                </p>

                                <!--                                Number : if other number-->

                                <div class="mt-3">
                                    <CRow class="form-group mb-0" form>
                                        <CCol class="col-form-label" md="6" tag="label">
                                            Friend's number
                                        </CCol>
                                        <!--                                    try 3d variant and label-->
                                        <CCol md="6">
                                            <CSwitch
                                                :checked="number"
                                                class="mr-1"
                                                color="info"
                                                shape="pill"
                                                slabelOn="Buy for other"
                                                variant="outline"
                                                @update:checked="setOtherNumber"
                                            />
                                        </CCol>

                                        <CCol v-if="otherNumber">
                                            <vue-tel-input :invalidMsg="error" class="mt-3"
                                                           @validate="checkPhone"></vue-tel-input>
                                            <p v-if="errors.phone" id="phoneError" class="alert-warning">
                                                {{
                                                    errors.phone[0]
                                                }}
                                            </p>
                                            <p v-if="validation.other_phone" id="otherNumberError"
                                               class="alert-warning">
                                                {{ validation.other_phone }}
                                            </p>
                                        </CCol>
                                    </CRow>
                                </div>
                                <!--                                <CRow v-if="otherNumber" class="form-group mt-0" form>-->
                                <!--                                    -->
                                <!--                                </CRow>-->

                                <!--                                Amount-->

                                <div class="mt-4">
                                    <span>Amount</span>
                                    <CRow>
                                        <CCol v-for="(a, key) in airtimeAmounts" class="mb-3" md="4" sm="6"
                                              xl="3">
                                            <CButton :key="key" block color="primary" shape="pill"
                                                     @click="checkAmount(key)">{{ a }}
                                            </CButton>
                                        </CCol>
                                    </CRow>

                                    <CInput
                                        v-model="form.amount"
                                        :disabled="!otherAmount"
                                        :max="maxAmount"
                                        :min="minAmount"
                                        class="mb-0 mt-3"
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

                                <!--                                Method : if voucher has amount equivalent-->
                                <div class="mt-4">

                                    <CRow class="form-group mt-3" form>
                                        <CCol sm="6">
                                            Payment Method
                                        </CCol>
                                        <CInputRadioGroup
                                            :checked="selectedOption"
                                            :inline="true"
                                            :options="options"
                                            class="col-sm-6"
                                            @update:checked="setMethod"
                                        />
                                        <p v-if="validation.purchaseMethod" id="methodError" class="alert-warning">
                                            {{ validation.purchaseMethod }}
                                        </p>
                                    </CRow>
                                </div>

                                <CRow>
                                    <CCol class="text-left mt-3" col="12">
                                        <CButton :disabled="!validForm" color="primary" sclass="px-4 mt-3"
                                                 type="submit">Buy
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
            <!--            <CCol sm="4">-->
            <!--                <CCard>-->
            <!--                    <CCardHeader>-->
            <!--                        <strong>Buy Airtime</strong>-->
            <!--                    </CCardHeader>-->
            <!--                    <CCardBody>-->
            <!--                        <CInput placeholder="Username">-->
            <!--                            <template #prepend-content>-->
            <!--                                <CIcon name="cil-user"/>-->
            <!--                            </template>-->
            <!--                        </CInput>-->
            <!--                        <CInput-->
            <!--                            type="email"-->
            <!--                            placeholder="Email"-->
            <!--                            autocomplete="email"-->
            <!--                        >-->
            <!--                            <template #append-content>-->
            <!--                                <CIcon name="cil-envelope-open"/>-->
            <!--                            </template>-->
            <!--                        </CInput>-->
            <!--                        <CInput-->
            <!--                            placeholder="ex. $1.000.000"-->
            <!--                            append=".00"-->
            <!--                        >-->
            <!--                            <template #prepend-content>-->
            <!--                                <CIcon name="cil-euro"/>-->
            <!--                            </template>-->
            <!--                        </CInput>-->
            <!--                    </CCardBody>-->
            <!--                    <CCardFooter>-->
            <!--                        <CButton type="submit" size="sm" color="success">-->
            <!--                            <CIcon name="cil-check-circle"/>-->
            <!--                            Buy-->
            <!--                        </CButton>-->
            <!--                        <CButton type="reset" size="sm" color="danger">-->
            <!--                            <CIcon name="cil-ban"/>-->
            <!--                            Reset-->
            <!--                        </CButton>-->
            <!--                    </CCardFooter>-->
            <!--                </CCard>-->
            <!--            </CCol>-->
        </CRow>
    </CContainer>
    <!--    </div>-->
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import Vue from "vue";

export default {
    name: 'Create',

    data() {
        return {
            form: {
                other_phone: null,
                amount: "",
                purchaseMethod: "MPESA"
            },

            airtimeAmounts: {
                20: '20', 50: '50', 100: '100', 200: '200', 500: '500', 1000: '1000', '-1': 'Other'
            },

            minAmount: 10,
            maxAmount: 10002340,

            otherAmount: false,
            otherNumber: false,
            options: ['MPESA', 'VOUCHER'],
            selectedOption: 'MPESA',

            validation: {
                other_phone: '',
                amount: '',
                purchaseMethod: '',
            },

            showError: false,
            loading: false,
            message: '',
            error: null
        };
    },

    computed: {
        ...mapGetters("Purchases", ["errors"]),
        ...mapGetters("Accounts", ['voucherBalance']),

        validForm() {
            return !this.validation.amount &&
                !this.validation.purchaseMethod &&
                (this.otherNumber ? !this.validation.other_phone : true) && this.form.amount
        },
    },

    created() {
        if (this.isAuthenticated) {
            this.$router.push('/');
        }
    },

    mounted() {
        // this.checkAmount(this.form.amount)
    },

    methods: {
        ...mapActions('Purchases', [
            "buyAirtime",
        ]),
        ...mapActions('Accounts', [
            "getAccountBalances",
        ]),

        checkPhone(phoneObject) {
            console.log(phoneObject)
            if (phoneObject.number)
                if (phoneObject.valid) {

                    // let safRegex = /^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$/
                    //
                    // if (safRegex.test(phoneObject.number)) {
                    this.validation.other_phone = ''
                    this.error = null
                    this.form.other_phone = phoneObject.number.replace("+", "");

                } else {
                    this.validation.other_phone = "Number seems to be invalid. Please try again."
                }
            // }
        },

        checkAmount(amount) {
            if (amount >= this.minAmount && amount <= this.maxAmount) {
                let amountRegex = /^\d+$/

                if (amountRegex.test(amount)) {
                    this.validation.amount = ''
                    this.form.amount = parseInt(amount);
                } else {
                    this.validation.amount = "Please only put whole numbers"
                }

            } else if (amount === '-1') {
                this.otherAmount = true
            } else {
                this.validation.amount = `Amount should be min of ${this.minAmount} and max of ${this.maxAmount}`
            }
        },

        setOtherNumber(e) {
            this.otherNumber = e
        },

        setOtherAmount(e) {
            this.otherAmount = e
        },

        setMethod(e) {
            this.form.purchaseMethod = e.toUpperCase()

            if (e === 'VOUCHER') {
                if (this.voucherBalance < parseInt(this.form.amount)) {
                    this.confirmPayment()
                }
                console.log(this.voucherBalance, parseInt(this.form.amount))
            }
        },

        confirmPayment() {
            Vue.swal({
                title: 'Balance Insufficient',
                text: "Would you like to top up your voucher?",
                html:
                    `Current balance: <b>${this.voucherBalance}</b>, Would you like to top up?`,
                icon: 'info',
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Top Up`,
                // denyButtonText: `Use MPESA`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    this.$router.push({name: 'voucher'});
                } else if (result.isDenied) {
                    this.setMethod('MPESA')
                    this.selectedOption = 'MPESA'
                }
            })
        },

        async submit() {
            if (this.form.purchaseMethod === 'VOUCHER') {
                if (this.voucherBalance < parseInt(this.form.amount)) {
                    this.confirmPayment()
                }
                return false
            }

            try {
                await this.buyAirtime(this.form).then(
                    (d) => {
                        console.log('success', d)
                        this.showError = false
                        Vue.swal({
                            title: d.status,
                            text: d.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                            position: 'top-end',
                        });

                        this.$router.push({name: 'airtime_status', params: {id: d.data.id}});
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
                console.log('purchaseAirtimeVueError', error)

                this.showError = true
            }
        },
    },

}
</script>
