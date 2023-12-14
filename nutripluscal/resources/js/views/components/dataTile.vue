<template>
    <OnClickOutside @trigger="clickedOut">
        <div class="tile p-2 m-2" @mouseenter="showEditButton" @mouseleave="hideEditButton" @mousedown="tileClicked">
            {{ Name }}
            <div class="value" v-if="edit">
                <input type="number" class="form-control me-1" v-model="changeValue" />
                {{ Unit }}
            </div>
            <div class="value" v-else>
                <span class="me-1">{{ Value }}</span> {{ Unit }}
            </div>
            <button v-if="button === 'Edit' && Editable" @click="toggleEditMode">
                Edit
            </button>
            <button v-else-if="button === 'Save' && Editable" @click="saveChanges">
                Save
            </button>
        </div>
    </OnClickOutside>
</template>

<script scoped>
import axios from "axios";

export default {
    name: "dataTile",
    props: ["Name", "DB_name", "Value", "Unit", "Editable"],
    data() {
        return {
            edit: false,
            button: "",
            changeValue: this.Value,
        };
    },
    methods: {
        tileClicked() {
            if (!this.edit) {
                this.button = "Edit";
            }
        },
        clickedOut() {
            this.edit = false;
            this.button = "";
            this.changeValue = this.Value;
        },
        showEditButton() {
            if (!this.edit) {
                this.button = "Edit";
            }
        },
        hideEditButton() {
            if (!this.edit) {
                this.button = "";
            }
        },
        toggleEditMode() {
            this.edit = true;
            this.button = "Save";
        },
        saveChanges() {
            if (this.changeValue <= 0) {
                alert("Invalid value");
                return;
            }

            axios
                .put("/api/body/1", {
                    [this.DB_name]: this.changeValue,
                })
                .then(() => {
                    this.$emit("body-data-updated");
                })
                .catch((error) => {
                    console.error(error);
                });

            this.edit = false;
            this.button = "";
        },
    },
};
</script>

<style scoped>
.tile {
    width: 150px;
    height: 150px;
    background-color: darkolivegreen;
    color: white;
    border-radius: 5px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    text-align: center;
    cursor: pointer;
}

button {
    border-radius: 5px;
    border: none;
    background-color: white;
    color: darkolivegreen;
}

.value {
    display: flex;
    flex-grow: 1;
    justify-content: center;
    align-items: center;
    font-size: 2rem;
}
</style>
