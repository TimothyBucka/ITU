<template>
    <div>
        <h1 class="py-3">Your meals</h1>

        <div class="container">
            <h4 class="py-3">Created meals by you</h4>
            <div>
                your meals ...
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
                                    <input type="text" id="name" v-model="mealParams.name"><br>
                                    <label for="calories">Calories:</label>
                                    <input type="number" id="calories" v-model="mealParams.calories"><br>
                                    <label for="proteins">Proteins:</label>
                                    <input type="number" id="proteins" v-model="mealParams.proteins"><br>
                                    <label for="carbs">Carbs:</label>
                                    <input type="number" id="carbs" v-model="mealParams.carbs"><br>
                                    <label for="fat">Fat:</label>
                                    <input type="number" id="fat" v-model="mealParams.fats"><br>
                                    <label for="fibres">Fibres:</label>
                                    <input type="number" id="fibres" v-model="mealParams.fibers"><br>
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
            mealParams: {
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

    methods: {
        showModal() {
            this.showModal_var = true;
        },

        closeModal() {
            this.showModal_var = false;
        },

        modalCreateMeal() {
            // chceck if all digit params are positive numbers
            let hasNegative = false; // flag to check if there are any negative numbers

            // check if all digit params are positive numbers
            for (let key in this.mealParams) {
                if (key == 'name' || key == 'photo_path') continue;

                // reset the negative numbers all to 0
                if (this.mealParams[key] < 0) {
                    this.mealParams[key] = 0;
                    hasNegative = true;
                }
            }

            if (hasNegative) {
                this.$toast.error('All digit params must be positive numbers', {
                    position: 'top-right',
                    timeout: 2000,
                    closeOnClick: true,
                    pauseOnHover: true,
                });
                return;
            }

            axios
                .post('/api/create/meal/', this.mealParams)
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