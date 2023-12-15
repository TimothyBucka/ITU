<template>
    <div>
        <h1 class="py-3">Your meals</h1>

        <div class="container">
            <h4 class="py-3">Meals created by you</h4>
            <ol class="list-group list-group-numbered">
                <div class="" v-for="(meal, index) in added_meals" :key="index">
                    <li class="list-group-item py-3 px-4 d-flex align-items-center">{{ meal.name }}</li>
                </div>
            </ol>
            <div v-if="this.pagination_last_page != null && this.pagination_last_page > 1">
                <button class="btn btn-primary" @click="previousPage">Previous</button>
                <button class="btn btn-primary" @click="nextPage">Next</button>
            </div>

            <h4 class="py-3">Add your own meal</h4> <!--TODO in mobile version this exclude from it-->
            <div class="buttons">
                <a class="btn btn-primary" href="#" @click="showModal">Create Meal</a>
            </div>

            <transition name="fade">
                <div v-if="showModal_var" class="modal">
                    <div class="modal-content">
                        <span class="close" @click="closeModal">&times;</span>
                        <p>Create a meal:</p>
                        <div class="meal-params">
                            <div>
                                <div class="meal-modal-div">
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" v-model="meal_arams.name"><br>
                                    <label for="calories">Calories:</label>
                                    <input type="number" id="calories" v-model="meal_arams.calories"><br>
                                    <label for="proteins">Proteins:</label>
                                    <input type="number" id="proteins" v-model="meal_arams.proteins"><br>
                                    <label for="carbs">Carbs:</label>
                                    <input type="number" id="carbs" v-model="meal_arams.carbs"><br>
                                    <label for="fat">Fat:</label>
                                    <input type="number" id="fat" v-model="meal_arams.fats"><br>
                                    <label for="fibres">Fibres:</label>
                                    <input type="number" id="fibres" v-model="meal_arams.fibers"><br>
                                </div>
                            </div>
                        </div>
                        <button @click="modalCreateMeal">Add</button>
                    </div>
                </div>
            </transition>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            showModal_var: false,
            added_meals: [], // list of added meals for showing purposes
            pagination_page: 1,
            pagination_last_page: null,
            meal_arams: {
                name: '',
                photo_path: '',
                proteins: 0,
                calories: 0,
                carbs: 0,
                fats: 0,
                fibers: 0
            }
        }
    },

    created() {
        this.showCreatedMeals();
    },

    methods: {
        showModal() {
            this.showModal_var = true;
        },

        closeModal() {
            this.showModal_var = false;
        },

        modalCreateMeal() {
            // chceck if all digit params are positive numbers
            let has_negative = false; // flag to check if there are any negative numbers

            // check if all digit params are positive numbers
            for (let key in this.meal_arams) {
                if (key == 'name' || key == 'photo_path') continue;

                // reset the negative numbers all to 0
                if (this.meal_arams[key] < 0) {
                    this.meal_arams[key] = 0;
                    has_negative = true;
                }
            }

            if (has_negative) {
                this.$toast.error('Digit parameters must be positive numbers', {
                    position: 'top-right',
                    timeout: 2000,
                    closeOnClick: true,
                    pauseOnHover: true,
                });
                return;
            }

            axios
                .post('/api/create/meal/', this.meal_arams)
                .then(response => {

                    this.$toast.success(response.data.message, { // notification
                        position: 'top-right',
                        duration: 2500,
                        closeOnClick: true,
                        pauseOnHover: true,
                    });
                    this.closeModal();
                })
                .catch(error => {
                    console.log(error);
                    this.$toast.error(error.response.data.message, {
                        position: 'top-right',
                        timeout: 2000,
                        closeOnClick: true,
                        pauseOnHover: true,
                    });
                });
            this.showCreatedMeals(); // refresh the page when the meal is added
        },

        showCreatedMeals() {
            this.added_meals = [];
            axios
                .get('/api/meals?page=' + this.pagination_page)
                .then(response => {
                    this.added_meals = response.data.data;
                    this.pagination_last_page = response.data.meta.last_page;
                    
                })
                .catch(error => {
                    console.log(error);
                });
        },
        nextPage() {
            if (this.pagination_page < this.pagination_last_page) {
                this.pagination_page++;
                this.showCreatedMeals();
            }
        },
        previousPage() {
            if (this.pagination_page > 1) {
                this.pagination_page--;
                this.showCreatedMeals();
            }



        }
    }
}
</script>

<style scoped>
.container {
    max-width: 90%;
    margin: auto;
}

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

.fade-enter-active,
.fade-leave-active {
    transition: opacity .5s;
}

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

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
}

.meal-params {
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

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>