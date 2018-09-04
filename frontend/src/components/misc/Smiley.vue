<template>
    <div class="smileys__item">
        <span>{{ value }}</span>
        <i
            :class="['far', 'fa-2x', icon, selected]"
            @mouseover="$emit('onHover', value)"
            @mouseout="$emit('onOut', value)"
            @click="$emit('onSelect', value)"
        />
    </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
    name: 'Smiley',

    props: {
        value: {
            type: Number,
            required: true
        },

        icon: {
            type: String,
            required: true
        },

        selected: {
            type: String,
            required: true
        },
    },
};
</script>

<style lang="scss" scoped>
    .smileys__item {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-right: 5px;

        &:last-child {
            margin-right: 0;
        }

        i {
            border-radius: 50%;

            &:hover {
                background-color: yellow;
                cursor: pointer;
            }
            &.chosenRating  {
                background-color: yellow;
            }
        }
    }
</style>
