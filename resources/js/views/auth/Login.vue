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

                                    <CInput
                                        v-model="form.username"
                                        autocomplete="username email"
                                        placeholder="Username"
                                    >
                                        <template #prepend-content>
                                            <CIcon name="cil-user"/>
                                        </template>
                                        <template v-if="errors.username" #invalid-feedback>
                                            {{ errors.username[0] }}
                                        </template>
                                    </CInput>
                                    <CInput
                                        v-model="form.password"
                                        autocomplete="curent-password"
                                        placeholder="Password"
                                        type="password"
                                    >
                                        <template #prepend-content>
                                            <CIcon name="cil-lock-locked"/>
                                        </template>
                                        <template v-if="errors.password" #invalid-feedback>
                                            {{ errors.password[0] }}
                                        </template>
                                    </CInput>

                                    <CRow>
                                        <CCol class="text-left" col="6">
                                            <CButton class="px-4" color="primary" type="submit">Login</CButton>
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
                username: "",
                password: "",
            },
            showError: false,
            loading: false,
            message: ''

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

        async submit() {
            // const User = new FormData();
            // User.append("username", this.form.username);
            // User.append("password", this.form.password);
            //
            // console.log(User);
            //
            const User = {
                "username": this.form.username,
                "password": this.form.password
            }

            try {
                await this.login(User).then(
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
