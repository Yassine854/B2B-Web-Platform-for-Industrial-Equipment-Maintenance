
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Profile from '../components/client/Profile'


import Users from '../components/admin/users'
import types_industrie from '../components/admin/type_industries'
import types_product from '../components/admin/type_products'
import products from '../components/admin/products'


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
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    //users
    {
        name: 'users',
        path: '/users',
        component: Users
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
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
