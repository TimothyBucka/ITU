<template>
    <div>
      <!-- Search bar -->
      <input v-model="searchQuery" @input="filterMeals" class="form-control mb-3 search" placeholder="Search for meals">
  
      <h2 v-if="searchQuery!==''">Results</h2>
      <h2 v-else>Meals</h2>
  
      <div v-if="filteredMeals.length==0" class="noResult">
          <h3> No results found </h3>
      </div>
      <!-- List of meals -->  
    <div class="list">
        <div v-for="meal in filteredMeals" :key="meal.id" class="meal-cell" @click="selectMeal(meal)" :class="{ 'selected-meal': selectedMeal === meal }">
            <div class="showMeals">
                {{ meal.name }}
                <input type="number" value="1"/>
                <button class="btn plus">
                    <font-awesome-icon icon="plus" />
                </button>
            </div>
        </div>
      </div>
    </div>
</template>
  
  <script>
    import axios from 'axios';

  export default {
    data() {
      return {
        meals: [],
        searchQuery: '',
        selectedMeal: null,
      };
    },
    computed: {
      filteredMeals() {
        // Filter meals based on the search query
        return this.meals.filter(meal => meal.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
      },
    },
    methods: {
      // Function to fetch meals from your database
      fetchMeals() {
        axios.get('/api/meals').then(response => {
          this.meals = response.data.data;
        });
      },
      // Function to filter meals based on the search query
        filterMeals() {
            if (this.meals.length === 0) {
            this.fetchMeals();
            }
        },

        selectMeal(meal) {
            if (this.selectedMeal === meal) {
                this.selectedMeal = null;
            } else {
                this.selectedMeal = meal;
            }
        },
    },
    mounted() {
      // Fetch meals when the component is mounted
      this.fetchMeals();
    },
  };
  </script>
  
  <style scoped>

    .search {
        margin-top: 1em;
        font-weight: lighter;
    }

    h2 {
        font-weight: bold;
    }

    .list {
        border: 1px solid #bebebe;
        border-radius: 0.5em;
    }

    .plus {
        margin-right: 0.25em;
        border-radius: 50%;
        padding: 0em 0.5em;
        font-size: 1em;
        background-color: #556B2F;
        color: white;
        display: flex;
        align-items: center;
    }

    .showMeals {
        display: flex;
    }

    .showMeals input {
        margin-left: auto;
        margin-right: 1em;
        width: 4em;
    }

    .meal-cell {
        cursor: pointer;
        transition: background-color 0.3s;
        padding: 0.5em;
        border-bottom: 1px solid #bebebe;
    }

    .meal-cell:last-child {
        border-bottom: none;
    }


    .selected-meal {
        background-color: #bebebe;
    }

    .selected-meal:last-child{
        border-bottom-left-radius: 0.5em;
        border-bottom-right-radius: 0.5em;
    }

    .selected-meal:first-child{
        border-top-left-radius: 0.5em;
        border-top-right-radius: 0.5em;
    }

    .noResult {
        display: flex;
        justify-content: center;
        align-items: top;
    }

  </style>