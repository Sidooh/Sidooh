<template>
    <CDropdown
        add-menu-classes="pt-0"
        class="c-header-nav-items"
        inNav
        placement="bottom-end"
    >
        <template #toggler>
            <CHeaderNavLink>
                <div class="c-avatar">
                    <CIcon
                        class="c-avatar-img "
                        :src="avatarIcon"
                    />
                </div>
            </CHeaderNavLink>
        </template>
        <CDropdownHeader class="text-center" color="light" tag="div">
            <strong>Account</strong>
        </CDropdownHeader>
        <CDropdownItem>
            <CIcon name="cil-user"/>
            Profile
        </CDropdownItem>
        <!--        <CDropdownItem>-->
        <!--            <CIcon name="cil-bell"/>-->
        <!--            Profile-->
        <!--&lt;!&ndash;            <CBadge class="mfs-auto" color="info">{{ itemsCount }}</CBadge>&ndash;&gt;-->
        <!--        </CDropdownItem>-->
        <!--        <CDropdownItem>-->
        <!--            <CIcon name="cil-envelope-open"/>-->
        <!--            Messages-->
        <!--            <CBadge class="mfs-auto" color="success">{{ itemsCount }}</CBadge>-->
        <!--        </CDropdownItem>-->
        <!--        <CDropdownItem>-->
        <!--            <CIcon name="cil-task"/>-->
        <!--            Tasks-->
        <!--            <CBadge class="mfs-auto" color="danger">{{ itemsCount }}</CBadge>-->
        <!--        </CDropdownItem>-->
        <!--        <CDropdownItem>-->
        <!--            <CIcon name="cil-comment-square"/>-->
        <!--            Comments-->
        <!--            <CBadge class="mfs-auto" color="warning">{{ itemsCount }}</CBadge>-->
        <!--        </CDropdownItem>-->
        <!--        <CDropdownHeader-->
        <!--            class="text-center"-->
        <!--            color="light"-->
        <!--            tag="div"-->
        <!--        >-->
        <!--            <strong>Settings</strong>-->
        <!--        </CDropdownHeader>-->
        <CDropdownItem>
            <CIcon name="cil-settings"/>
            Settings
        </CDropdownItem>
        <!--        <CDropdownItem>-->
        <!--            <CIcon name="cil-dollar"/>-->
        <!--            Payments-->
        <!--            <CBadge class="mfs-auto" color="secondary">{{ itemsCount }}</CBadge>-->
        <!--        </CDropdownItem>-->
        <!--        <CDropdownItem>-->
        <!--            <CIcon name="cil-file"/>-->
        <!--            Projects-->
        <!--            <CBadge class="mfs-auto" color="primary">{{ itemsCount }}</CBadge>-->
        <!--        </CDropdownItem>-->
        <CDropdownDivider/>
        <!--        <CDropdownItem>-->
        <!--            <CIcon name="cil-shield-alt"/>-->
        <!--            Lock Account-->
        <!--        </CDropdownItem>-->
        <CDropdownItem @click="signout">
            <CIcon name="cil-lock-locked"/>
            Logout
        </CDropdownItem>
    </CDropdown>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'TheHeaderDropdownAccnt',
    data() {
        return {
            itemsCount: 42
        }
    },

    computed: {
        ...mapGetters('auth', ['user']),

        avatarIcon() {
            return require('../assets/img/avatars/1.jpg')
        }
    },

    methods: {
        ...mapActions('auth', ['logout']),

        async signout() {

            await this.logout().then(
                () => {
                    console.log('success', 'Logout')
                    this.$router.push('/login');
                });
        }
    }

}
</script>

<style scoped>
.c-icon {
    margin-right: 0.3rem;
}
</style>
