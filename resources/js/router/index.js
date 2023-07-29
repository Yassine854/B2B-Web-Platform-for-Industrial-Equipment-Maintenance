
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
// import Dashboard from '../components/layouts/navvv.vue';
// import Posts from '../components/Posts';
// import EditPost from '../components/EditPost';
// import AddPost from '../components/AddPost';

//Products
import productIndex from '../components/products/Index'

export const routes = [
    {
        name: 'register',
        path: '/register',
        component: Register
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
    {
        name: 'productIndex',
        path: '/products',
        component: productIndex
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
