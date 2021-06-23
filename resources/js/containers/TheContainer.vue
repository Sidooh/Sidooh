<template>
    <div class="c-app">
        <TheSidebar/>
        <CWrapper>
            <TheHeader/>
            <div class="c-body">
                <main class="c-main">
                    <CContainer fluid>
<!--                        TODO: Change loader for axios to top bar and leave this for internal loading-->
                        <loader :is-visible="loading"></loader>
                        <transition mode="out-in" name="fade">
                            <router-view :key="$route.path"></router-view>
                        </transition>
                    </CContainer>
                </main>
            </div>
            <TheFooter/>
        </CWrapper>
    </div>
</template>

<script>
import TheSidebar from './TheSidebar'
import TheHeader from './TheHeader'
import TheFooter from './TheFooter'
import {mapState} from "vuex";
import Loader from "../views/Loader";

export default {
    name: 'TheContainer',
    components: {
        Loader,
        TheSidebar,
        TheHeader,
        TheFooter
    },
    computed: {
        ...mapState('loader', ['loading'])
    }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
