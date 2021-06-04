// Views
import TheContainer from "../containers/TheContainer";

const Dashboard = () => import('../views/Home')

const Register = () => import('../views/auth/Register')
const Login = () => import('../views/auth/Login')

const TransactionsIndex = () => import('../views/transactions/Index')
const InvitesIndex = () => import('../views/referrals/Index')


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
                path: '/transactions',
                name: 'transactions',
                component: TransactionsIndex
            },
            {
                path: '/invites',
                name: 'invites',
                component: InvitesIndex
            },
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
