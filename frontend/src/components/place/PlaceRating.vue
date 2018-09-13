<template>
    <div class="rating-wrapper">
        <div
            :class="[
                'rating',
                'rating-' + ratingCategory
            ]"
        >
            <div
                class="onerow rating-value"
            >
                {{ value | formatRating(showMax) }}<span v-if="showMax"> / 5</span>
            </div>
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
        formatRating(number, showMax) {
            let minDigits = 1;
            let maxDigits = 1;

            if (number === 5 && showMax) {
                minDigits = 0;
                maxDigits = 0;
            }

            return new Intl.NumberFormat(
                'en-US', {
                    minimumFractionDigits: minDigits,
                    maximumFractionDigits: maxDigits,
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
        padding: 5px 10px;

        white-space: nowrap;
        vertical-align: middle;
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

    .rating-value {
        font-size: 1.2rem;
    }

    .onerow {
        margin-top: 3px;
    }
}
</style>
