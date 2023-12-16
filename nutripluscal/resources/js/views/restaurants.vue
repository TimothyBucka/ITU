<template>
    <h1 class="py-3">Restaurants</h1>

    <section id="recently">
        <h4>Recently visited:</h4>

        <div class="wrapper">
            <div class="slider">
                <template v-for="(item, index) in recently_visited" :key="'visited-' + index">
                    <router-link :to="{ name: 'restaurants/id', params: { id: item.id } }"
                        style="text-decoration: none; color: inherit;">
                        <restaurantTile :Data="item" />
                    </router-link>
                </template>
            </div>
        </div>
    </section>

    <section id="liked">
        <h4>You like the most:</h4>

        <div class="wrapper">
            <div class="slider">
                <template v-for="(item, index) in recently_visited" :key="'visited-' + index">
                    <router-link :to="{ name: 'restaurants/id', params: { id: item.id } }"
                        style="text-decoration: none; color: inherit;">
                        <restaurantTile :Data="item" />
                    </router-link>
                </template>
            </div>
        </div>
    </section>

</template>

<script>
import axios from 'axios';
import restaurantTile from './components/restaurantTile.vue';
import { RouterLink } from 'vue-router';

export default {
    components: {
        restaurantTile,
        RouterLink,
    },

    data() {
        return {
            recently_visited: [],
        }
    },

    created() {
        var url = '/api/restaurants/';
        axios.get(url).then(response => {
            this.recently_visited = response.data.data;
        });
    },
}

</script>

<style scoped>
.wrapper {
    width: 100%;
    overflow: scroll;
    overflow-y: hidden;
}

.slider {
    display: flex;
    width: fit-content;
}

section {
    margin-bottom: 2rem;
}
</style>