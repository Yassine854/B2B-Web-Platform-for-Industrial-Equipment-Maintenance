
import {createWebHistory, createRouter} from "vue-router";


import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import forgotPassword from '../pages/ForgotPassword'
import resetPassword from '../pages/ResetPassword'
import Dashboard from '../pages/Dashboard';
import Profile from '../pages/Profile'

//Admin
import Users from '../components/admin/users'
import types_industrie from '../components/admin/type_industries'
import types_product from '../components/admin/type_products'
import products from '../components/admin/products'
import parc_clients from '../components/admin/parc_clients'
import parc from '../components/admin/parc'
import diagnostics from '../components/admin/diagnostics'
import interventions from '../components/admin/interventions'
import PageNotFound from '../pages/PageNotFound'

//Client
import client_interventions from '../components/client/intervention'

// import Dashboard from '../components/layouts/navvv.vue';
// import Posts from '../components/Posts';
// import EditPost from '../components/EditPost';
// import AddPost from '../components/AddPost';


export const routes = [
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: "Home",
        path: '/',
        component: Login
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'forgotPassword',
        path: '/forgot-password',
        component: forgotPassword,
      },
      {
        path: '/reset-password/:token/:email',
        name: 'reset-password',
        component: resetPassword,
      },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    //users
    {
    name: 'users',
    path: '/users/:societyValue?',
    component: Users,
    props:true,
    props: route => ({ societyValue: route.params.societyValue }), // Pass 'societyValue' parameter as a prop
    },

    //Profile
    {
        name: 'profile',
        path: '/profile',
        component: Profile
    },
    //type_industries
    {
        name: 'types_industrie',
        path: '/types_industrie',
        component: types_industrie
    },

    //types_produits
    {
        name: 'types_product',
        path: '/types_product',
        component: types_product
    },

    //produits
    {
        name: 'products',
        path: '/products',
        component: products
    },
    {
        name: 'parc_clients',
        path: '/parc_clients',
        component: parc_clients
    },
    {
        name: 'parc',
        path: '/parc_clients/:id',
        component: parc,
        props: true
    },
    {
        name: 'diagnostics',
        path: '/diagnostics',
        component: diagnostics
    },
    {
        name: 'interventions',
        path: '/interventions',
        component: interventions
    },
    {
        name: 'client_interventions',
        path: '/client_interventions',
        component: client_interventions
    },
    {
        name: 'notFound',
        path: '/:pathMatch(.*)*',
        component: PageNotFound,
      },


];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
