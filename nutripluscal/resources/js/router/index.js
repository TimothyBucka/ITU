import { createRouter, createWebHistory } from "vue-router";

import home from "../views/home.vue";
import stats from "../views/stats.vue";
import restaurants  from "../views/restaurants.vue";
import your_meals from "../views/your_meals.vue";

const routes = [
    {
        path: "/",
        component: home,
        name: "home",
    },
    {
        path: "/stats",
        component: stats,
        name: "stats",
    },
    {
        path: "/restaurants",
        component: restaurants,
        name: "restaurants",
    },
    {
        path: "/y_meals",
        component: your_meals,
        name: "your_meals",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
