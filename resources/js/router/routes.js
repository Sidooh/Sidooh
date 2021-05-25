// Views
import TheContainer from "../containers/TheContainer";

const Dashboard = () => import('../views/Home')

const Register = () => import('../views/auth/Register')
const Login = () => import('../views/auth/Login')


const routes = [
    {
        path: '/',
        redirect: '/dashboard',
        name: 'dashboard',
        component: TheContainer,
        children: [
            {
                path: '',
                name: 'home',
                component: Dashboard
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
