<template>
    <div>
        <h1 class="py-3">Home</h1>
        <div v-if="data.length">

            <h4 class="py-1">Last visited:</h4>
            <div v-if="visited_rest.length">
                <div v-for="(item, index) in visited_rest" :key="'visited-' + index">
                    <p><strong>Name:</strong> {{ item.name }}</p>
                    <p><strong>Address:</strong> {{ item.address }}</p><br>
                </div>
            </div>
            <div v-else>
                <p>No restaurants visited yet.</p>
            </div>

            <h4 class="py-1">Other restaurants:</h4>
            <div v-if="not_visited_rest.length">
                <div v-for="(item, index) in not_visited_rest" :key="'not_visited-' + index">
                    <p><strong>Name:</strong> {{ item.name }}</p>
                    <p><strong>Address:</strong> {{ item.address }}</p><br>
                </div>
            </div>
            <div v-else>
                <p>No restaurants around you.</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {},
            visited_rest: [],
            not_visited_rest: []
        }
    },
    created() {
        this.retrieveData();
    },
    methods: {
        retrieveData() {
            const url = '/api/restaurants/';
            axios.get(url).then(response => {
                this.data = response.data.data;
                this.visited_rest = this.data.filter(item => item.visited === 1); // get the visited restaurants
                this.not_visited_rest = this.data.filter(item => item.visited === 0); // get the not visited restaurants
            })
                .catch(error => {
                    console.log(error);
                });
        },
        // handleBodyDataUpdated() {
        //     this.retrieveData();
        // }
    }
}
</script>

<style scoped>

</style>