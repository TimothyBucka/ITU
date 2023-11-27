<template>
    <h1 class="py-3">Calendar</h1>

    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">

            <!-- <div v-for="(date, index) in dates" :key="date" class="carousel-item" :class="{ active: index == 0 }">
                <p>{{ date }}</p>
            </div> -->
            <div v-for="(date, index) in dates" :key="index" class="carousel-item" :class="{ active: index == 0 }">
                <p @click="selectDate(date)">{{ date }}</p>
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

    <!-- <div id="contentWrapper" class="content-wrapper">
        <div v-if="meals[selected_date]" class="calendar-content">
            <div v-for="meal in meals[selected_date]" :key="meal.id">
                <p>{{ meal.name }}</p>
            </div>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita excepturi voluptate corrupti repellat
                quasi veritatis fuga voluptatem rerum rem ea neque amet aliquid voluptates fugiat deleniti culpa ab,
                similique perferendis?</p>
            <p>Other content for meals, ike calories, their stats and so on</p>

    </div> -->
    <div id="contentWrapper" class="content-wrapper">
        <div v-show="meals[selected_date]" class="calendar-content">
            <div v-for="meal in meals[selected_date]" :key="meal.id">
                <p>{{ meal.name }}</p>
            </div>
            <p>Other content for meals, ike calories, their stats and so on</p>
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
            current_index: 0
        }
    },
    created() { 
        this.retrieveData();
    },

    computed: {
        current_date() {
          
            let carousel_items = document.querySelectorAll('.carousel-item');
           
            let active_carousel_item = carousel_items[this.current_index];
       
            let date = active_carousel_item ? active_carousel_item.textContent : null;
       
            return date;
        }
    },

    watch: {
        current_date(new_date) {
       
            console.log("TOTO JE NEW DATE: " + new_date);
            this.selected_date = new_date;
        }
    },
    
    selectDate(date) {
        console.log("TOTO JE SELECTED DATE: " + date);
        this.selected_date = date;
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
                this.formated_date = this.formatDate(this.dates[0]);
                this.dates.forEach(date => { // for each date, get the meals
                    date = this.formatDate(date);
                    this.retrieveMeals(date);
                })
            })
                .catch(error => {
                    console.log(error);
                });
        },


        retrieveMeals(date) {
            console.log("TOTO JE DATUM V RETRIEVE MEALS: " + date);
            const url = '/api/meals/date/' + date;
            axios.get(url).then(response => {
                this.meals[date] = response.data.meals; // add the meals to the meals object
                console.log("TOTO JE MEALS V RETRIEVE MEALS:" + this.meals[date]);
            })
                .catch(error => {
                    console.log(error);
                });
        },

        next() {
            if (this.current_index < this.dates.length - 1) // if the current index is not the last one
            {
                this.current_index++;
                this.selected_date = this.formatDate(this.dates[this.current_index]);

            }
        },

        prev() {
            if (this.current_index > 0) // if the current index is not the first one
            {
                this.current_index--;
                this.selected_date = this.formatDate(this.dates[this.current_index]);

            }
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
</style>