
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Profile from '../components/client/Profile'

//users
import UserIndex from '../components/admin/users/index'
import UserCreate from '../components/admin/users/create'

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
        component: UserIndex
    },
    {
        name: 'createUser',
        path: '/users/create',
        component: UserCreate
    },
    //Profile
    {
        name: 'profile',
        path: '/profile',
        component: Profile
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
