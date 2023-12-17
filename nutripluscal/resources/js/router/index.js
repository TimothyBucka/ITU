// ######################################### FILE: index.js ###############################################
// Authors: Adam Pap        (xpapad11)
//          Timotej Bucka   (xbucka00)
// ############################################################################################################ 

import { createRouter, createWebHistory } from "vue-router";

import home from "../views/home.vue";
import restaurants from "../views/restaurants.vue";
import restaurant from "../views/restaurant.vue";
import your_meals from "../views/your_meals.vue";
import calendar from "../views/calendar.vue";
import account from "../views/account.vue";
import search_meals from "../views/search_meals.vue";

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
        path: "/restaurants/:id",
        component: restaurant,
        name: "restaurants/id",
    },
    {
        path: "/y_meals",
        component: your_meals,
        name: "your_meals",
    },
    {
        path: "/search_meals/:date/:meal_type/:meal_arg",
        component: search_meals,
        name: "search_meals/date/meal_type/meal_arg",
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
