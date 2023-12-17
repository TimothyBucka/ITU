<template>
    <template v-if="this.data.name">
        <img class="rest_img" :src="getImageUrl(this.data.photo_url)" alt="Restaurant image">

        <section id="info">
            <h1> {{ this.data.name }} </h1>
            <p id="type"> {{ this.data.type }} </p>
            <div>
                <font-awesome-icon icon="location-dot" />
                <p id="address"> {{ this.data.address }} </p>
            </div>
            <div>
                <font-awesome-icon icon="phone" />
                <p id="phone"> {{ this.data.phone }} </p>
            </div>
        </section>

        <section id="menu">
            <h2>Menu</h2>

            <template v-for="(item, index) in meals" :key="'meal-' + index">
                <mealTile :Data="item" :Index="index" />
            </template>

        </section>
    </template>

    <template v-if="this.not_found">
        Restaurant not found
    </template>
</template>


<script>
import { getImageUrl } from "../helpers";
import mealTile from "./components/mealTile.vue";

export default {
    data() {
        return {
            restaurant: this.$route.params.id,
            meals: {},
            data: {},
            not_found: false,
        }
    },
    components: {
        mealTile,
    },
    created() {
        this.retrieveData();
    },
    methods: {
        getImageUrl,
        retrieveData() {
            var url = '/api/restaurants/' + this.restaurant;
            axios.get(url).then(response => {
                this.data = response.data.data;
                this.meals = this.data.meals;
            })
                .catch(error => {
                    this.not_found = true;
                });
        }
    }
}
</script>

<style scoped>
.rest_img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    margin-top: 1rem;
    border-radius: 5px;
    box-shadow: 0px 0.4px 3.5px rgba(0, 0, 0, 0.3);
}

#info {
    margin: .5rem 0;
}

#info h1 {
    margin-bottom: 0;
}

#info div {
    display: flex;
    align-items: center;
}

#type {
    color: gray;
    margin-bottom: 0.5rem;
}

p:not(#type) {
    margin-bottom: 0;
    font-size: 1.1rem;
}

#info svg {
    margin-right: 1rem;
    color: darkolivegreen;
    height: 1rem;
    width: 1rem;
}

#menu {
    margin-top: 1rem;
    margin-bottom: 1rem;
}

#menu h2 {
    text-align: center;
}
</style>