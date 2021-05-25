import VueRouter from "vue-router";
import routes from './routes';
import store from "../store";

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior: () => ({y: 0}),
    routes
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth ?? true);

    if (requiresAuth && !store.state.auth.isAuthenticated) next('login')
    else next();
})


// router.beforeEach((to, from, next) => {
//     if (to.matched.some((record) => record.meta.guest)) {
//         if (store.getters.isAuthenticated) {
//             next("/posts");
//             return;
//         }
//         next();
//     } else {
//         next();
//     }
// });

export default router;
