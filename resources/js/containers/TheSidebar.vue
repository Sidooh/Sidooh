<template>
  <CSidebar
      :minimize="minimize"
      :show="show"
      fixed
      @update:show="(value) => $store.commit('set', ['sidebarShow', value])"
  >
    <CSidebarBrand class="d-md-down-none" to="/">
      Sidooh
      <!--      <CIcon -->
      <!--        class="c-sidebar-brand-full" -->
      <!--        name="logo" -->
      <!--        size="custom-size" -->
      <!--        :height="35" -->
      <!--        viewBox="0 0 556 134"-->
      <!--      />-->
      <!--      <CIcon-->
      <!--        class="c-sidebar-brand-minimized"-->
      <!--        name="logo"-->
      <!--        size="custom-size"-->
      <!--        :height="35"-->
      <!--        viewBox="0 0 110 134"-->
      <!--      />-->
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

export default {
  name: 'TheSidebar',
  nav,
  computed: {
    show() {
      return this.$store.state.sidebarShow
    },
    minimize() {
      return this.$store.state.sidebarMinimize
    }
  }
}
</script>
