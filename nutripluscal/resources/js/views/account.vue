<template>
    <div class="intake">
        Suggested daily intake:
        <span>{{ data.daily_intake }} kcal</span>
    </div>

    <div class="tiles">
        <dataTile Name="Age" DB_name="age" :Value="data.age" Unit="" Editable=true
            @body-data-updated="handleBodyDataUpdated" v-if="data.age" />
        <dataTile Name="Height" DB_name="height" :Value="data.height" Unit="cm" Editable=true
            @body-data-updated="handleBodyDataUpdated" v-if="data.height" />
        <dataTile Name="Weight" DB_name="weight" :Value="data.weight" Unit="kg" Editable=true
            @body-data-updated="handleBodyDataUpdated" v-if="data.weight" />
        <dataTile Name="Target Weight" DB_name="goal_target" :Value="data.goal_target" Unit="kg" Editable=true
            @body-data-updated="handleBodyDataUpdated" v-if="data.goal_target" />
        <dataTile Name="BMI" DB_name="bmi" :Value="data.bmi" Unit="" v-if="data.bmi" />
    </div>
</template>

<script>
import dataTile from './components/dataTile.vue'

export default {
    components: {
        dataTile,
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

            this.$toast.success("Data updated", { // notification
                position: 'bottom-right',
                duration: 2500,
                closeOnClick: true,
                pauseOnHover: true,
            });
        }
    }
}

</script>

<style scoped>
.intake {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 1.5rem 0;
    font-size: 1.35rem;
}

.intake span {
    display: block;
    font-weight: bold;
    font-size: 3rem;
    color: darkolivegreen;
}

.tiles {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
</style>