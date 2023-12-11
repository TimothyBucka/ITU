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
            <a class="btn btn-primary" href="#">Add Meal</a>
            <a class="btn btn-primary" href="#">Add Activity</a>
        </div>

        <div v-for="(meal, date) in meals" :key="date">
            <div v-if="meal.length > 0">

                <div class="calories_stats">
                    <div class="icon">
                       <p>some icon</p> 
                    </div>

                    <div class="calories_accepted">
                        <p>{{ totalCalories }}/2450 kcal</p>
                    </div>

                    <div class="percents">
                        <p>{{ ((totalCalories/2450)*100).toFixed(1) }}%</p>
                    </div>
                </div>

                <div v-for="(item, index) in meal" :key="index">
                    {{ item.meal[0].name }}
                </div>
            </div>
            <div v-else>
                <p>No meals for this day.</p>
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
            selected_date: null,
            current_index: 0,
            can_navigate: true
        }
    },

    created() {
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
            for (let item of this.meals[this.selected_date]) {
                total += item.meal[0].calories;
            }
            return total;
        },
    },

    methods: {

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


                this.retrieveMeals(this.formated_date);
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

                this.meals[date].forEach(meal => {
                    console.log(meal.meal[0].name);
                });
            })
                .catch(error => {
                    console.log(error);
                });
        },

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
            }, 50);

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
            }, 50);

        },

    },
}
</script>

<style>
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

.buttons{
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

.calories_accepted, .percents, .icon {
    flex: 1;
    text-align: center;
}
</style>