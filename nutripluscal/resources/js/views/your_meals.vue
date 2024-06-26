<!-- 
######################################### FILE: your_meals.vue ###############################################
Authors: Adam Pap (xpapad11)
############################################################################################################## 
-->
<template>
    <h1 class="py-3">Your meals</h1>

    <div class="container">
        <div class="buttons">
            <a class="btn btn-primary" href="#" @click="showModal(false)">Create Meal</a>
        </div>

        <h4>Meals created by you</h4>
        <div v-for="(meal, index) in added_meals" :key="index">
            <mealTile :Data="meal" :Index="index" Type="your_meals" @deleteCreatedMeal="deleteCreatedMeal"
                @showEditModal="showEditModal"></mealTile>
        </div>
        <div v-if="this.pagination_last_page != null && this.pagination_last_page > 1">
            <button class="btn btn-primary" @click="previousPage">Previous</button>
            <button class="btn btn-primary" @click="nextPage">Next</button>
        </div>

        <transition name="fade">
            <div v-if="showModal_var" class="modal">
                <div class="modal-content">
                    <div class="header">
                        <p v-if="!this.is_editing_modal">Create a meal:</p>
                        <p v-else>Edit a meal:</p>
                        <span class="close" @click="closeModal">&times;</span>
                    </div>

                    <div class="meal-params">
                        <div>
                            <div class="meal-modal-div">
                                <div class="change">
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" v-model="meal_params.name" placeholder="Name"><br>
                                </div>
                                <div class="change">
                                    <label for="calories">Calories: (kcal)</label>
                                    <input type="number" id="calories" v-model="meal_params.calories" placeholder="Calories" ><br>
                                </div>
                                <div class="change">
                                    <label for="proteins">Proteins: (grams)</label>
                                    <input type="number" id="proteins" v-model="meal_params.proteins" placeholder="Proteins" ><br>
                                </div>
                                <div class="change">                         
                                    <label for="carbs">Carbs: (grams)</label>
                                    <input type="number" id="carbs" v-model="meal_params.carbs" placeholder="Carbs"><br>
                                </div>
                                <div class="change">
                                    <label for="fat">Fats: (grams)</label>
                                    <input type="number" id="fat" v-model="meal_params.fats" placeholder="Fats"><br>
                                </div>
                                <div class="change">
                                    <label for="fibres">Fibres: (grams)</label>
                                    <input type="number" id="fibres" v-model="meal_params.fibers" placeholder="Fibers"><br>
                                </div>
                                <div class="change">
                                    <label for="photo_path">Photo</label>
                                    <input type="file" id="photo_path" @change="handleFileUpload($event)" placeholder="Photo URL"><br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <button class="btn btn-primary" v-if="!this.is_editing_modal" @click="modalCreateMeal">Add</button>
                        <button class="btn btn-primary" v-else @click="modalUpdateMeal">Edit</button>
                    </div>

                </div>
            </div>
        </transition>

    </div>
</template>

<script>
import axios from 'axios';
import mealTile from "./components/mealTile.vue";

export default {
    data() {
        return {
            showModal_var: false,
            is_editing_modal: false, // flag to check if the modal is for editing or creating the meal
            added_meals: [], // list of added meals for showing purposes
            pagination_page: 1,
            pagination_last_page: null,
            meal_id_for_editing: null,
            meal_params: {
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

    components: {
        mealTile
    },

    methods: {
        handleFileUpload(event) { // handle the file upload for the meal
            this.meal_params.photo_path = event.target.files[0];
        },

        showModal(editing) { // show the modal for creating meals
            this.showModal_var = true;
            this.is_editing_modal = editing;

        },

        showEditModal(meal_id) {
            this.meal_id_for_editing = meal_id;
            axios
                .get('/api/meals/' + meal_id)
                .then(response => {
                    this.meal_params = response.data.data;
                    this.is_editing_modal = true;
                    this.showModal(this.is_editing_modal);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        closeModal() {
            this.showModal_var = false;

            // reset the meal_params
            this.meal_params = {
                name: '',
                photo_path: '',
                proteins: 0,
                calories: 0,
                carbs: 0,
                fats: 0,
                fibers: 0
            };
        },

        modalCreateMeal() { // create a meal from the modal
            let has_negative = false; // flag to check if there are any negative numbers
            let formData = new FormData(); // beacuse of the image upload and the post sends only JSON 

            // check if all digit params are positive numbers
            for (let key in this.meal_params) {
                if (key == 'name' || key == 'photo_path') continue;

                // reset the negative numbers all to 0
                if (this.meal_params[key] < 0) {
                    this.meal_params[key] = 0;
                    has_negative = true;
                }
            }

            if (has_negative) {
                this.$toast.error('Digit parameters must be positive numbers', {
                    position: 'bottom-right',
                    timeout: 2000,
                    closeOnClick: true,
                    pauseOnHover: true,
                });
                return;
            }

            formData.append('photo', this.meal_params.photo_path); // Append the photo to the formData instance

            // Append the other parameters to the formData instance
            for (let key in this.meal_params) {
                if (key != 'photo_path') {
                    formData.append(key, this.meal_params[key]);
                }
            }

            axios
                .post('/api/create/meal/', formData)
                .then(response => {
                    this.showCreatedMeals(); // refresh the page when the meal is added

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
                    this.$toast.error(error.response.data.message, {
                        position: 'bottom-right',
                        timeout: 2000,
                        closeOnClick: true,
                        pauseOnHover: true,
                    });
                });
        },

        modalUpdateMeal() {
            let formData = new FormData();
            formData.append('photo', this.meal_params.photo_path); // Append the photo to the formData instance

            // Append the other parameters to the formData instance
            for (let key in this.meal_params) {
                formData.append(key, this.meal_params[key]); // add also the photo path to delete the old image
            }

            axios
                .post('/api/update/created_meals/' + this.meal_id_for_editing, formData)
                .then(response => {
                    this.showCreatedMeals(); // refresh the page when the meal is updated

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
                    this.$toast.error(error.response.data.message, {
                        position: 'bottom-right',
                        timeout: 2000,
                        closeOnClick: true,
                        pauseOnHover: true,
                    });
                });
        },

        deleteCreatedMeal(meal_id) {
            axios
                .post('/api/meals/delete/' + meal_id)
                .then(response => {
                    this.showCreatedMeals(this.selected_date); // refresh it after added to show the new data

                    this.$toast.success(response.data.message, { // notification
                        position: 'bottom-right',
                        duration: 2500,
                        closeOnClick: true,
                        pauseOnHover: true,
                    });
                })
                .catch(error => {
                    console.log(error);
                    this.$toast.error(error.response.data.message, {
                        position: 'bottom-right',
                        timeout: 2000,
                        closeOnClick: true,
                        pauseOnHover: true,
                    });
                });
        },

        showCreatedMeals() { // show the meals created by the user in the list (not in modal)
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
    margin-bottom: 1rem;
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

.created-meals-buttons {
    display: flex;
    justify-content: space-between;
}

.rest-cover {
    flex: 1;
    background-size: cover;
    background-position: center;
}

.meal-image {
    width: 125px;
    height: 100px;


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
    max-width: 90%;
    min-width: 50%;
}

.modal-content p {
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0;
}

.meal-params {
    max-height: auto;
    min-height: 60%;
    overflow-y: auto;
}

.meal-modal-div {
    min-width: 100%;
    cursor: pointer;
    flex: 1;
}

.header {
    min-width: 95%;
    display: flex;
    justify-content: space-between;
}

.close {
    color: #aaaaaa;
    font-size: 3em;
    font-weight: bold;
    position: relative;
    top: -30px;
    right: -5px;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.change {
    display: grid;
    align-items: center;
    margin: 10px;
}

.change label {
    font-size: 1.25em;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.buttons {
    display: flex;
    justify-content: flex-end;
}

.buttons button {
    min-width: 12em;
    margin: 0;
}

@media (max-width: 768px) {
    .buttons {
        justify-content: center;
    }

    .change label {
        font-size: 1em;
    }
}
</style>