<template>
    <div class="d-flex align-items-center min-vh-100">
        <CContainer fluid>
            <CRow class="justify-content-center">
                <CCol md="6">
                    <CCard class="mx-4 mb-0">
                        <CCardBody class="p-4">
                            <CForm>
                                <h1>Register</h1>
                                <p class="text-muted">Create your account</p>
                                <CInput
                                    autocomplete="username"
                                    placeholder="Username"
                                >
                                    <template #prepend-content>
                                        <CIcon name="cil-user"/>
                                    </template>
                                </CInput>
                                <CInput
                                    autocomplete="email"
                                    placeholder="Email"
                                    prepend="@"
                                />
                                <CInput
                                    autocomplete="new-password"
                                    placeholder="Password"
                                    type="password"
                                >
                                    <template #prepend-content>
                                        <CIcon name="cil-lock-locked"/>
                                    </template>
                                </CInput>
                                <CInput
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
                                <CCol col="6">
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
export default {
    name: 'Register'
}
</script>
