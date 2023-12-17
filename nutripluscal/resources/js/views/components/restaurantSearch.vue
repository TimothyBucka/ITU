<template>
    <div class="form-group">
        <label for="search">{{ label }}</label>
        <div class="bar">
            <input id="search" type="text" class="form-control" :placeholder="placeholder" v-model="query">
            <div class="icon">
                <font-awesome-icon icon="magnifying-glass" />
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';

export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            required: true,
        },
        api_url: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            query: "",
            results: [],
        }
    },
    watch: {
        query(after, before) {
            this.search();
        }
    },
    methods: {
        search() {
            if (this.query.length <= 0) {
                this.$emit('search', null);
                return;
            }
            axios.post(this.api_url, {
                query: this.query
            }).then(response => {
                this.results = response.data.data;
                this.$emit('search', this.results);
            });
        }
    }
}
</script>

<style scoped>
    .bar {
        display: flex;
        align-items: center;
    }

    .icon {
        margin-left: .5rem;
        color: darkolivegreen;
    }
</style>