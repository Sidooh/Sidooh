<template>
    <!--    <div class="c-app flex-row align-items-center">-->
    <CContainer class=" py-5">
        <CRow class="justify-content-center">

            <h1>Coming Soon!</h1>

        </CRow>

        <CRow class="justify-content-center">

            <h4>Stay tuned...</h4>

        </CRow>
    </CContainer>
    <!--    </div>-->
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import Vue from "vue";

export default {
    name: 'Airtime',

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
