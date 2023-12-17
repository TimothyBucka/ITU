<!-- 
######################################### FILE: restaurants.vue ###############################################
Authors: Timotej Bucka (xbucka00)
############################################################################################################### 
-->

<template>
    <h1 class="py-3">Restaurants</h1>

    <section id="search">
        <restaurantSearch label="Search" placeholder="Search for restaurants" api_url="/api/restaurants/search"
            @search="search" />
        <div class="searched" v-if="searched">
            <router-link v-for="(item, index) in searched.slice(0, 3)" :key="'searched-' + index"
                :to="{ name: 'restaurants/id', params: { id: item.id } }" style="text-decoration: none; color: inherit;" class="item">
                    <p>{{ item.name }} - <span> {{ item.address }} </span></p>
                    <span> {{ item.type }} </span>
            </router-link>

            <p v-if="searched.length <= 0" class="item">No results found.</p>
        </div>
    </section>

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
                <template v-for="(item, index) in most_visited" :key="'visited-' + index">
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
import restaurantSearch from './components/restaurantSearch.vue';
import { RouterLink } from 'vue-router';

export default {
    components: {
        restaurantTile,
        restaurantSearch,
        RouterLink,
    },

    data() {
        return {
            recently_visited: [],
            most_visited: [],
            searched: null,
        }
    },

    created() {
        var url = '/api/restaurants/last_visited';
        axios.get(url).then(response => {
            this.recently_visited = response.data.data;
        });

        url = '/api/restaurants/most_visited';
        axios.get(url).then(response => {
            this.most_visited = response.data.data;
        });
    },

    methods: {
        search(data) {
            this.searched = data;
        }
    }
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
    position: relative;
}

.searched {
    position: absolute;
    z-index: 2;
    width: 100%;
    margin-top: 0.5rem;
    border-radius: 5px;
    border: 1px solid lightgray;
    box-shadow: 0px 0.4px 1.25px rgba(0, 0, 0, 0.3);
    background-color: white;
}

.searched p {
    margin: 0;
}

.item {
    padding: 0.5rem;
    display: flex;
    flex-direction: column;
    border-bottom: 1px solid lightgray;
}

.item:last-child {
    border-bottom: none;
}

.item span {
    font-size: 0.8rem;
    color: gray;
}
</style>