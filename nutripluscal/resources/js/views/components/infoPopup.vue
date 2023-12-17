<!-- 
######################################### FILE: infoPopup.vue ###############################################
Authors: Tobias Stec (xstect00)
###############################################################################################################  
-->
<template>
    <button class="btn foodbtn" @click="showPopup = !showPopup">
        <font-awesome-icon icon="info-circle" />
    </button>
    <div v-if="showPopup" class="info-popup">
      <div class="popup-content">
        <div class="header">
            <h2>{{ meal.name }}</h2>
            <span class="close" @click="closePopup">&times;</span>
        </div>
        <div class="body">
                <strong>Calories:</strong> {{ meal.calories*portion }} kcal<br>
                <strong>Proteins:</strong> {{ meal.proteins*portion }}g<br>
                <strong>Fibers:</strong> {{ meal.fibers*portion }}g<br>
                <strong>Fats:</strong> {{ meal.fats*portion }}g<br>
                <strong>Carbs:</strong> {{ meal.carbs*portion }}g
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        props: {
            meal: {
                required: true,
            },
            portion: {
                required: true,
            },
        },
        data() {
            return {
                showPopup: false,
            };
        },
        methods: {
            closePopup() {
                this.showPopup = false;
            },

        },
    };
</script>
  
<style scoped>
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
  