<template>
    <div class="container">
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
            <a class="btn btn-primary" href="#">Add Activity</a>
        </div>


        <div v-for="(meal, date) in meals" :key="date">
            <div class="calories_stats">
                <div class="icon">
                    <font-awesome-icon icon="utensils" />
                </div>

                <div class="calories_accepted">
                    <p>{{ totalCalories }}/2450 kcal</p>
                </div>

                <div class="percents">
                    <p>{{ ((totalCalories / 2450) * 100).toFixed(1) }}%</p>
                </div>
            </div><br>

            <div v-for="(item, index) in meal" :key="index">
                <div class="accordion" id="mealAccordion">
                    <div class="accordion-item" v-for="(meal, index) in meals" :key="index">
                        <h2 class="accordion-header" :id="'heading' + index">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                :data-bs-target="'#collapse' + index" aria-expanded="false"
                                :aria-controls="'collapse' + index">
                                {{ item.meal[0].name }}
                            </button>
                        </h2>
                        <div :id="'collapse' + index" class="accordion-collapse collapse"
                            aria-labelledby="'heading' + index" data-bs-parent="#mealAccordion">
                            <div class="accordion-body">
                                <strong>Calories:</strong> {{ item.meal[0].calories }}<br>
                                <strong>Proteins:</strong> {{ item.meal[0].proteins }}<br>
                                <strong>Fibers:</strong> {{ item.meal[0].fibers }}<br>
                                <strong>Fats:</strong> {{ item.meal[0].fats }}<br>
                                <strong>Carbs:</strong> {{ item.meal[0].carbs }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div v-if="showModal" class="modal">
            <div class="modal-content">
                <span class="close" @click="closeModal">&times;</span>
                <p>Select a meal:</p>
                <div v-for="(meal, index) in all_meals" :key="index" @click="selectMeal(meal)">
                    <div v-if="!isMealAlreadyAdded(meal)">
                        <div class="meal-modal-div">
                            <p>{{ meal.name }}</p>
                            <!--TODO portion size-->
                        </div>
                    </div>
                </div>
                <button @click="addSelectedMeal">Add</button>
            </div>
        </div>

    </div>
</template>

<script>
import { parse, format } from 'date-fns';

export default {
    data() {
        return {
            dates: [],
            meals: {},
            all_meals: {},
            selected_date: null,
            current_index: 0,
            can_navigate: true,
            showModal: false,
            selectedMeal: []
        }
    },

    created() { // when the component is created
        this.retrieveData();
    },

    watch: {
        current_date(new_date) {
            this.selected_date = new_date;
        }
    },

    computed: {
        totalCalories() {
            let total = 0;
            if (this.meals[this.selected_date] && this.meals[this.selected_date].length > 0) {
                for (let item of this.meals[this.selected_date]) {
                    total += item.meal[0].calories;
                }
            }
            return total;
        },
    },

    methods: {
        modalGetMeals() { // fetch the meals from the database to the modal
            this.all_meals = {};
            axios.get('/api/meals/').then(response => {
                this.all_meals = response.data.data;
                this.showModal = true; // show the modal with the meals
            })
                .catch(error => {
                    console.log(error);
                });
        },

        closeModal() {
            this.showModal = false;
        },

        selectMeal(meal) { // select a meal from the modal
            // chceck if the meal is already selected by the user
            let index = this.selectedMeal.findIndex(selectedMeal => selectedMeal.id === meal.id);

            if (index === -1) {
                this.selectedMeal.push(meal); // add the meal to the selected meals
            } else {
                this.selectedMeal.splice(index, 1); // remove the meal from the selected meals
            }
            this.meals[this.selected_date].push(meal); // Add the selected meal to the meals object
        },

        addSelectedMeal() {
            // Send the selected meals to the API (post request) and cycle through the array with the index from 0 to n
            for (let i = 0; i < this.selectedMeal.length; i++) {
                this.selectedMeal[i].date = this.selected_date;
                axios
                    .post('/api/meals/eaten/', this.selectedMeal[i])
                    .then(response => {
                        //console.log("Meal added" + response);
                        this.retrieveMeals(this.selected_date); // Refresh it after added to show the new data

                        this.$toast.success(response.data.message, { // notification
                            position: 'top-right',
                            duration: 2500,
                            closeOnClick: true,
                            pauseOnHover: true,
                        });
                    })
                    .catch(error => {
                        console.log(error);
                        this.$toast.error(response.data.message, {
                            timeout: 2000,
                            closeOnClick: true,
                            pauseOnHover: true,
                        });
                    });
            }

            this.selectedMeal = []; // reset the selected meals
        },

        isMealAlreadyAdded(meal_modal) { // check if the meal is already added to the date
            if (this.meals[this.selected_date]) { // if there are meals for the selected date
                for (let item of this.meals[this.selected_date]) { // loop through them
                    if (item.meal[0].name == meal_modal.name) { // if the meal is already selected
                        return true;
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
            const url = '/api/generate_dates/';
            axios.get(url).then(response => {
                this.dates = response.data.dates;
                this.current_index = this.dates.length - 1; // set current index to the last index
                this.formated_date = this.formatDate(this.dates[this.current_index]); // format the last date
                this.retrieveMeals(this.formated_date); // retrieve the meals for the last date
            })
                .catch(error => {
                    console.log(error);

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

<style>
/*----------------------------- Modal (popup) -----------------------------*/
.meal-modal-div {
    border: 1px solid black;
    padding: 10px;
    margin: 10px;
    cursor: pointer;
    flex: 1;
}

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

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
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
    padding: 10px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    margin-top: 2%;
}

.calories_accepted,
.percents,
.icon {
    flex: 1;
    text-align: center;
}
</style>