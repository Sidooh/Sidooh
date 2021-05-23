<template>
    <router-view></router-view>
    <!--    <the-container></the-container>-->
</template>

<script>
import TheContainer from "./containers/TheContainer";

export default {
    name: "App",
    components: {TheContainer},
}
</script>

<style lang="scss">
/* Import Main styles for this application*/
@import 'assets/scss/style';
</style>
