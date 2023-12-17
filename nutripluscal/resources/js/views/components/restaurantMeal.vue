<!-- 
######################################### FILE: restaurantMeal.vue ###############################################
Authors: Timotej Bucka (xbucka00)
###############################################################################################################  
-->
<template>
    <div class="meal">
        <img :src="getImageUrl(Data.photo_path)" alt="meal image" width="100px"
            height="100px">
        <div class="meal-info">
            <div class="heading">
                <h5>{{ Index + 1 }}. {{ Data.name }}</h5>
                <h5>{{ Data.calories }} kcal</h5>
                <div class="infoShow">
                    <infoPopup :meal="Data" :portion="1" />
                </div>
            </div>
            <div class="add">
                <input type="date" v-model="date">
                <select class="form-select form-select-sm" v-model="meal_time">
                    <option v-for="time in meal_times" :key="time" :value="time">{{ time }}</option>
                </select>
                <select class="form-select form-select-sm" v-model="portion">
                    <option v-for="n in portions" :key="n" :value="n">{{ n }}</option>
                </select>
                <button class="btn btn-sm btn-primary" @click="storeMeal()">Add</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { getImageUrl } from "../../helpers";
import infoPopup from "./infoPopup.vue";

export default {
    props: {
        Data: {
            type: Object,
            required: true,
        },
        Index: {
            type: Number,
            required: true,
        },
    },
    components: {
        infoPopup,
    },
    data() {
        return {
            portions: [0.5, 1, 1.5, 2, 2.5, 3],
            portion: 1,
            date: "",
            meal_time: "Breakfast",
            meal_times: ["Breakfast", "Lunch", "Dinner", "Snacks"],
        }
    },
    created() {
        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        this.date = date;
    },
    methods: {
        getImageUrl,
        storeMeal() {
            const url = "/api/meals/eaten/"
            const data = {
                portion_size: this.portion,
                date: this.date,
                id: this.Data.id,
                time_of_meal: this.meal_time,
            }

            axios.post(url, data).then(response => {
                this.$toast.success(response.data.message, {
                    position: 'bottom-right',
                    duration: 2500,
                    closeOnClick: true,
                    pauseOnHover: true,
                });
            })
            .catch(error => {
                this.$toast.error(error.data.message, {
                    position: 'bottom-right',
                    timeout: 2000,
                    closeOnClick: true,
                    pauseOnHover: true,
                });
            });
        }
    },
};
</script>

<style scoped>
.meal {
    display: flex;
    width: 100%;
    height: fit-content;
    border-radius: 5px;
    border: 1px solid lightgrey;
    box-shadow: 0px 0.4px 3.5px rgba(0, 0, 0, 0.3);
    margin-top: 1rem;
}

img {
    height: 7rem;
    width: 7rem;
    object-fit: cover;
    border-right: 1px solid lightgrey;
}

.meal-info {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.heading {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 0.5rem;
    padding-right: 0;
}

.heading h5 {
    margin: 0;
}

.heading h5:nth-child(1) {
    flex: 1;
}

.heading svg {
    margin-left: 0.5rem;
    cursor: pointer;
}

.add {
    display: flex;
    justify-content: flex-end;
    padding: 0.5rem;
    padding-top: 0;
}

input[type="date"] {
    border: 0;
    font-size: 1.5rem;
    margin-right: 0.5rem;
}

input[type="date"]::-webkit-datetime-edit {
    display: none;
}

input[type="date"]:focus-visible {
    outline: none;
}

select {
    width: fit-content;
    border: none;
    cursor: pointer;
}

@media screen and (max-width: 450px) {
    .meal {
        flex-direction: column;
    }

    img {
        border-right: none;
        border-bottom: 1px solid lightgrey;
        width: 100%;
        height: 8rem;
    }

    .meal-info {
        padding: 0.5rem;
    }

}
</style>