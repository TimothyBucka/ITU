<!-- 
######################################### FILE: recommendedMeals.vue ###############################################
Authors: Tobias Stec (xstect00)
###############################################################################################################  
-->
<template>
    <button class="btn btn-secondary recommended" @click=funkcia>
        <p>Recommended meals for today</p>
    </button>
    <div v-if="showRecommendedPopup" class="info-popup">
      <div class="popup-content">
        <div class="header">
            <h2>Recommended meals for today</h2>
            <span class="close" @click="closeRecommendedPopup">&times;</span>
        </div>
        <div class="body">
            <p v-if="recommended_meals.length == 0">No recommended meals for today</p>
            <div v-else>
                <p v-for="meal in recommended_meals">
                    {{ meal.name }}
                <br>
                <div class="name">
                    {{ meal.restaurant_name }}
                    <div v-if="meal.restaurant_name==null">
                        From your meals
                    </div>
                </div>
                </p>
            </div>
        </div>
      </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        props: {
            numberOfMeals: {
                required: true,
            },
            calories: {
                required: true,
            },
            proteins: {
                required: true,
            },
            fibers: {
                required: true,
            },
            fats: {
                required: true,
            },
            carbs: {
                required: true,
            },
            wantedCalories: {
                required: true,
            },
            wantedProteins: {
                required: true,
            },
            wantedFibers: {
                required: true,
            },
            wantedFats: {
                required: true,
            },
            wantedCarbs: {
                required: true,
            },
        },
        data() {
            return {
                showRecommendedPopup: false,
                recommended_meals: [],
                pomocna: 0,
            };
        },
        methods: {
            closeRecommendedPopup() {
                this.showRecommendedPopup = false;
            },

            async funkcia() {
                this.showRecommendedPopup = true;
                var data = {
                numberOfMeals: this.numberOfMeals,
                calories: this.calories,
                proteins: this.proteins,
                fibers: this.fibers,
                fats: this.fats,
                carbs: this.carbs,
                wantedCalories: this.wantedCalories,
                wantedProteins: this.wantedProteins,
                wantedFibers: this.wantedFibers,
                wantedFats: this.wantedFats,
                wantedCarbs: this.wantedCarbs,
                };

                await axios.put('/api/meals/recommended', data).then(response => {
                    this.recommended_meals = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
                },

        },
    };
</script>
  
<style scoped>

    button.recommended {
        display: flex;
        margin: 0.75em auto;
        font-size: 1em;
    }

    button p {
        margin: 0.25em;
        padding-bottom: 0.15em;
    }

    .info-popup {
        display: flex;
        position: fixed;
        z-index: 5;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.4);
    }
    
    .popup-content {
        background-color: #ffffff;
        max-width: 90%;
        text-align: center;
        min-width: 70%;
        border-radius: 0.5em;
    }

    .header {
        display: flex;
        background-color: #556B2F;
        color: white;
        width: 100%;
        align-items: center;
        position: relative;
        border-top-right-radius: 0.5em;
        border-top-left-radius: 0.5em;
    }

    .header h2 {
        font-size: 1.5em;
        margin: 0.5em;
        flex-grow: 1;
    }
    
    .close {
        color: #eaeaec;
        font-size: 2.5em;
        cursor: pointer;
        display: contents;
    }

    .body {
        text-align: left;
        padding: 2em;
    }

    .body p {
        border: 1px solid lightgray;
        padding: 0.5em;
        border-radius: 0.5em;
        margin: 0;
    }

    .name {
        font-size: 0.8em;
        color: gray;
    }
    
    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
    }

    @media only screen and (max-width: 500px) {
        .popup-content {
            max-width: 85%;
            min-width: 75%;
        }
    }
</style>
  