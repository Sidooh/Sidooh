<template>
    <!--    <div class="c-app flex-row align-items-center">-->
    <CContainer>
        <CRow class="justify-content-center">
            <CCol md="5" sm="6">
                <CCardGroup>
                    <CCard class="p-4">
                        <CCardBody>
                            <CForm @submit.prevent="submit">
                                <h1>Buy Airtime</h1>
                                <p class="text-muted">Kindly fill in the required details</p>

                                <p v-if="showError" id="error" class="alert-warning">Some details were not filled in
                                    correctly</p>
                                <p v-if="error" class="alert-warning">
                                    {{ error }}
                                </p>

                                <!--                                Number : if other number-->
                                <CRow class="form-group" form>
                                    <CCol class="col-form-label" md="6" tag="label">
                                        Other number?
                                    </CCol>
                                    <!--                                    try 3d variant and label-->
                                    <CCol md="6">
                                        <CSwitch
                                            :checked="otherNumber"
                                            class="mr-1"
                                            color="info"
                                            shape="pill"
                                            slabelOn="Buy for other"
                                            variant="outline"
                                            @update:checked="setOtherNumber"
                                        />
                                    </CCol>
                                </CRow>

                                <CRow v-if="otherNumber" class="form-group" form>
                                    <CCol>
                                        <vue-tel-input :invalidMsg="error" class="mt-3"
                                                       @validate="checkPhone"></vue-tel-input>
                                        <p v-if="errors.phone" id="phoneError" class="alert-warning">
                                            {{
                                                errors.phone[0]
                                            }}
                                        </p>
                                        <p v-if="validation.other_phone" id="otherNumberError" class="alert-warning">
                                            {{ validation.other_phone }}
                                        </p>
                                    </CCol>
                                </CRow>

                                <!--                                Amount-->
                                <CInput
                                    v-model="form.amount"
                                    class="mb-0"
                                    max="10000"
                                    min="10"
                                    placeholder="1000"
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

                                <!--                                Method : if voucher has amount equivalent-->

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
                                    <p v-if="validation.method" id="methodError" class="alert-warning">
                                        {{ validation.method }}
                                    </p>
                                </CRow>

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

export default {
    name: 'Airtime',

    data() {
        return {
            form: {
                other_phone: null,
                amount: "",
                method: "MPESA"
            },

            otherNumber: false,
            options: ['MPesa', 'Voucher'],
            selectedOption: 'MPesa',

            validation: {
                other_phone: '',
                amount: '',
                method: '',
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
                !this.validation.method &&
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

        checkPhone(phoneObject) {
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
            if (amount >= 10 && amount <= 10000) {
                let amountRegex = /^\d+$/

                if (amountRegex.test(amount)) {
                    this.validation.amount = ''
                    this.form.amount = amount;
                } else {
                    this.validation.amount = "Please only put whole numbers"
                }
            } else {
                this.validation.amount = "Amount should be min of 10 and max of 10000"
            }
        },

        setOtherNumber(e) {
            this.otherNumber = e
        },

        setMethod(e) {
            this.form.method = e.toUpperCase()
        },

        async submit() {
            try {
                await this.buyAirtime(this.form).then(
                    (d) => {
                        console.log('success', d)
                        this.showError = false
                        // this.$router.push('/');
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
                console.log('loginVueError', error)

                this.showError = true
            }
        },
    },

}
</script>
