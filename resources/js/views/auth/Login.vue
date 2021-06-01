<template>
    <div class="c-app flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol md="8">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardBody>
                                <CForm @submit.prevent="submit">
                                    <h1>Login</h1>
                                    <p class="text-muted">Sign In to your account</p>

                                    <p v-if="showError" id="error" class="alert-warning">Username or Password is
                                        incorrect</p>

                                    <vue-tel-input :invalidMsg="error" class="mt-3"
                                                   @validate="checkPhone"></vue-tel-input>
                                    <p v-if="errors.phone" id="phoneError" class="alert-warning">
                                        {{
                                            errors.phone[0]
                                        }}
                                    </p>
                                    <CInput
                                        v-model="form.password"
                                        autocomplete="curent-password"
                                        placeholder="Password"
                                        type="password"
                                        class="mt-3 mb-0"
                                    >
                                        <template #prepend-content>
                                            <CIcon name="cil-lock-locked"/>
                                        </template>
                                    </CInput>
                                    <p v-if="errors.password" id="passwordError" class="alert-warning">
                                        {{
                                            errors.password[0]
                                        }}
                                    </p>

                                    <CRow>
                                        <CCol class="text-left" col="6">
                                            <CButton class="px-4 mt-3" color="primary" type="submit">Login</CButton>
                                        </CCol>
                                        <CCol class="text-right" col="6">
                                            <CButton class="px-0" color="link">Forgot password?</CButton>
                                            <router-link :to="{ name: 'register' }">
                                                <CButton class="d-lg-none" color="link">Register now!</CButton>
                                            </router-link>
                                        </CCol>
                                    </CRow>

                                </CForm>
                            </CCardBody>
                        </CCard>
                        <CCard
                            body-wrapper
                            class="text-center py-5 d-md-down-none"
                            color="primary"
                            text-color="white"
                        >
                            <CCardBody>
                                <h2>Sign up</h2>
                                <p>Welcome to Sidooh</p>
                                <router-link :to="{ name: 'register' }">

                                    <CButton
                                        color="light"
                                        size="lg"
                                        variant="outline"
                                    >
                                        Register Now!
                                    </CButton>
                                </router-link>
                            </CCardBody>
                        </CCard>
                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";

export default {
    name: 'Login',

    data() {
        return {
            form: {
                phone: "",
                password: "",
            },
            showError: false,
            loading: false,
            message: '',
            error: null
        };
    },

    computed: {
        ...mapGetters("auth", ["isAuthenticated", "errors"])
    },

    created() {
        if (this.isAuthenticated) {
            this.$router.push('/');
        }
    },

    methods: {
        ...mapActions('auth', [
            "login",
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

        async submit() {
            try {
                await this.login(this.form).then(
                    (d) => {
                        console.log('success', d)
                        this.showError = false
                        this.$router.push('/');
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
