<template>
    <div class="d-flex align-items-center min-vh-100">
        <CContainer fluid>
            <CRow class="justify-content-center">
                <CCol md="4">
                    <CCard class="mx-4 mb-0">
                        <CCardBody class="p-4">
                            <CForm v-if="registrationStep === 1" @submit.prevent="submitStepOne">
                                <h1>Register</h1>
                                <p class="text-muted">Create your account</p>
                                <span><b>Step 1:</b> Check your number.</span>

                                <vue-tel-input :invalidMsg="error" class="mt-3" @validate="checkPhone"></vue-tel-input>
                                <span v-if="error" class="text-danger text-sm font-sm text-center">{{ error }}</span>

                                <CButton :disabled="!validPhoneInput" block class="mt-3" color="success" type="submit">
                                    Proceed
                                </CButton>
                            </CForm>

                            <CForm v-if="registrationStep === 2" @submit.prevent="submitStepTwo">
                                <h1>Register</h1>
                                <p class="text-muted">Create your account</p>
                                <span><b>Step 2:</b> Verify your number.</span>

                                <span v-if="otp" class="alert-info, my-2">A code was sent to the number, please add it below.</span>

                                <CInput
                                    v-model="form.otp"
                                    autocomplete="otp"
                                    class="mt-3"
                                    min="100000"
                                    placeholder="Code"
                                    prepend="6"
                                    type="number"
                                    @input="checkOtp"
                                >
                                </CInput>

                                <p v-if="validation.otp" id="otpError" class="alert-warning">
                                    {{
                                        validation.otp
                                    }}
                                </p>

                                <CButton class="mt-3 float-left" color="secondary" @click="setRegistrationStep(1)">
                                    Back
                                </CButton>
                                <CButton :disabled="!validOtpInput" class="mt-3 float-right" color="success"
                                         type="submit">
                                    Proceed
                                </CButton>
                                <!--                                <CButton :disabled="!validOtpInput" class="mt-3 float-right" color="info">-->
                                <!--                                    Request code?-->
                                <!--                                </CButton>-->
                            </CForm>


                            <CForm v-if="registrationStep === 3" @submit.prevent="submitStepFinal">
                                <h1>Register</h1>
                                <p class="text-muted">Create your account</p>
                                <CInput
                                    v-model="form.name"
                                    autocomplete="name"
                                    placeholder="Name"
                                    @input="checkName"
                                >
                                    <template #prepend-content>
                                        <CIcon name="cil-user"/>
                                    </template>
                                </CInput>
                                <p v-if="validation.name" id="nameError" class="alert-warning">
                                    {{
                                        validation.name
                                    }}
                                </p>
                                <CInput
                                    v-model="form.email"
                                    autocomplete="email"
                                    placeholder="Email"
                                    prepend="@"
                                    type="email"
                                    @input="checkEmail"
                                />
                                <p v-if="validation.email" id="emailError" class="alert-warning">
                                    {{
                                        validation.email
                                    }}
                                </p>
                                <CInput
                                    v-model="form.password"
                                    autocomplete="new-password"
                                    placeholder="Password"
                                    type="password"
                                    @input="checkPassword"
                                >
                                    <template #prepend-content>
                                        <CIcon name="cil-lock-locked"/>
                                    </template>
                                </CInput>
                                <p v-if="validation.password" id="passwordError" class="alert-warning">
                                    {{ validation.password }}
                                </p>

                                <CInput
                                    v-model="form.confirmPassword"
                                    autocomplete="new-password"
                                    class="mb-4"
                                    placeholder="Repeat password"
                                    type="password"
                                    @input="checkConfirmPassword"
                                >
                                    <template #prepend-content>
                                        <CIcon name="cil-lock-locked"/>
                                    </template>
                                </CInput>
                                <p v-if="validation.confirmPassword" id="confirmPasswordError" class="alert-warning">
                                    {{ validation.confirmPassword }}
                                </p>

                                <CButton :disabled="!validForm" block color="success" type="submit">Create Account
                                </CButton>
                            </CForm>
                        </CCardBody>
                        <CCardFooter class="p-4">
                            <CRow>
                                <CCol col="6" md="12">
                                    <router-link :to="{ name: 'login' }">

                                        <CButton block color="facebook">
                                            Already have an account?
                                        </CButton>
                                    </router-link>
                                </CCol>
                            </CRow>
                        </CCardFooter>
                    </CCard>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'Register',
    data() {
        return {

            form: {
                phone: '',
                otp: '',
                name: '',
                email: '',
                password: '',
                confirmPassword: ''
            },

            validation: {
                otp: '',
                name: '',
                email: '',
                password: '',
                confirmPassword: ''
            },

            otp: null,

            password_length: 0,
            contains_eight_characters: false,
            contains_number: false,
            contains_uppercase: false,
            contains_special_character: false,


            valid_name: false,
            valid_email: false,
            valid_password: false,
            valid_password_confirmation: false,

            validPhoneInput: false,
            validOtpInput: false,
            error: null
        }
    },

    computed: {
        ...mapGetters("auth", ["registrationStep", "errors"]),

        validForm() {
            return this.valid_name && this.valid_email && this.valid_password && this.valid_password
        }
    },

    mounted() {
        if (!this.validPhoneInput && this.registrationStep !== 1) {
            this.setRegistrationStep(1)
        }
    },

    methods: {
        ...mapActions('auth', [
            "registerCheckPhone", "setRegistrationStep", "register",
        ]),

        checkPhone(phoneObject) {
            if (phoneObject.valid) {
                let safRegex = /^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$/

                if (safRegex.test(phoneObject.number)) {
                    this.validPhoneInput = true
                    this.error = null
                    this.form.phone = phoneObject.number.replace("+", "");
                } else {
                    this.validPhoneInput = false
                    this.error = "Only Safaricom numbers are currently supported. Please try again."
                }
            }
        },

        async submitStepOne() {
            const phone = {
                "phone": this.form.phone,
            }

            try {
                await this.registerCheckPhone(phone).then(
                    (d) => {
                        console.log('success', d)
                        if (d.acc.user) {
                            this.form.name = d.acc.user.name;
                            this.form.email = d.acc.user.email;

                            this.checkName()
                            this.checkEmail()
                        }

                        this.otp = d.otp;

                        this.setRegistrationStep(2)
                    },
                    error => {
                        console.log('error', error)

                        if (error.error) {
                            this.showError = true
                        }

                        this.loading = false;
                        this.error =
                            (error.data && error.data.message) ||
                            error.message || error.error ||
                            error.toString();
                    });

            } catch (error) {
                console.log('regVueError', error)

                this.showError = true
            }
        },


        async submitStepTwo() {
            if (parseInt(this.form.otp) === this.otp) {
                this.setRegistrationStep(3)
            }
        },

        checkOtp() {
            const format = /^[0-9]{6}$/;

            if (this.form.otp.length === 6) {
                const m = format.test(this.form.otp);

                if (m && parseInt(this.form.otp) === this.otp) {
                    this.validation.otp = ''
                    this.validOtpInput = true
                    this.setRegistrationStep(3)
                    //    TODO: Notify user of successful otp
                } else {
                    this.validation.otp = 'Please check code sent to the number or go back and try again.'
                    this.validOtpInput = false
                }

            } else {
                this.validation.otp = ''
                this.validOtpInput = false
            }

        },

        checkName() {
            const format = /^[A-z ,\.&'-]{3,}$/;

            this.form.name = this.form.name.trim()
            const m = format.test(this.form.name);

            if (m && this.form.name.length > 0) {
                this.validation.name = ''
                this.valid_name = true
            } else {
                this.validation.name = 'Please put at least 3 characters for the name'
                this.valid_name = false
            }
        },

        checkEmail() {
            const format = /^([a-z0-9\+_\-]{2,})(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]{2,}\.)+[a-z]{2,6}$/;

            const m = format.test(this.form.email);

            if (m && this.form.email.length > 0) {
                this.validation.email = ''
                this.valid_email = true
            } else {
                this.validation.email = 'Please match the correct email format'
                this.valid_email = false
            }
        },

        checkPassword() {
            this.password_length = this.form.password.length;
            const format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

            if (this.password_length >= 8) {
                this.contains_eight_characters = true;
            } else {
                this.validation.password = 'Needs to be 8 characters.'
                this.contains_eight_characters = false;
            }

            this.contains_number = /\d/.test(this.form.password);
            this.contains_uppercase = /[A-Z]/.test(this.form.password);
            this.contains_special_character = format.test(this.form.password);

            if (this.contains_eight_characters === true &&
                this.contains_special_character === true &&
                this.contains_uppercase === true &&
                this.contains_number === true) {
                this.valid_password = true;
                this.validation.password = ''
            } else {
                this.valid_password = false;
                this.validation.password = 'Should contain special, capital characters and number'
            }

            if (this.form.password.length === 0) {
                this.validation.password = ''
            }
        },

        checkConfirmPassword() {
            if (this.form.confirmPassword.length === this.form.password.length) {
                if (this.form.confirmPassword === this.form.password) {
                    this.validation.confirmPassword = ''
                    this.valid_password_confirmation = true
                } else {
                    this.validation.confirmPassword = 'Passwords do not match'
                    this.valid_password_confirmation = false
                }
            } else {
                this.validation.confirmPassword = ''
                this.valid_password_confirmation = false
            }
        },

        async submitStepFinal() {
            console.log(this.validForm, "Final step")

            if (!this.validForm) {
                return false
            }

            this.form.password_confirmation = this.form.confirmPassword

            try {
                await this.register(this.form).then(
                    (d) => {
                        console.log('success', d)
                        this.$router.push('/');
                    },
                    error => {
                        console.log('error', error)

                        if (error.error) {
                            this.showError = true
                        }

                        this.loading = false;
                        this.error =
                            (error.response && error.response.data) ||
                            error.message || error.error ||
                            error.toString();
                    });

            } catch (error) {
                console.log('regVueError', error)

                this.showError = true
            }
        },
    }
}
</script>
