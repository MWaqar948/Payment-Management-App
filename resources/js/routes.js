const Login = () => import('./Pages/Auth/Login.vue')
const Logout = () => import('./Pages/Auth/Logout.vue')
const Register = () => import('./Pages/Auth/Register.vue')
const Home = () => import('./Pages/Home.vue')
const DoctorDashboard = () => import('./Pages/DoctorDashboard.vue')
const AdminDashboard = () => import('./Pages/AdminDashboard.vue')
const EmployeeDashboard = () => import('./Pages/EmployeeDashboard.vue')

export const routes = [
    {
        name: 'Logout',
        path: '/logout',
        component: Logout,
        meta: {
            requiresAuth: true
        }
    },
    {
        name: 'Login',
        path: '/login',
        component: Login,
        meta: {
            requiresAuth: false
        }
    },
    {
        name: 'Register',
        path: '/register',
        component: Register,
        meta: {
            requiresAuth: false
        }
    },

    {
        name: 'Home',
        path: '/',
        component: Home,
        
    },
    
    {
        name: 'EmployeeDashboard',
        path: '/employee/dashboard',
        component: EmployeeDashboard,
        meta: {
            requiresAuth: true
        }
    },
    
    {
        name: 'DoctorDashboard',
        path: '/doctor/dashboard',
        component: DoctorDashboard,
        meta: {
            requiresAuth: true
        }
    },

    {
        name: 'AdminDashboard',
        path: '/admin/dashboard',
        component: AdminDashboard,
        meta: {
            requiresAuth: true
        }
    }
]