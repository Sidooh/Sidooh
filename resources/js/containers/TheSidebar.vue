<template>
    <CSidebar
        :minimize="minimize"
        :show="show"
        fixed
        @update:show="(value) => $store.commit('set', ['sidebarShow', value])"
    >
        <CSidebarBrand class="d-md-down-none" to="/">
            <CIcon
                :height="35"
                :src="logoUrl"
                class="c-sidebar-brand-full"
                name="logo"
                size="custom-size"
                viewBox="0 0 556 134"
            />
            <CIcon
                :height="35"
                :src="logoMinUrl"
                class="c-sidebar-brand-minimized"
                name="logo"
                size="custom-size"
                viewBox="0 0 110 134"
            />
        </CSidebarBrand>

        <CRenderFunction :content-to-render="$options.nav" flat/>
        <CSidebarMinimizer
            class="d-md-down-none"
            @click.native="$store.commit('set', ['sidebarMinimize', !minimize])"
        />
    </CSidebar>
</template>

<script>
import nav from './_nav'

const image = require('../assets/img/logo.png')

export default {
    name: 'TheSidebar',
    nav,
    computed: {
        show() {
            return this.$store.state.sidebarShow
        },
        minimize() {
            return this.$store.state.sidebarMinimize
        },

        logoUrl() {
            return require('../assets/img/logo-dark.png')
        },
        logoMinUrl() {
            return require('../assets/img/logo-dark.png')
        }

    }
}
</script>
