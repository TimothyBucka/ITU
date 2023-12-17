<!--
######################################### FILE: calendar.vue ###############################################
Authors: Adam Pap       (xpapad11)
         Tobias Stec    (xstect00)
############################################################################################################
-->

<template>
    <h1 class="py-3">Calendar</h1>

    <div id="carouselExample" class="carousel slide"> <!--CAROUSEL -->
        <div class="carousel-inner">
            <div v-for="(date, index) in dates" :key="index" class="carousel-item"
                :class="{ active: index == dates.length - 1 }">
                <p>{{ date }}</p>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev"
            @click="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next"
            @click="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div><br>

    <div v-for="(meal, date) in meals" :key="date"> <!--GENERAL DIV -->
        <div class="stats">
            <div class="calories_stats">
                <div class="icon">
                    <font-awesome-icon icon="utensils" />
                </div>

                <div class="calories_accepted">
                    <p>{{ totalCalories(meal) }}/{{ daily_intake }} kcal</p>
                </div>

                <div class="percents">
                    <p>{{ ((daily_intake ? (totalCalories(meal) / daily_intake) : 0) * 100).toFixed(1) }}%</p>
                </div>

            </div>

            <div class="nutritions_stats">

                <div class="proteins">
                    <p>Proteins: {{ totalNutritions(meal).proteins }}g</p>
                    <div class="progress-bar"
                        :style="{ '--initial-progress': ((totalNutritions(meal).proteins / getPercentage(daily_intake).proteinsPercentage) * 100) + '%' }">
                        <p>{{ ((totalNutritions(meal).proteins / getPercentage(daily_intake).proteinsPercentage) * 100
                        ).toFixed(1) }}%</p>
                    </div>
                </div>

                <div class="fibers">
                    <p>Fibers: {{ totalNutritions(meal).fibers }}g</p>
                    <div class="progress-bar"
                        :style="{ '--initial-progress': ((totalNutritions(meal).fibers / getPercentage(daily_intake).fibersPercentage) * 100) + '%' }">
                        <p>{{ ((totalNutritions(meal).fibers / getPercentage(daily_intake).fibersPercentage) * 100
                        ).toFixed(1) }}%</p>
                    </div>
                </div>

                <div class="fats">
                    <p>Fats: {{ totalNutritions(meal).fats }}g</p>
                    <div class="progress-bar"
                        :style="{ '--initial-progress': ((totalNutritions(meal).fats / getPercentage(daily_intake).fatsPercentage) * 100) + '%' }">
                        <p>{{ ((totalNutritions(meal).fats / getPercentage(daily_intake).fatsPercentage) * 100).toFixed(1)
                        }}%</p>
                    </div>
                </div>

                <div class="carbs">
                    <p>Carbs: {{ totalNutritions(meal).carbs }}g</p>
                    <div class="progress-bar"
                        :style="{ '--initial-progress': ((totalNutritions(meal).carbs / getPercentage(daily_intake).carbsPercentage) * 100) + '%' }">
                        <p>{{ ((totalNutritions(meal).carbs / getPercentage(daily_intake).carbsPercentage) * 100
                        ).toFixed(1) }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion" id="accordion">
            <div class="accordion-item" v-for="(accordion, index) in accordions" :key="index">
                <h2 class="accordion-header" :id="'heading' + accordion.id">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        :data-bs-target="'#collapse' + accordion.id" aria-expanded="false"
                        :aria-controls="'collapse' + accordion.id">
                        <p>{{ accordion.name }}</p>
                    </button>
                    <button class="btn btn-primary add-meal-btn" @click="modalGetMeals(accordion.name)"
                        :class="{ 'collapsed': isActive !== index }">
                        <font-awesome-icon icon="plus" />
                    </button>
                </h2>
                <div :id="'collapse' + accordion.id" class="accordion-collapse collapse"
                    aria-labelledby="'heading' + item.id" :data-bs-parent="isActive === index ? '#accordion' : null">
                    <div class="accordion-body">
                        <div v-for="(item, index) in meal" :key="index">
                            <div v-if="item.meal_time === accordion.name">
                                <div class="food">
                                    <div v-if="(item.meals != undefined || item.meal != null)">
                                        <p>{{ item.meal[0].name }}</p>
                                        <div class="foodButtons">
                                            <p>{{ item.meal[0].calories * item.portion_size }} kcal</p>

                                            <div class="infoShow">
                                                <infoPopup :meal="item.meal[0]" :portion="item.portion_size" />
                                            </div>

                                            <button class="btn foodbtn" href="#" @click="delete_meal(item.id)">
                                                <font-awesome-icon icon="remove" />
                                            </button>
                                        </div>
                                    </div>
                                    <p>Portion: {{ item.portion_size }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="isToday(selected_date) && Object.keys(meals).length !== 0" class="recommended">
        <recommendedMeals :calories="totalCalories(meals[selected_date])"
            :proteins="totalNutritions(meals[selected_date]).proteins"
            :fibers="totalNutritions(meals[selected_date]).fibers" :fats="totalNutritions(meals[selected_date]).fats"
            :carbs="totalNutritions(meals[selected_date]).carbs"
            :numberOfMeals="meals[selected_date] ? meals[selected_date].length : 0" :wantedCalories="daily_intake"
            :wantedProteins="getPercentage(daily_intake).proteinsPercentage"
            :wantedFibers="getPercentage(daily_intake).fibersPercentage"
            :wantedFats="getPercentage(daily_intake).fatsPercentage"
            :wantedCarbs="getPercentage(daily_intake).carbsPercentage" />
    </div>
</template>

<script>
import { parse, format } from 'date-fns';
import infoPopup from './components/infoPopup.vue';
import recommendedMeals from './components/recommendedMeals.vue';

export default {
    data() {
        return {
            dates: [],
            isActive: null, // to chnage the color behinfd the accordion button
            time_of_meal: null, // breakfast, lunch, dinner, snack
            accordions: [
                { id: 1, name: 'Breakfast' },
                { id: 2, name: 'Lunch' },
                { id: 3, name: 'Dinner' },
                { id: 4, name: 'Snacks' },
            ], // to generate accordions 
            daily_intake: 0,
            meals: {},
            all_meals: {},
            selected_date: null,
            current_index: 0,
            calculatedPercentage: 0,
            can_navigate: true,
            show_modal: false,
            selected_meal: [] // selected meals from the modal
        }
    },

    components: {
        infoPopup,
        recommendedMeals
    },

    created() { // when the component is created
        this.retrieveData();
    },

    watch: { // watch is for the asynchronous operations in response for the data change
        current_date(new_date) {
            this.selected_date = new_date;
        }
    },

    methods: {
        // toggle(index) { // toggle the accordion to change the color behind the button
        //     this.isActive = this.isActive === index ? null : index;
        // },

        totalCalories(meal) {
            let total = 0;
            if (meal) {
                for (let item of meal) {
                    if (Array.isArray(item.meal) && item.meal.length > 0) { // chceck if there is something in the field
                        total += item.meal[0].calories;
                    } else {
                        break;
                    }
                }
            }
            return total;
        },

        totalNutritions(meal) {
            let total = {
                proteins: 0,
                fibers: 0,
                fats: 0,
                carbs: 0
            };
            if (meal) {
                for (let item of meal) {
                    if (Array.isArray(item.meal) && item.meal.length > 0) { // chceck if there is something in the field
                        total.proteins += item.meal[0].proteins;
                        total.fibers += item.meal[0].fibers;
                        total.fats += item.meal[0].fats;
                        total.carbs += item.meal[0].carbs;
                    } else {
                        break;
                    }
                }
            }
            return total;
        },

        getPercentage(value) {
            let total = {
                proteinsPercentage: 0,
                fibersPercentage: 0,
                fatsPercentage: 0,
                carbsPercentage: 0
            };
            if (value) {
                total.proteinsPercentage = (value * 0.25) / 4;
                total.fibersPercentage = (value * 0.1) / 10;
                total.fatsPercentage = (value * 0.25) / 9;
                total.carbsPercentage = (value * 0.52) / 4;
            } else {
                total.proteinsPercentage = 0;
                total.fibersPercentage = 0;
                total.fatsPercentage = 0;
                total.carbsPercentage = 0;
            }
            return total;
        },

        delete_meal(meal_id) { // delete meal from the database
            axios
                .post('/api/meals/eaten/delete/' + meal_id)
                .then(response => {
                    this.retrieveMeals(this.selected_date); // refresh it after added to show the new data

                    this.$toast.success(response.data.message, { // notification
                        position: 'bottom-right',
                        duration: 2500,
                        closeOnClick: true,
                        pauseOnHover: true,
                    });
                })
                .catch(error => {
                    console.log(error);
                    this.$toast.error(response.data.message, {
                        position: 'bottom-right',
                        timeout: 2000,
                        closeOnClick: true,
                        pauseOnHover: true,
                    });
                });
        },

        modalGetMeals(type_of_meal_arg) { // fetch the meals from the database to the modal
            //reference to the search_meals.vue
            this.$router.push({
                name: 'search_meals/date/meal_type', 
                params: { date: this.selected_date, meal_type: type_of_meal_arg }
            });
        },

        formatDate(date_string) {
            const parsed_date = parse(date_string, 'EEEE do \'of\' MMMM yyyy', new Date());
            return format(parsed_date, 'yyyy-MM-dd');
        },

        retrieveData() {
            var url = '/api/generate_dates/';
            axios.get(url).then(response => {
                this.dates = response.data.dates;
                this.current_index = this.dates.length - 1; // set current index to the last index
                this.formated_date = this.formatDate(this.dates[this.current_index]); // format the last date
                this.retrieveMeals(this.formated_date); // retrieve the meals for the last date\
                this.selected_date = this.formated_date;
            })
                .catch(error => {
                    console.log(error);

                });

            var url = '/api/body/1';
            axios.get(url).then(response => {
                this.daily_intake = response.data.data.daily_intake;
            });
        },

        isToday(date) {
            const today = new Date();
            const selectedDate = new Date(date);

            return (
                today.getFullYear() === selectedDate.getFullYear() &&
                today.getMonth() === selectedDate.getMonth() &&
                today.getDate() === selectedDate.getDate()
            );
        },

        retrieveMeals(date) {
            this.meals = {};
            const url = '/api/meals/date/' + date;
            return axios.get(url).then(response => {
                this.meals[date] = response.data; // add the meals to the meals object
            })
                .catch(error => {
                    console.log(error);
                });
        },

        // Carousel buttons
        next() {
            if (!this.can_navigate) return; // to prevent double clikcing and then submiting the request twice
            this.can_navigate = false;

            if (this.current_index < this.dates.length - 1) // if the current index is not the last one increment it and if the current index is the last one, reset it to 0
            {
                this.current_index++;
            }
            else {
                this.current_index = 0;
            }

            this.selected_date = this.formatDate(this.dates[this.current_index]);
            setTimeout(() => {
                this.retrieveMeals(this.selected_date).then(() => {
                    this.can_navigate = true;
                });
            }, 500);

        },

        prev() {
            if (!this.can_navigate) return;
            this.can_navigate = false;

            if (this.current_index > 0) {
                this.current_index--;
            }
            else {
                this.current_index += this.dates.length - 1;
            }
            this.selected_date = this.formatDate(this.dates[this.current_index]);
            setTimeout(() => {
                this.retrieveMeals(this.selected_date).then(() => {
                    this.can_navigate = true;
                });
            }, 500);

        },

    },
}
</script>

<style scoped>
/*----------------------------- Modal (popup) -----------------------------*/

.modal {
    display: flex;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal button {
    background-color: #556B2F;
    border: none;
    border-radius: 0.15em;
    padding: 0.35em;
    color: #ffffff;
}

.modal-content {
    margin: auto;
}

.meal-list {
    overflow-y: auto;
}

.meal-modal-div {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5em 0;
    border-bottom: 1px solid #dee2e6;
}

.meal-modal-div:active {
    background-color: #eaeaec;
}

.close {
    color: #a30707;
    font-size: 3em;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity .5s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

/*----------------------------- CAROUSEL -----------------------------*/
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: black;
}

.carousel-item {
    text-align: center;
}

.container {
    max-width: 90%;
    margin: auto;
}

.carousel-inner {
    height: 50px;
    line-height: 50px;
    text-align: center;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
}

.carousel-inner .carousel-item {
    height: 200px;
}

.carousel-inner p {
    display: inline-block;
    vertical-align: middle;
    line-height: normal;
}

/*----------------------------- Stats of meals (percentage...), buttons -----------------------------*/
.buttons {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 10px;
    border-radius: .25rem;
    margin-top: 2%;
}

.btn {
    margin-right: 10px;
}

.stats {
    margin: 2% 0;
    display: grid;
}

.calories_stats {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 10px 0;
    background: #647c58;
    color: white;
    font-size: 1.2em;
    border-top-right-radius: 0.25rem;
    border-top-left-radius: 0.25rem;
}

.calories_stats p {
    margin: 0;
}

.calories_accepted,
.percents,
.icon {
    flex: 1;
    text-align: center;
}

/*----------------------------- Accordion -----------------------------*/
.accordion-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #556B2F;
    border-radius: 5px;
}

.add-meal-btn {
    margin-left: auto;
    border-radius: 100%;
    padding: 0.1em 0.5em !important;
    vertical-align: middle;
    font-size: 0.8em;
    line-height: 1.4em;
    margin-left: 0.4em;
}

.accordion-body {
    padding: 0.25em 0.5em;
}

.food p:first-child {
    margin-bottom: 0;
}

.food div:first-child {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #dee2e6;
    font-size: 1em;
    font-weight: bold;
    padding: 0.5em 0;
}


.foodButtons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1em;
}

.foodbtn {
    display: flex;
    border: none;
    margin: 0;
    padding: 0.1em 0.2em !important;
    font-size: 1.5em;
}

.foodButtons p {
    margin-right: 0.7em;
    margin-bottom: 0;
}

.collapse {
    &:not(.show) {
        display: none;
    }
}


/*****************************************************/


/* .add-meal-btn:not(.collapsed) {
    background-color: #eaeaec;
} */

.nutritions_stats {
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-top: none;
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
}

.nutritions_stats>div {
    flex: 1;
    min-width: 25%;
}

.proteins,
.fibers,
.fats,
.carbs {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 8px;
}

.nutritions_stats p {
    white-space: nowrap;
}

.progress-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 4em;
    height: 4em;
    border-radius: 50%;
    background:
        radial-gradient(closest-side, white 79%, transparent 80% 100%),
        conic-gradient(#647c58 var(--initial-progress), #d2dbcd 0);
}

.progress-bar p {
    margin-top: 1em;
    margin-left: 0.25em;
    font-size: 1rem;
    font-weight: bold;
}


@media only screen and (max-width: 500px) {
    .nutritions_stats {
        flex-wrap: wrap;
    }

    .nutritions_stats>div {
        min-width: 50%;
    }
}
</style>