<template>
    <div class="tile">
        <div class="rest-cover" v-bind:style="{ backgroundImage: 'url(' + getImageUrl(Data.photo_url) + ')' }"></div>
        <div class="rest-info">
            <h5>{{ Data.name }}</h5>
            <p>{{ Data.type }}</p>
        </div>
    </div>
</template>

<script scoped>
    export default {
        props: ["Data"],
        data() {
            return {};
        },
        methods: {
            getImageUrl(image) {
                const imageUrl = new URL('/public/img/' + image, import.meta.url);
                return imageUrl;
            }
        },
    }
</script>

<style scoped>
    .tile {
        display: flex;
        height: 200px;
        width: 250px;
        flex-direction: column;
        border-radius: 5px;
        overflow: hidden;
        border: 1px solid lightgrey;
        margin-right: .5rem;
    }

    .tile .rest-cover {
        flex: 1;
        background-size: cover;
        background-position: center;
    }

    .tile .rest-info {
        padding: 0.5em;
    }

    .tile .rest-info h5 {
        margin-bottom: 0;
        white-space: nowrap;
    }

    .tile .rest-info p {
        margin: 0;
        color: gray;
    }

</style>