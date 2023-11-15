<template>
    <main class="container-md">
        <h1>Body data</h1>
        <div class="tiles">
            <dataTile Name="Age" DB_name="age" :Value="data.age" Unit="" Editable=true
                @body-data-updated="handleBodyDataUpdated" />
            <dataTile Name="Height" DB_name="height" :Value="data.height" Unit="cm" Editable=true
                @body-data-updated="handleBodyDataUpdated" />
            <dataTile Name="Weight" DB_name="weight" :Value="data.weight" Unit="kg" Editable=true
                @body-data-updated="handleBodyDataUpdated" />
            <dataTile Name="Goal Weight" DB_name="goal_target" :Value="data.goal_target" Unit="kg" Editable=true
                @body-data-updated="handleBodyDataUpdated" />
            <dataTile Name="BMI" DB_name="bmi" :Value="data.bmi" Unit="" />
        </div>

        <router-link to="/page_ddx">DDX</router-link> <!-- Link defined in router -->
        <router-view></router-view>

    </main>
</template>

<script>
import { RouterLink } from 'vue-router';
import dataTile from './views/dataTile.vue'

export default {
    components: {
        dataTile,
        RouterLink
    },
    data() {
        return {
            data: {}
        }
    },
    created() {
        this.retrieveData();
    },
    methods: {
        retrieveData() {
            const url = '/api/body/1';
            axios.get(url).then(response => {
                this.data = response.data.data;
            })
                .catch(error => {
                    console.log(error);
                });
        },
        handleBodyDataUpdated() {
            this.retrieveData();
        }
    }
}

</script>

<style scoped>
.tiles {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
}
</style>