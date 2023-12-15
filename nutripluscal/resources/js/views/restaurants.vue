<template>
    <h1 class="py-3">Restaurants</h1>

    <h4>Recently visited:</h4>

    <template v-for="(item, index) in recently_visited" :key="'visited-' + index">
        <restaurantTile :Data="item" />
    </template>

    <h4>You like the most:</h4>


</template>

<script>
import axios from 'axios';
import restaurantTile from './components/restaurantTile.vue';

export default {
    components: {
        restaurantTile,
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
            console.log(this.recently_visited);
        });
    },
}

</script>

<style scoped>

</style>