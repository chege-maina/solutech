import { createRouter, createWebHistory } from "vue-router";

import store from "../store";

import Login from "../components/pages/Login.vue";
import ChangePsw from "../components/pages/ChangePsw.vue";
import ForgotPass from "../components/pages/ForgotPass.vue";
import Dashboard from "../components/pages/Dashboard.vue";
import NotFound from "../components/pages/NotFound.vue";

const routes = [
    {
        name: "Login",
        path: "/",
        component: Login,
        meta: {
            requiresAuth: false,
        },
    },
    {
        name: "ForgotPass",
        path: "/forgotpsw",
        component: ForgotPass,
        meta: {
            requiresAuth: false,
        },
    },
    {
        name: "ChangePsw",
        path: "/changepsw/:id",
        component: ChangePsw,
        props: true,
        meta: {
            requiresAuth: false,
        },
    },

    {
        name: "Dashboard",
        path: "/dashboard",
        component: Dashboard,
        meta: {
            requiresAuth: true,
        },
    },
    { name: "NotFound", path: "/:pathMatch(.*)*", component: NotFound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !store.getters.user) {
        return { name: "Login" };
    }
    if (to.meta.requiresAuth == false && store.getters.user) {
        return { name: "Dashboard" };
    }
});

export default router;