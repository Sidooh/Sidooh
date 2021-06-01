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
                                <span><b>Step 1:</b> Confirm your number.</span>

                                <vue-tel-input :invalidMsg="error" class="mt-3" @validate="checkPhone"></vue-tel-input>
                                <span v-if="error" class="text-danger text-sm font-sm text-center">{{ error }}</span>

                                <CButton :disabled="!validPhoneInput" block class="mt-3" color="success" type="submit">
                                    Proceed
                                </CButton>
                            </CForm>
                            <CForm v-if="registrationStep === 2" @submit.prevent="submitStepFinal">
                                <h1>Register</h1>
                                <p class="text-muted">Create your account</p>
                                <CInput
                                    v-model="form.name"
                                    autocomplete="name"
                                    placeholder="Name"
                                    required
                                >
                                    <template #prepend-content>
                                        <CIcon name="cil-user"/>
                                    </template>
                                </CInput>
                                <CInput
                                    v-model="form.email"
                                    autocomplete="email"
                                    placeholder="Email"
                                    prepend="@"
                                />
                                <CInput
                                    v-model="form.password"
                                    autocomplete="new-password"
                                    placeholder="Password"
                                    type="password"
                                >
                                    <template #prepend-content>
                                        <CIcon name="cil-lock-locked"/>
                                    </template>
                                </CInput>
                                <CInput
                                    v-model="form.confirmPassword"
                                    autocomplete="new-password"
                                    class="mb-4"
                                    placeholder="Repeat password"
                                    type="password"
                                >
                                    <template #prepend-content>
                                        <CIcon name="cil-lock-locked"/>
                                    </template>
                                </CInput>
                                <CButton block color="success">Create Account</CButton>
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
                                <!--                <CCol col="6">-->
                                <!--                  <CButton block color="twitter">-->
                                <!--                    Twitter-->
                                <!--                  </CButton>-->
                                <!--                </CCol>-->
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
                name: '',
                email: '',
                password: '',
                confirmPassword: ''
            },

            validPhoneInput: false,
            error: null
        }
    },

    computed: {
        ...mapGetters("auth", ["registrationStep", "errors"])
    },

    methods: {
        ...mapActions('auth', [
            "registerCheckPhone", "setRegistrationStep"
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
                        if (d.user) {
                            this.form.name = d.user.name;
                            this.form.email = d.user.email;
                        }

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

        async submitStepFinal() {
            // const phone = {
            //     "phone": this.form.phone,
            // }

            try {
                await this.register(this.form).then(
                    (d) => {
                        console.log('success', d)
                        // this.registrationStep = 2
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
