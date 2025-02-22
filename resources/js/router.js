import { createRouter, createWebHistory } from 'vue-router';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import HomePage from './pages/HomePage.vue';
import EditPage from "./pages/EditPage.vue";

const routes = [
    { path: '/', component: Login },
    { path: '/register', component: Register },
    { path: '/home', component: HomePage },
    { path: '/edit/:type/:id', component: EditPage, name: 'editPage' }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
