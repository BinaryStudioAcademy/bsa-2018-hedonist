<template>
    <i
        :class="['far', 'fa-2x', icon, selected]"
        @mouseover="$emit('onHover', value)"
        @mouseout="$emit('onOut', value)"
        @click="$emit('onSelect', value)"
    />    
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
i {
    border-radius: 50%;

    &:hover {
        background-color: yellow;
        cursor: pointer;
    }
}
</style>
