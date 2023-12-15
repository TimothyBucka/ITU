<template>
    <h1 class="py-3">Calendar</h1>

    <div id="carouselExample" class="carousel slide">
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

    <div class="buttons">
        <a class="btn btn-primary" href="#" @click="modalGetMeals">Add Meal</a>
    </div>

    <div v-for="(meal, date) in meals" :key="date">
        <div class="calories_stats">
            <div class="icon">
                <font-awesome-icon icon="utensils" />
            </div>

            <div class="calories_accepted">
                <p>{{ totalCalories }}/{{ daily_intake }} kcal</p> <!-- TODO rework this to backend -->
            </div>

            <div class="percents">
                <p>{{ ( (daily_intake ? (totalCalories / daily_intake) : 0) * 100).toFixed(1) }}%</p>
            </div>
        </div><br>

        <div v-for="(item, index) in meal" :key="index">
            <div class="accordion" id="mealAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" :id="'heading' + index">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            :data-bs-target="'#collapse' + index" aria-expanded="false"
                            :aria-controls="'collapse' + index">
                            <div v-if="item.meals != undefined || item.meal != null">
                                {{ item.meal[0].name }} ({{ item.meal[0].calories }} kcal)
                            </div>
                        </button>
                    </h2>
                    <div :id="'collapse' + index" class="accordion-collapse collapse"
                        aria-labelledby="'heading' + index"
                        :data-bs-parent="isActive === index ? '#mealAccordion' : null">
                        <div class="accordion-body">
                            <div v-if="item.meals != undefined || item.meal != null">
                                <strong>Calories:</strong> {{ item.meal[0].calories }}<br>
                                <strong>Proteins:</strong> {{ item.meal[0].proteins }}<br>
                                <strong>Fibers:</strong> {{ item.meal[0].fibers }}<br>
                                <strong>Fats:</strong> {{ item.meal[0].fats }}<br>
                                <strong>Carbs:</strong> {{ item.meal[0].carbs }}
                                <div class="buttons">
                                    <a class="btn btn-warning" href="#" @click="delete_meal(item.id)">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
        <transition name="fade">
            <div v-if="show_modal" class="modal">
                <div class="modal-content">
                    <span class="close" @click="closeModal">&times;</span>
                    <p>Select a meal:</p>
                    <div class="meal-list">
                        <div v-for="(meal, index) in all_meals" :key="index" @click="selectMeal(meal)">
                            <div v-if="!isMealAlreadyAdded(meal)">
                                <div class="meal-modal-div">
                                    <p>{{ meal.name }}</p>
                                    <!-- TODO portion size -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <button @click="addSelectedMeal">Add</button>
                </div>
            </div>
        </transition>

</template>

<script>
import { parse, format } from 'date-fns';

export default {
    data() {
        return {
            dates: [],
            daily_intake: 0,
            meals: {},
            all_meals: {},
            selected_date: null,
            current_index: 0,
            can_navigate: true,
            show_modal: false,
            selected_meal: [] // selected meals from the modal
        }
    },

    created() { // when the component is created
        this.retrieveData();
    },

    watch: { // watch is for the asynchronous operations in response for the data change
        current_date(new_date) {
            this.selected_date = new_date;
        }
    },

    computed: { // computed is for the data that is calculated from the data that is already in the component
        totalCalories() {
            let total = 0;
            if (this.meals[this.selected_date] && this.meals != undefined) {
                for (let item of this.meals[this.selected_date]) {
                    if (Array.isArray(item.meal) && item.meal.length > 0) { // chceck if there is something in the field
                        total += item.meal[0].calories;
                    } else {
                        break;
                    }
                }
            }
            return total;
        },
    },

    methods: {
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

        modalGetMeals() { // fetch the meals from the database to the modal
            this.all_meals = {};
            axios.get('/api/meals/').then(response => {
                this.all_meals = response.data.data;
                this.show_modal = true; // show the modal with the meals
            })
                .catch(error => {
                    console.log(error);
                });
        },

        closeModal() {
            // when the meal is selected but the user closes the modal, update the meal object 
            if (this.selected_meal.length > 0) {
                this.meals[this.selected_date] =
                    this.meals[this.selected_date].filter(selected_meal => selected_meal.id !== this.selected_meal[0].id); // remove the meal from the meals object
            }

            this.selected_meal = []; // reset the selected meals
            this.show_modal = false;
        },

        selectMeal(meal) { // select a meal from the modal
            // chceck if the meal is already selected by the user
            let index = this.selected_meal.findIndex(selected_meal => selected_meal.id === meal.id);

            if (index === -1) {
                this.selected_meal.push(meal); // add the meal to the selected meals

                if (!this.meals[this.selected_date]) {
                    this.meals[this.selected_date] = [];
                }
                this.meals[this.selected_date].push(meal); // Add the selected meal to the meals object

            } else {
                this.selected_meal = this.selected_meal.filter(selected_meal => selected_meal.id !== meal.id); // remove the meal from the selected meals
                this.meals[this.selected_date] = this.meals[this.selected_date].filter(selected_meal => selected_meal.id !== meal.id); // remove the meal from the meals object
            }
        },

        addSelectedMeal() {
            // Send the selected meals to the API (post request) and cycle through the array with the index from 0 to n
            for (let i = 0; i < this.selected_meal.length; i++) {
                this.selected_meal[i].date = this.selected_date;
                axios
                    .post('/api/meals/eaten/', this.selected_meal[i])
                    .then(response => {
                        this.retrieveMeals(this.selected_date); // Refresh it after added to show the new data

                        this.$toast.success(response.data.message, { // notification
                            position: 'bottom-right',
                            duration: 2500,
                            closeOnClick: true,
                            pauseOnHover: true,
                        });

                        this.closeModal();
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
            }

            this.selected_meal = []; // reset the selected meals
        },

        isMealAlreadyAdded(meal_modal) { // check if the meal is already added to the date
            if (this.meals[this.selected_date]) { // if there are meals for the selected date
                for (let item of this.meals[this.selected_date]) { // loop through them
                    if (Array.isArray(item.meal) && item.meal.length > 0) { // if the meal is already selected
                        if (item.meal[0].name == meal_modal.name) {
                            return true; // selected --> don't show it
                        }
                    }
                }
            }
            return false; // not selected --> good to go
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
                this.retrieveMeals(this.formated_date); // retrieve the meals for the last date
            })
            .catch(error => {
                console.log(error);

            });

            var url = '/api/body/1';
            axios.get(url).then(response => {
                this.daily_intake = response.data.data.daily_intake;
            });
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
            }, 1);

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
            }, 1);

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
    border-radius: 2px;
    padding: 0.35em;
    color: #ffffff;
}

.modal-content {
    background-color: #ffffff;
    margin: auto;
    padding: 20px;
    padding-top: 0;
    border: 1px solid #888;
    width: 80%;
}

.meal-list {
    max-height: 300px;
    overflow-y: auto;
}

.meal-modal-div {
    border: 1px solid black;
    padding: 10px;
    margin: 10px;
    cursor: pointer;
    flex: 1;
}

.close {
    color: #a30707;
    float: right;
    font-size: 40px;
    font-weight: bold;
    max-width: 45px;
    max-height: 45px;
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
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

.calories_stats {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 10px 0;
    background: #647c58;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    margin-top: 2%;
    color: white;
    font-size: 23px;
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
</style>