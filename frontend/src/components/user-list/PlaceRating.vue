<template>
    <div class="rating" :style="[size,background]">
        {{rating}}
    </div>
</template>

<script>
    export default {
        name: "PlaceRating",
        data() {
            return {}
        },
        props: {
            rating: {
                required: true,
                type: Number,
                validator: (rating) => (rating >= 0 && rating <= 10)
            },
            side: {
                required: false,
                type: Number,
                default: 32
            }
        },
        computed: {
            size: function () {
                return {
                    width: this.side + 'px',
                    height: this.side + 'px',
                    lineHeight: this.side + 'px'
                };
            },
            background: function(){
                if (this.rating >= 8) {
                    return {background: '#00E676'};
                } else if (this.rating >= 6) {
                    return {background: '#C6FF00'};
                } else if (this.rating >= 4) {
                    return {background: '#FFD600'};
                } else {
                    return {background: '#FF3D00'};
                }
            }
        }
    }
</script>

<style scoped>
    .rating {
        border-radius: 7px;
        line-height: 32px;
        font-size: 1rem;
        color: #FFF;
        text-align:center;
        font-weight: bold;
    }
</style>