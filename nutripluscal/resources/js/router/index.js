import { createRouter, createWebHistory } from "vue-router";

import restaurants  from "../views/restaurants.vue";
import your_meals from "../views/your_meals.vue";
import calendar from "../views/calendar.vue";
import account from "../views/account.vue";

const routes = [
    {
        path: "/",
        component: calendar,
        name: "home",
    },
    {
        path: "/account",
        component: account,
        name: "account",
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
    {
        path: "/calendar",
        component: calendar,
        name: "calendar",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
