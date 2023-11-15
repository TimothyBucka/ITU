import { createRouter, createWebHistory } from "vue-router";

import page_ddx from "../views/page_ddx.vue";

const routes = [
    {
        path: "/page_ddx",
        component: page_ddx,
        name: "page_ddx",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
