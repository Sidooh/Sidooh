// Views
import TheContainer from "../containers/TheContainer";

const Dashboard = () => import('../views/Home')

const Register = () => import('../views/auth/Register')
const Login = () => import('../views/auth/Login')

const TransactionsIndex = () => import('../views/transactions/Index')
const InvitesIndex = () => import('../views/referrals/Index')
const EarningsIndex = () => import('../views/earnings/Index')
const FinancesIndex = () => import('../views/accounts/Index')


const AirtimePurchase = () => import('../views/purchases/Airtime')
const AirtimeStatus = () => import('../views/purchases/AirtimeStatus')
const VoucherPurchase = () => import('../views/purchases/Voucher')
const VoucherStatus = () => import('../views/purchases/VoucherStatus')
const SubscriptionPurchase = () => import('../views/purchases/Subscription')
const MerchantPurchase = () => import('../views/purchases/Merchant')


const routes = [
    {
        path: '/',
        redirect: '/dashboard',
        // name: 'dashboard',
    },

    {
        path: "/dashboard",
        component: TheContainer,
        children: [
            {
                path: '',
                name: 'dashboard',
                component: Dashboard
            },
            {
                path: 'purchase',
                component: {
                    render(c) {
                        return c('router-view')
                    }
                },
                children: [
                    {
                        path: 'airtime',
                        name: 'airtime',
                        component: AirtimePurchase,
                        meta: {
                            title: 'Airtime Purchase',
                        }
                    },
                    {
                        path: 'airtime/:id',
                        name: 'airtime_status',
                        component: AirtimeStatus,
                        meta: {
                            title: 'Airtime Status',
                        }
                    },
                    {
                        path: 'voucher',
                        name: 'voucher',
                        component: VoucherPurchase,
                        meta: {
                            title: 'Voucher Purchase',
                        }
                    },
                    {
                        path: 'voucher/:id',
                        name: 'voucher_status',
                        component: VoucherStatus,
                        meta: {
                            title: 'Voucher Status',
                        }
                    },
                    {
                        path: 'subscription',
                        name: 'subscription',
                        component: SubscriptionPurchase,
                        meta: {
                            title: 'Subscription Purchase',
                        }
                    },
                    {
                        path: 'merchant',
                        name: 'merchant',
                        component: MerchantPurchase,
                        meta: {
                            title: 'Merchant Purchase',
                        }
                    },
                ]
            },
            {
                path: 'transactions',
                name: 'transactions',
                component: TransactionsIndex
            },
            {
                path: 'invites',
                name: 'invites',
                component: InvitesIndex
            },
            {
                path: 'earnings',
                name: 'earnings',
                component: EarningsIndex
            },
            {
                path: 'account',
                component: {
                    render(c) {
                        return c('router-view')
                    }
                },
                children: [
                    {
                        path: 'finances',
                        name: 'Finances',
                        component: FinancesIndex,
                        meta: {
                            title: 'Finances',
                        }
                    },

                ]
            }
        ],
    },

    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            title: 'Login',
            requiresAuth: false,
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            requiresAuth: false,
        },
    }
]

export default routes;
