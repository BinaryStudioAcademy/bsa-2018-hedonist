<template>
    <div class="rating-wrapper">
        <div
            :class="[
                'rating',
                'rating-' + ratingCategory
            ]"
        >
            {{ value | formatRating }}

            <sup v-if="showMax">/5</sup>
        </div>

        <div class="place-rate__mark-count" v-if="showRating">
            {{ ratingCount || 'No' }} marks
        </div>
    </div>
</template>

<script>
export default {
    name: 'PlaceRating',

    props: {
        value: {
            required: true,
            type: Number
        },

        showMax: {
            type: Boolean
        },

        showRating: {
            type: Boolean
        },

        ratingCount: {
            required: this.showRating,
            type: Number,
            default: 0.0
        }
    },

    computed: {
        ratingCategory() {
            let placeRating = this.value;

            if (placeRating < 3) return 'bad';
            if (placeRating >= 3 && placeRating < 4) return 'okay';
            if (placeRating >= 4) return 'good';
        },
    },

    filters: {
        formatRating(number) {
            return new Intl.NumberFormat(
                'en-US', {
                    minimumFractionDigits: 1,
                    maximumFractionDigits: 1,
                }).format(number);
        },
    },
};
</script>

<style lang="scss" scoped>
.rating-wrapper{
    display: flex;
    align-items: center;

    .rating {
        border-radius: 7px;
        line-height: 32px;
        font-size: 1rem;
        color: #FFF;
        text-align: center;
        padding: 0 5px;
        height: 48px;

        &-bad {
            background-color: #FC8D9F;
        }

        &-okay {
            background-color: #FFA500;
        }

        &-good {
            background-color: #00B551;
        }
    }

    .place-rate__mark-count {
        margin-left: 15px;
    }
}
</style>
