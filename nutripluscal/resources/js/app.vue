<template>
    <nav class="navbar navbar-expand-md bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <router-link class="navbar-brand" to="/">NutriPlusCal</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" aria-current="page" to="/">Home</router-link> <!-- Link defined in router -->
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" aria-current="page" to="/restaurants">Restaurants</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" aria-current="page" to="/y_meals">Yours meals</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" aria-current="page" to="/calendar">Calendar</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" aria-current="page" to="/account">Account</router-link>
                    </li>

                </ul>
            </div>
        </div>   
    </nav>
    <main class="container-md">
        <router-view></router-view> <!-- this will render the active page  -->
    </main>

</template>

<script>
import { RouterLink } from 'vue-router';

export default {
    components: {
        RouterLink
    },
}
</script>